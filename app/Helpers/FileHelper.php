<?php
/**
 * Created by PhpStorm.
 * User: TrinhNV
 * Date: 4/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

class FileHelper
{
    public static function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path));
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public static function makePath($path)
    {
        if (!file_exists($path))
            return mkdir($path, 0755, true);
        return true;
    }

    /**
     * @param $dirPath
     */
    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Function get mine file with type
     *
     * @return file info
     */
    public static function getMimeFile($image, $type = FILEINFO_MIME_TYPE)
    {
        $imgdata = base64_decode($image);
        $f = finfo_open();
        return finfo_buffer($f, $imgdata, $type);
    }
}
