<?php

namespace App\Helper;

/**
 * Class for image handling and manipulation
 * User: jvb
 * Date: 9/20/2017
 * Time: 11:48 AM
 */
class ImageHelper
{
    const SUFFIX_SMALL = '_s';
    const SMALL_WIDTH = 480;
    const SMALL_HEIGHT = 320;
    const SUFFIX_NORMAL = '_m';
    const NORMAL_WIDTH = 900;
    const NORMAL_HEIGHT = 600;
    const SUFFIX_LARGE = '_l';
    const LARGE_WIDTH = 1920;
    const LARGE_HEIGHT = 1080;
    const THUMBNAIL_SUFFIX = 'thumb';
    const FILE_EXTENSION = 'png';
    const RATIO = 1.5;

    /**
     * path of upload directory
     *
     * @var string
     */
    private $uploadDir;

    /**
     * path of upload thumbnail directory
     *
     * @var string
     */
    private $thumbnailSuf;

    /**
     * @param string $imagePath
     * @param string $fileName
     * @param string $file_ext
     */
    public static function createThumbnail($imagePath, $fileName, $file_ext = self::FILE_EXTENSION)
    {
        self::generateThumbnailSmall($imagePath, $fileName, $file_ext);
        self::generateThumbnailNormal($imagePath, $fileName, $file_ext);
        self::generateThumbnailLarge($imagePath, $fileName, $file_ext);
    }

    /**
     * Get thumbnail small name
     *
     * @param $imagePath
     *
     * @return string
     */
    public static function getThumbnailSmall($imagePath = null)
    {
        return self::getThumnailName($imagePath, self::SUFFIX_SMALL);
    }

    /**
     * Get thumbnail Normal name
     *
     * @param $imagePath
     *
     * @return string
     */
    public static function getThumbnailNormal($imagePath = null)
    {
        return self::getThumnailName($imagePath, self::SUFFIX_NORMAL);
    }

    /**
     * Get thumbnail large name
     *
     * @param $imagePath
     *
     * @return string
     */
    public static function getThumbnailLarge($imagePath = null)
    {
        return self::getThumnailName($imagePath, self::SUFFIX_LARGE);
    }

