<?php

namespace Filipac\Comingsoon\Classes;

use October\Rain\Halcyon\Datasource\Resolver;
use October\Rain\Halcyon\Model;

class ThemeContent extends Model
{
    public $dirName = '';

    /**
     * The datasource resolver instance.
     *
     * @var \October\Rain\Halcyon\Datasource\ResolverInterface
     */
    protected static $resolver;

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        $resolver = new Resolver(['theme' => Content::getDS()]);
        $resolver->setDefaultDatasource('theme');

        static::setDatasourceResolver($resolver);
    }

}
