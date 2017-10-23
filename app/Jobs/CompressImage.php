<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

use Log;

class CompressImage implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	protected $imagePath;
	// 	max number of times to attempt the compression job
	public $tries = 3;

	/**
	* Create a new job instance.
    *
    * @return void
    */
    public function __construct($imagePath)
    {
		//
		$this->imagePath = $imagePath;
	}
		
	/**
	* Execute the job.
    *
    * @return void
    */
    public function handle()
    {
		// 		https://tinypng.com/developers/reference/php
		
		// extract file name from $this->imagePath
		
		$temp = explode('/', $this->imagePath);
		$fileName = end($temp);

		\Tinify\setKey(config('afh.tinify_apikey'));
		$buffer = Storage::disk('local')->get($this->imagePath);
		
		/*
		** Use Tinify to compress source image file & return instance
		*/
		$source = \Tinify\fromBuffer($buffer);

		/*
		** Use Tinify to create the thumbnail image at config('afh.thumb_width') pixels wide
		*/
		$resized = $source->resize(array(
				                    "method" => "scale",
				                    "width" => intval(config('afh.thumb_width')),
				                ));
		// Persist the thumbnail image
		$resized->toFile(storage_path( 'app/' . config('afh.thumb_dir') . $fileName ));
		
		/*
		** Use Tinify to create the large image at config('afh.large_width') pixels wide
		*/
		$resized = $source->resize(array(
				                    "method" => "scale",
				                    "width" => intval(config('afh.large_width')),
								));
		
		// Persist the large image
		$resized->toFile(storage_path( 'app/' . config('afh.large_dir') . $fileName ));
		// Storage::delete('public/images/' . $this->imagePath);
	}
}
