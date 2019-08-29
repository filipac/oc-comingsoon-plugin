<?php

namespace Filipac\Comingsoon\Classes;

use Cms\Classes\Controller;
use Cms\Classes\Partial;
use Cms\Classes\Theme;
use System\Classes\CombineAssets;
use Url;

class BaseController extends Controller
{
    public $relativePath = 'plugins/filipac/comingsoon/';

    public function __construct(?Theme $theme = null)
    {
        $theme = EmbeddedTheme::load('theme');
        parent::__construct($theme);
        $this->assetPath = $this->relativePath . $this->theme->getDirName();

        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    public function boot()
    {
//        dd(Partial::inTheme($this->theme)->get());
    }

    public function themeUrl($url = null)
    {
        $themeDir = $this->getTheme()->getDirName();

        if (is_array($url)) {
            $_url = Url::to(CombineAssets::combine($url, $this->relativePath . $themeDir));
        } else {
            $_url = $this->relativePath . $themeDir;
            if ($url !== null) {
                $_url .= '/' . $url;
            }
            $_url = Url::asset($_url);
        }

        return $_url;
    }

    public function getAssetPath($fileName, $assetPath = null)
    {
        if (starts_with($fileName, ['//', 'http://', 'https://'])) {
            return $fileName;
        }

        if (!$assetPath) {
            $assetPath = $this->assetPath;
        }

        if (substr($fileName, 0, 1) == '/' || $assetPath === null) {
            return $fileName;
        }

        return $assetPath . '/' . $fileName;
    }
}
