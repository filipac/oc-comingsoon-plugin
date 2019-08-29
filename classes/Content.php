<?php

namespace Filipac\Comingsoon\Classes;

use October\Rain\Halcyon\Datasource\FileDatasource;
use October\Rain\Support\Facades\Yaml;

class Content
{
    public static $ds;

    public static function getDS(): FileDatasource
    {
        if (static::$ds) {
            return static::$ds;
        }

        static::$ds = new FileDatasource(dirname(__DIR__).'/theme/content', app('files'));
        return static::$ds;
    }

    public static function getYamlDS(): YamlDataSource
    {
        return new YamlDataSource(dirname(__DIR__).'/theme/content', app('files'));
    }

    public static function getIntro()
    {
        $file = ThemeContent::query()->whereFileName('text')->first();
        if($file) {
            return $file->markup;
        }

        return '';
    }

    public static function setIntro($text)
    {
        $file = ThemeContent::query()->whereFileName('text')->first();
        if(!$file) {
            $file = new ThemeContent([
                'fileName' => 'text',
            ]);
        }
        $file->markup = $text;
        $file->save();
    }

    public static function getAddresses()
    {
        $file = static::getDS()->selectOne('', 'addresses', 'yaml');

        if($file) {
            $arr = Yaml::parse($file['content']);
            if(isset($arr['addresses']) && is_array($arr['addresses'])) {
                $arr['addresses'] = collect($arr['addresses']);
            }
            return $arr;
        } else {
            return ['addresses' => collect([])];
        }
    }
}
