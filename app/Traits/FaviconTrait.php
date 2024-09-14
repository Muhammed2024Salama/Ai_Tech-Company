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
            /**
             * Save the favicon in 'public/favicon' folder
             */
            $path = $faviconFile->store('favicon', 'public');
            return $path;
        }
        return null;
    }
}
