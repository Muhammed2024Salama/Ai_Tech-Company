<?php

use App\Events\MessageSent;
use App\Http\Controllers\Api\{
    ApiUserController,
    ChartController,
    CommentController,
    PostController,
    SettingController
};
use App\Http\Controllers\Api\Authentications\Controllers\AuthController;
use App\Http\Controllers\Api\Roles\Controllers\ApiRoleController;
use App\Http\Requests\SendCommentNotificationRequest;
use App\Mail\CommentNotification;
use App\Models\Api\{Comment, Post, User};
use App\Models\Api\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Route};


/**
 * ------------------------------
 * Authentication Routes
 * ------------------------------
 * Routes for user registration, login, and profile management.
 * These routes are prefixed with 'auth' and use AuthController for handling authentication.
 */
Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', 'userProfile');
            Route::get('logout', 'userLogout');
        });
    });
});


/**
 * ------------------------------
 * Protected API Resource Routes
 * ------------------------------
 * These routes provide standard CRUD operations for various resources (roles, posts, comments, settings, and users).
 * Access to these routes is restricted and requires Sanctum authentication.
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'roles' => ApiRoleController::class,
        'posts' => PostController::class,
        'posts.comments' => CommentController::class,
        'settings' => SettingController::class,
        'users' => ApiUserController::class,
    ]);

    /**
     * Get line chart data - requires authentication.
     */
    Route::get('/line-chart-data', [ChartController::class, 'lineChartData']);
});


/**
 * ------------------------------
 * Public Routes
 * ------------------------------
 * These routes are accessible to anyone without the need for authentication.
 *
 * Route to check the app's status (publicly accessible)
 */
Route::get('/app-status', [SettingController::class, 'checkAppStatus']);

Route::post('/send-comment-notification', function (SendCommentNotificationRequest $request) {
    $post = Post::findOrFail($request->post_id);
    $comment = Comment::findOrFail($request->comment_id);

    Mail::to($request->input('email'))->send(new CommentNotification($post, $comment));

    return response()->json(['message' => 'Email sent successfully!'], 200);
});

/**
 * Chat Message Routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * Create a new message
     */
    Route::post('/messages/{friend}', function (User $friend, Request $request) {
        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $friend->id,
            'text' => $request->input('message')
        ]);

        /**
         * Broadcasting the message event
         */
        broadcast(new MessageSent($message));

        return response()->json($message);
    });

    /**
     * Get all messages between authenticated user and specified friend
     */
    Route::get('/messages/{friend}', function (User $friend) {
        $messages = ChatMessage::query()
            ->where(function ($query) use ($friend) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($query) use ($friend) {
                $query->where('sender_id', $friend->id)
                    ->where('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($messages);
    });

    /**
     * Update an existing message
     */
    Route::put('/messages/{message}', function (ChatMessage $message, Request $request) {
        if (auth()->id() !== $message->sender_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update($request->only('text'));

        return response()->json($message);
    });

    /**
     * Delete a message
     */
    Route::delete('/messages/{message}', function (ChatMessage $message) {
        if (auth()->id() !== $message->sender_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['success' => 'Message deleted']);
    });
});
