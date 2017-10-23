<?php

namespace App\Http\Controllers;

use App\Jobs\CompressImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Log;

class ImageController extends Controller
{

    protected function getMimeType($mimeType)
    {
        /*
        | -------------------------------------------------------------------
        | MIME TYPES
        | -------------------------------------------------------------------
        | This file contains an array of mime types.  It is used by the
        | Upload class to help identify allowed file types.
        |
        */
        $mimeTypes = array(
            'image/gif' => 'gif',
            'image/jpeg' => 'jpeg',
            'image/png' => 'png',
            'image/x-png' => 'png',
            'image/svg+xml' => 'svg'
        );

        return $mimeTypes[$mimeType];
    }
    /**
     * Upload an image for the specified animal. Upload will be to the private directory storage/app/images.
     * The Tinify API will compress and resize the images into public directories via the call to dispatch().
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->file('file')->isValid()) 
        {
            $this->validate($request, [
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);

            $mimeType = $request->file('file')->getMimeType();
            
            $baseName = date("Y-m-d--B--") . pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $baseName . '.' . $this->getMimeType($mimeType);
            							
            $path = Storage::disk('local')->putFileAs(
                config('afh.upload_dir'),
            	$request->file('file'),
                $fileName
            );
            $exists = Storage::disk('local')->exists($path);
            Log::debug('ImageController.upload path: ' . $path . ' exists: '. $exists);
     
            /*
            ** $path should contain the path name of the file relative to storage/app
            */
            CompressImage::dispatch($path); // queue image for compression
// ---------------------------------------------------            
        
// ---------------------------------------------------            
            return $fileName;
        }
    }

    public function getImage($file)
    {
        $storagePath = config('afh.thumb_dir') . urldecode($file);
        Log::debug('getImage storagePath: ' . $storagePath);
        if (Storage::disk('public')->exists($storagePath)) {
	        $contents = Storage::disk('public')->get($storagePath);
	    } else {
        	$contents = Storage::disk('public')->get(config('afh.thumb_dir') . config('afh.default_image'));
        }

        return $contents;
    }
}
