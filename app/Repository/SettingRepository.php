<?php

namespace App\Repository;

use App\Interface\SettingInterface;
use App\Models\Api\Setting;
use App\Traits\FaviconTrait;
use App\Traits\LogoTrait;

class SettingRepository implements SettingInterface
{

    use LogoTrait, FaviconTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSettings()
    {
        return Setting::all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSettingById(int $id)
    {
        return Setting::findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createSetting(array $data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->handleLogoUpload($data['logo']);
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = $this->handleFaviconUpload($data['favicon']);
        }

        return Setting::create($data);
    }

    /**
     * @param Setting $setting
     * @param array $data
     * @return Setting
     */
    public function updateSetting(Setting $setting, array $data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->handleLogoUpload($data['logo']);
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = $this->handleFaviconUpload($data['favicon']);
        }

        $setting->update($data);
        return $setting;
    }

    /**
     * @param Setting $setting
     * @return void
     */
    public function deleteSetting(Setting $setting)
    {
        $setting->delete();
    }

    /**
     * @return bool
     */
    public function checkAppStatus()
    {
        $setting = Setting::first();
        return $setting && $setting->app_status;
    }
}
