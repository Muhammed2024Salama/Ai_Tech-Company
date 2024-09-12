<?php

namespace Ecommerce\Base\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait {

    /**
     * @param Request $request
     * @param $inputName
     * @param $path
     * @return string|void
     */
    public function uploadImage(Request $request, $inputName, $path)
    {
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $extension;

            $image->move(public_path($path), $imageName);

            return '/uploads/' . $imageName;
        }
    }

    /**
     * @param Request $request
     * @param $inputName
     * @param $path
     * @return array|void
     */
    public function uploadMultiImage(Request $request, $inputName, $path)
    {
        $imagePaths = [];

        if($request->hasFile($inputName)){

            $images = $request->{$inputName};

            foreach($images as $image){

                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_'.uniqid().'.'.$ext;

                $image->move(public_path($path), $imageName);

                $imagePaths[] =  $path.'/'.$imageName;
            }

            return $imagePaths;
        }
    }

    /**
     * @param Request $request
     * @param $inputName
     * @param $path
     * @param $oldPath
     * @return string|void
     */
    public function updateImage(Request $request, $inputName, $path , $oldPath=null)
    {
        if ($request->hasFile($inputName)) {
            /** Check File If Exists Or Not If Exists Delete Old  */
            if (File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }

            $image = $request->file($inputName);
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $extension;

            $image->move(public_path($path), $imageName);

            return '/uploads/' . $imageName;
        }
    }

    /**
     * Handle Delete File
     * @param string $path
     * @return void
     */
    public function deleteImage(string $path)
    {
        /** Check File If Exists Or Not If Exists Delete Old  */
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