    /**
     * Generate small thumbnail from uploaded image
     *
     * @param string $upload_image path of image upload
     * @param string $fileName     name of image
     * @param string $file_ext     extention of image
     */
    private static function generateThumbnailSmall($upload_image, $fileName, $file_ext = self::FILE_EXTENSION)
    {
        list($width, $height) = getimagesize($upload_image);
        if (($width / $height) > self::RATIO) {
            //Caculate resize image height
            $resizeWidth = (int)(self::SMALL_WIDTH * $height / self::SMALL_HEIGHT);
            $srcX = ($width - $resizeWidth) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_SMALL, $file_ext,
                self::SMALL_WIDTH, self::SMALL_HEIGHT,
                $resizeWidth, $height,
                0, 0, $srcX, 0
            );
        } else {
            //Caculate resize image width
            $resizeHeight = (int)(self::SMALL_HEIGHT * $width / self::SMALL_WIDTH);
            $srcY = ($height - $resizeHeight) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_SMALL, $file_ext,
                self::SMALL_WIDTH, self::SMALL_HEIGHT,
                $width, $resizeHeight,
                0, 0, 0, $srcY
            );
        }
    }

    /**
     * Generate vertical thumbnail from uploaded image with largesize
     *
     * @param string $upload_image path of image upload
     * @param string $fileName     name of image
     * @param string $file_ext     extention of image
     */
    private static function generateThumbnailNormal($upload_image, $fileName, $file_ext = self::FILE_EXTENSION)
    {
        list($width, $height) = getimagesize($upload_image);
        if (($width / $height) > self::RATIO) {
            //Caculate resize image height
            $resizeWidth = (int)(self::NORMAL_WIDTH * $height / self::NORMAL_HEIGHT);
            $srcX = ($width - $resizeWidth) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_NORMAL, $file_ext,
                self::NORMAL_WIDTH, self::NORMAL_HEIGHT,
                $resizeWidth, $height,
                0, 0, $srcX, 0
            );
        } else {
            //Caculate resize image width
            $resizeHeight = (int)(self::NORMAL_HEIGHT * $width / self::NORMAL_WIDTH);
            $srcY = ($height - $resizeHeight) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_NORMAL, $file_ext,
                self::NORMAL_WIDTH, self::NORMAL_HEIGHT,
                $width, $resizeHeight,
                0, 0, 0, $srcY
            );
        }
    }

    /**
     * Generate thumbnail from uploaded image with largesize
     *
     * @param string $upload_image path of image upload
     * @param string $fileName     name of image
     * @param string $file_ext     extention of image
     */
    private static function generateThumbnailLarge($upload_image, $fileName, $file_ext = self::FILE_EXTENSION)
    {
        list($width, $height) = getimagesize($upload_image);
        if (($width / $height) > self::RATIO) {
            //Caculate resize image height
            $resizeWidth = (int)(self::LARGE_WIDTH * $height / self::LARGE_HEIGHT);
            $srcX = ($width - $resizeWidth) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_LARGE, $file_ext,
                self::LARGE_WIDTH, self::LARGE_HEIGHT,
                $resizeWidth, $height,
                0, 0, $srcX, 0
            );
        } else {
            //Caculate resize image width
            $resizeHeight = (int)(self::LARGE_HEIGHT * $width / self::LARGE_WIDTH);
            $srcY = ($height - $resizeHeight) / 2;
            self::generateThumbnail($upload_image, $fileName,
                self::SUFFIX_LARGE, $file_ext,
                self::LARGE_WIDTH, self::LARGE_HEIGHT,
                $width, $resizeHeight,
                0, 0, 0, $srcY
            );
        }
    }

    /**
     * Generate thumbnail from uploaded image
     *
     * @param string $image       path of image upload
     * @param string $fileName    name of image
     * @param string $suffix      suffix of image
     * @param string $file_ext    extension of image
     * @param int    $thumbWidth  width of thumbnail image
     * @param int    $thumbHeight height of thumbnail image
     * @param int    $width       width of source image
     * @param int    $height      height of source image
     * @param int    $dst_x       x-coordinate of destination point.
     * @param int    $dst_y       y-coordinate of destination point.
     * @param int    $src_x       x-coordinate of source point.
     * @param int    $src_y       y-coordinate of source point.
     */
    private static function generateThumbnail($image, $fileName, $suffix, $file_ext, $thumbWidth, $thumbHeight, $width, $height, $dst_x = 0, $dst_y = 0, $src_x = 0, $src_y = 0)
    {

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        $thumbnail = pathinfo($image, PATHINFO_DIRNAME) . '/' . $fileName . '_' . self::THUMBNAIL_SUFFIX . $suffix . '.' . $file_ext;
        $thumb_image = imagecreatetruecolor($thumbWidth, $thumbHeight);

        $whiteBg = imagecolorallocate($thumb_image, 255, 255, 255);
        imagefill($thumb_image, 0, 0, $whiteBg);

        try {
            switch ($fileExtension) {
                case 'jpg':
                    $source = imagecreatefromjpeg($image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($image);
                    break;
                default:
                    $source = imagecreatefrompng($image);
            }
        } catch (\Exception $e) {
            $source = imagecreatefromjpeg($image);
        };

        imagecopyresampled($thumb_image, $source, $dst_x, $dst_y, $src_x, $src_y, $thumbWidth, $thumbHeight, $width, $height);
        switch ($file_ext) {
            case 'jpg' || 'jpeg':
                imagejpeg($thumb_image, $thumbnail, 100);
                break;
            case 'png':
                imagepng($thumb_image, $thumbnail, 100);
                break;
            default:
                imagepng($thumb_image, $thumbnail, 100);
        }
        imagedestroy($thumb_image);
    }

    /**
     * Get name of thumbnail
     *
     * @param $imagePath
     * @param $suffix
     *
     * @return string/false
     */
    private static function getThumnailName($imagePath, $suffix)
    {
        if (!$imagePath) {
            return FALSE;
        }
        try {
            $imagePathInfo = pathinfo($imagePath);
            $thumbPath = $imagePathInfo['dirname'] . '/' . $imagePathInfo['filename'] . '_' . self::THUMBNAIL_SUFFIX . $suffix . '.' . self::FILE_EXTENSION;
            if (!file_exists($thumbPath)) {
                return FALSE;
            }
            return $thumbPath;
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    public static function generateImageUrl($imagePath)
    {
        if (!$imagePath) {
            $imagePath = URL_IMAGE_NO_AVATAR;
        }
        if (starts_with($imagePath, '/')) {
            $imagePath = ltrim($imagePath, '/');
        }
        if (!file_exists($imagePath)) {
            $imagePath = URL_IMAGE_NO_AVATAR;
        }
        return $imagePath;
    }

    public static function getImgThumbnail($imagePath, $type = null)
    {
        $imagePath = self::generateImageUrl($imagePath);
        if ($type === 0) {
            $suffix = self::SUFFIX_SMALL;
        } elseif ($type == 1) {
            $suffix = self::SUFFIX_NORMAL;
        } elseif ($type == 2) {
            $suffix = self::SUFFIX_LARGE;
        } else {
            $suffix = null;
        }
        if (empty($suffix)) {
            return $imagePath;
        }
        try {
            $imagePathInfo = pathinfo($imagePath);
            $thumbPath = $imagePathInfo['dirname'] . '/' . $imagePathInfo['filename'] . '_' . self::THUMBNAIL_SUFFIX . $suffix . '.' . self::FILE_EXTENSION;
            if (!file_exists($thumbPath)) {
                if ($type == 0) {
                    self::generateThumbnailSmall($imagePath, $imagePathInfo['basename']);
                } else if ($type == 1) {
                    self::generateThumbnailNormal($imagePath, $imagePathInfo['basename']);
                } else if ($type == 2) {
                    self::generateThumbnailLarge($imagePath, $imagePathInfo['basename']);
                } else {
                    return $imagePath;
                }
            }
            return '/' . $thumbPath;
        } catch (\Exception $e) {
            return $imagePath;
        }
    }

}
