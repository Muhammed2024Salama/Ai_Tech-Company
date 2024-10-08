<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'favicon' => $this->favicon ? asset('storage/app/public/' . $this->favicon) : null,
            'app_name' => $this->app_name,
            'app_status' => $this->app_status,
            'social_media' => $this->social_media,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
