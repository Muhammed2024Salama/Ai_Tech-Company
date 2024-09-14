<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Api\Setting;
use App\Traits\FaviconTrait;
use App\Traits\LogoTrait;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    use LogoTrait, FaviconTrait;

    /**
     * Display a listing of the settings.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $settings = Setting::all();
        return ResponseHelper::success('success', null, SettingResource::collection($settings));
    }

    /**
     * Display the specified setting.
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function show(Setting $setting): JsonResponse
    {
        return ResponseHelper::success('success', null, new SettingResource($setting));
    }

    /**
     * Store a newly created setting in storage.
     *
     * @param StoreSettingRequest $request
     * @return JsonResponse
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $setting = Setting::create($validated);

        if ($request->hasFile('logo')) {
            $logoPath = $this->handleLogoUpload($request->file('logo')); // Corrected method name
            $setting->logo = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $this->handleFaviconUpload($request->file('favicon')); // Corrected method name
            $setting->favicon = $faviconPath;
        }

        $setting->save();

        return ResponseHelper::success('success', 'Setting created successfully.', new SettingResource($setting), 201);
    }

    /**
     * Update the specified setting in storage.
     *
     * @param UpdateSettingRequest $request
     * @param Setting $setting
     * @return JsonResponse
     */
    public function update(UpdateSettingRequest $request, Setting $setting): JsonResponse
    {
        // dd($request->all());
        $validated = $request->validated();

        $setting->update($validated);

        if ($request->hasFile('logo')) {
            $logoPath = $this->handleLogoUpload($request->file('logo'));
            $setting->logo = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $this->handleFaviconUpload($request->file('favicon'));
            $setting->favicon = $faviconPath;
        }

        $setting->save();

        return ResponseHelper::success('success', 'Setting updated successfully.', new SettingResource($setting));
    }

    /**
     * Remove the specified setting from storage.
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function destroy(Setting $setting): JsonResponse
    {
        $setting->delete();
        return ResponseHelper::success('success', 'Setting deleted successfully.');
    }

    /**
     * Check if the application is active or inactive.
     *
     * @return JsonResponse
     */
    public function checkAppStatus(): JsonResponse
    {
        $setting = Setting::first();

        if (!$setting || !$setting->app_status) {
            return ResponseHelper::error('error', 'Application is currently inactive.');
        }

        return ResponseHelper::success('success', 'Application is active.');
    }
}
