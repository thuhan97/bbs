<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void createThumbnail($imagePath, $fileName, $file_ext = '')
 * @method static string getThumbnailSmall($imagePath = null)
 * @method static string getThumbnailNormal($imagePath = null)
 * @method static string getThumbnailLarge($imagePath = null)
 * @method static string generateImageUrl($imagePath)
 * @method static string getImgThumbnail($imagePath, $type = null)
 *
 * @see \App\Helpers\StringHelper
 */
class StringFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'string_helper';
    }
}
