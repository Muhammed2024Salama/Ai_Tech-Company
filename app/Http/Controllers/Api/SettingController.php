<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Interface\SettingInterface;
use App\Models\Api\Setting;
use App\Traits\FaviconTrait;
use App\Traits\LogoTrait;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    /**
     * @var SettingInterface
     */
    protected $settingRepo;

    /**
     * @param SettingInterface $settingRepo
     */
    public function __construct(SettingInterface $settingRepo)
    {
        $this->settingRepo = $settingRepo;

        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:setting-create', ['only' => ['store']]);
        $this->middleware('permission:setting-edit', ['only' => ['update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $settings = $this->settingRepo->getAllSettings();
        return ResponseHelper::success('success', null, SettingResource::collection($settings));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $setting = $this->settingRepo->getSettingById($id);
        return ResponseHelper::success('success', null, new SettingResource($setting));
    }

    /**
     * @param StoreSettingRequest $request
     * @return JsonResponse
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $setting = $this->settingRepo->createSetting($validated);

        return ResponseHelper::success('success', 'Setting created successfully.', new SettingResource($setting), 201);
    }

    /**
     * @param UpdateSettingRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSettingRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $setting = $this->settingRepo->getSettingById($id);
        $updatedSetting = $this->settingRepo->updateSetting($setting, $validated);

        return ResponseHelper::success('success', 'Setting updated successfully.', new SettingResource($updatedSetting));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $setting = $this->settingRepo->getSettingById($id);
        $this->settingRepo->deleteSetting($setting);
        return ResponseHelper::success('success', 'Setting deleted successfully.');
    }

    /**
     * @return JsonResponse
     */
    public function checkAppStatus(): JsonResponse
    {
        $isActive = $this->settingRepo->checkAppStatus();

        if (!$isActive) {
            return ResponseHelper::error('error', 'Application is currently inactive.');
        }

        return ResponseHelper::success('success', 'Application is active.');
    }
}
