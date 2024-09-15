<?php

namespace App\Interface;

use App\Models\Api\Setting;

interface SettingInterface
{
    /**
     * @return mixed
     */
    public function getAllSettings();

    /**
     * @param int $id
     * @return mixed
     */
    public function getSettingById(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function createSetting(array $data);

    /**
     * @param Setting $setting
     * @param array $data
     * @return mixed
     */
    public function updateSetting(Setting $setting, array $data);

    /**
     * @param Setting $setting
     * @return mixed
     */
    public function deleteSetting(Setting $setting);

    /**
     * @return mixed
     */
    public function checkAppStatus();
}
