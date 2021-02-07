<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

use \App\ModelAbstract as Model;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasImageTrait
{
    protected $imageHeight = 250, $imageWidth = 250, $acceptRatio = true;

    /**
     * Returns default image url. **GLOBAL**
     *
     * @return string
     * @static
     */
    public static function getDefaultModelImage()
    {
        return (string) config('app.default_model_image');
    }

    /**
     * Returns default image url.
     *
     * @return string
     */
    public function getDefaultImage()
    {
        return (string) self::getDefaultModelImage();
    }


    /**
     * Check if request has image
     * $this->requestHasModelImage()
     *
     * @param string $requestFileName
     *
     * @return bool
     */
    public function requestHasModelImage($requestFileName = 'image'): bool
    {
        return
            (request()->hasFile($requestFileName) && request()->file($requestFileName)->isValid()) ||
            (request()->get($requestFileName) && is_string(request()->get($requestFileName)));
    }

    /**
     * $this->addModelImage()
     *
     * @param $requestFileName
     *
     * @return void
     */
    public function addModelImage($requestFileName = 'image')
    {
        /**
         * File Upload
         */
        if (request()->hasFile($requestFileName) && request()->file($requestFileName)->isValid()) {
            #
            $this->clearMediaCollection(self::IMAGE_TAG);
            $file = $this->addMediaFromRequest($requestFileName)->toMediaCollection(self::IMAGE_TAG);
        } else if (request()->get($requestFileName) && is_string(request()->get($requestFileName))) {
            #
            try {
                $data = explode(';', request()->get($requestFileName));
                if (starts_with(end($data), 'base64')) {
                    $this->clearMediaCollection(self::IMAGE_TAG);
                    $file = $this->addMediaFromBase64(request()->get($requestFileName))->toMediaCollection(self::IMAGE_TAG);
                }
            } catch (\Exception $exception) {
            }
        }

//        d(
//            $file
//        );
    }

    /**
     * $this->addModelImage()
     *
     * @param string $requestFileName
     * @param string $collection_name
     *
     * @return $this
     */
    public function pushMedia($requestFileName = 'image', $collection_name)
    {
        /**
         * File Upload
         */
        if (request()->hasFile($requestFileName) && request()->file($requestFileName)->isValid()) {
            $file = $this->addMediaFromRequest($requestFileName)->toMediaCollection($collection_name);
        } else if (request()->get($requestFileName) && is_string(request()->get($requestFileName))) {
            try {
                $data = explode(';', request()->get($requestFileName));
                if (starts_with(end($data), 'base64')) {
                    $file = $this->addMediaFromBase64(request()->get($requestFileName))->toMediaCollection($collection_name);
                }
            } catch (\Exception $exception) {
            }
        }

        return $this;
    }

    /**
     * $this->addModelImageIfExist()
     *
     * @param string $requestFileName
     *
     * @return Model|$this
     */
    public function addModelImageIfExist($requestFileName = 'image')
    {
        try {
            if ($this->requestHasModelImage($requestFileName))
                $this->addModelImage($requestFileName);
        } catch (\Exception $exception) {
        }

        /** @var Model $this */
        return $this;
    }

    /**
     * $this->hasModelImage()
     *
     * @return bool
     */
    public function hasModelImage()
    {
        return $this->hasMedia(self::IMAGE_TAG) === true;
    }

    /**
     * $this->addModelImageUrl()
     *
     * @param $value
     *
     * @return void
     */
    public function addModelImageUrl($url)
    {
        /**
         * File Upload
         */
        if ($url) {
            $this->clearMediaCollection(self::IMAGE_TAG);
            $this->addMediaFromUrl($url)->toMediaCollection(self::IMAGE_TAG);
        }
    }

    /**
     * Usage: $this->model_image_html
     *
     * ---
     * **Attributes:**
     * ---
     * 1. **target**    *bool|string*
     * -- HTML `<a>` target attribute.
     *
     *      -- **default:** _blank
     *
     * 2. **href**      *bool|string*
     * -- HTML `<a>` href attribute.
     *
     *      -- **default:** false
     *
     * 3. **aclass**      *bool|string*
     * -- HTML `<a>` class attribute.
     *
     *      -- **default:** false
     *
     * 4. **width**     *bool|string*
     * -- HTML `<img>` width attribute.
     *
     *      -- **default:** 100px
     *
     *
     * 5. **height**    *bool|string*
     * -- HTML `<img>` height attribute.
     *
     *      -- **default:** false
     *
     * 6. **class**      *bool|string*
     * -- HTML `<img>` class attribute.
     *
     *      -- **default:** img-fluid
     *
     * 7. **src**       *null|string*
     * -- HTML `<img>` src attribute.
     *
     *      -- **default:** null. <<*null*>> Means <<*$this->model_image*>>
     *
     *
     * @param array $attributes Html Tag attributes.
     *
     * @return string
     */
    public function getModelImageHtmlAttribute($attributes = [])
    {
        $attributes = $attributes instanceof Arrayable ? $attributes->toArray() : ($attributes ?: [
            'target' => '_blank',
            'href' => false,
            'aclass' => false,
            'width' => '100px',
            'height' => false,
            'class' => 'img-fluid',
            'src' => null,
        ]);

        $hasHref = isset($attributes['href']) && $attributes['href'] !== false;
        $hasAClass = isset($attributes['aclass']) && $attributes['aclass'] !== false;
        $hasTarget = isset($attributes['target']) && $attributes['target'] !== false;
        $hasHeight = isset($attributes['height']) && $attributes['height'] !== false;
        $hasWidth = isset($attributes['width']) && $attributes['width'] !== false;
        $hasSrc = isset($attributes['src']) && $attributes['src'] !== null;
        $hasClass = isset($attributes['class']) && $attributes['class'] !== null;

        $href = $attributes['href'] = $hasHref ? $attributes['href'] : false;
        $aClass = $attributes['aclass'] = $hasAClass ? $attributes['aclass'] : false;
        $target = $attributes['target'] = $hasTarget ? $attributes['target'] : '_blank';
        $width = $attributes['width'] = $hasWidth ? $attributes['width'] : '100px';
        $height = $attributes['height'] = $hasHeight ? $attributes['height'] : false;
        $class = $attributes['class'] = $hasClass ? $attributes['class'] : 'img-fluid';
        $src = $attributes['src'] = $hasSrc ? $attributes['src'] : null;
        $src = $attributes['src'] = $src ?: $this->model_image;

        $hasHref = isset($attributes['href']) && $attributes['href'] !== false;
        $hasAClass = isset($attributes['aclass']) && $attributes['aclass'] !== false;
        $hasTarget = isset($attributes['target']) && $attributes['target'] !== false;
        $hasHeight = isset($attributes['height']) && $attributes['height'] !== false;
        $hasWidth = isset($attributes['width']) && $attributes['width'] !== false;
        $hasSrc = isset($attributes['src']) && $attributes['src'] !== null;
        $hasClass = isset($attributes['class']) && $attributes['class'] !== null;

        $a = "";
        $_a = "";
        if ($hasHref) {
            $a = "<a";
            $a .= $hasTarget && $target ? " target='{$target}'" : "";
            $a .= $hasHref && $href ? " href='{$href}'" : "";
            $a .= $hasAClass && $aClass ? " class='{$aClass}'" : "";
            $a .= ">";
            $_a = "</a>";
        }

        $img = "<img ";
        $img .= $hasWidth && $width ? " width='{$width}'" : "";
        $img .= $hasHeight && $height ? " height='{$height}'" : "";
        $img .= $hasClass && $class ? " class='{$class}'" : "";
        $img .= $hasSrc && $src ? " src='{$src}'" : "";
        $img .= " />";

        $html = "{$a}{$img}{$_a}";

        return $html;
    }

    /**
     * $this->model_image
     *
     * @return string
     */
    public function getModelImageAttribute()
    {
        $url = $this->getFirstMediaUrl(self::IMAGE_TAG);
        if (!$url)
            $url = $this->getDefaultImage();

        return (string)$url;
    }

    /**
     * $this->model_image_url
     *
     * @return string
     */
    public function getModelImageUrlAttribute()
    {
        return (string)asset($this->model_image);
    }

    /**
     * $this->cache_image
     *
     * @return string
     */
    public function getCacheImageAttribute()
    {
        $url = $this->getFirstMediaUrl(self::IMAGE_TAG);
        if (!$url)
            $url = $this->getDefaultImage();

        try {
            $test = \Intervention\Image\Facades\Image::cache(function (\Intervention\Image\ImageCache $image) {
                $image->make(public_path($this->model_image))
                    ->resize($this->imageWidth, $this->imageHeight, function (\Intervention\Image\Constraint $constraint) {
                        $this->acceptRatio && $constraint->aspectRatio();
//                        $this->acceptRatio && $constraint->upsize();
                    });
//                dd($image->image);
                $image->resizeCanvas($this->imageWidth, $this->imageHeight, 'center', false, 'ffffff');;#->greyscale();
            }, 3, true);
//            dd($test);
            $name = "cache/" . self::IMAGE_TAG . "x{$this->imageWidth}x{$this->imageHeight}_{$this->id}";
            $test->save(public_path($name));
            $url = asset($name);
        } catch (\Exception $exception) {
            if (env('APP_DEBUG'))
                dd($exception);
        }
        return (string)$url;
    }

    /**
     * $this->cache_image()
     *
     * @return string
     */
    public function cache_image($width = null, $height = null, $acceptRatio = true)
    {
        $url = $this->cache_image;

        try {
            $test = \Intervention\Image\Facades\Image::cache(function (\Intervention\Image\ImageCache $image) use ($acceptRatio, $width, $height) {
                $image->make(public_path($this->model_image))
                    ->resize($width, $height, function (\Intervention\Image\Constraint $constraint) use ($acceptRatio) {
                        $acceptRatio && $constraint->aspectRatio();
                    });
                $image->resizeCanvas($width, $height, 'center', false, 'ffffff');;#->greyscale();
            }, 3, true);
            $name = "cache/" . self::IMAGE_TAG . "x{$width}x{$height}_{$this->id}";
            $test->save(public_path($name));
            $url = asset($name);
        } catch (\Exception $exception) {
            if (env('APP_DEBUG'))
                dd($exception);
        }
        return (string)$url;
    }

    /**
     * Returns model media as query
     *
     * @param string $collectionName
     *
     * @return MorphMany
     */
    public function getMediaByCollectionName(string $collectionName = 'default')
    {
        return $this->media()->where('collection_name', $collectionName);
    }
}
