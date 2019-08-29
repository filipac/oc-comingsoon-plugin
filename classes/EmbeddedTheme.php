<?php

namespace Filipac\Comingsoon\Classes;

use Cms\Classes\Theme;

class EmbeddedTheme extends Theme
{
    private $embedPath;

    const ACTIVE_KEY = 'comingsoon::theme.active';
    const EDIT_KEY = 'comingsoon::theme.edit';
    const CONFIG_KEY = 'comingsoon::theme.config';

    public function __construct($relativePath = null)
    {
        $this->embedPath = dirname(__DIR__).($relativePath ? '/'.$relativePath : '');

        self::$activeThemeCache = $this;
    }

    public function getPath($dirName = null)
    {
        if (!$dirName) {
            $dirName = $this->getDirName();
        }

        return $this->embedPath.'/'.$dirName;
    }

}
