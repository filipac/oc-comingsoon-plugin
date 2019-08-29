<?php

namespace Filipac\Comingsoon\Classes;

use October\Rain\Filesystem\Filesystem;
use October\Rain\Halcyon\Datasource\FileDatasource;

class YamlDataSource extends FileDatasource
{
    public function __construct(string $basePath, Filesystem $files)
    {
        $this->basePath = $basePath;

        $this->files = $files;

        $this->postProcessor = new YamlProcessor();
    }
}
