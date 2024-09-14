<?php

namespace App\Traits;

trait LogoTrait
{
    /**
     * Handle the logo upload and return the path.
     *
     * @param  $logoFile
     * @return string|null
     */
    public function handleLogoUpload($logoFile)
    {
        if ($logoFile) {
            /**
             * Save the logo in 'public/logo' folder
             */
            $path = $logoFile->store('logo', 'public');
            return $path;
        }
        return null;
    }
}
