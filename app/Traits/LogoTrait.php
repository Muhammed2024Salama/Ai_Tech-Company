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
            $path = $logoFile->store('logos', 'public');
            return $path;
        }
        return null;
    }
}
