<?php

namespace App\Traits;

trait FaviconTrait
{
    /**
     * Handle the favicon upload and return the path.
     *
     * @param  $faviconFile
     * @return string|null
     */
    public function handleFaviconUpload($faviconFile)
    {
        if ($faviconFile) {
            $path = $faviconFile->store('favicons', 'public');
            return $path;
        }
        return null;
    }
}
