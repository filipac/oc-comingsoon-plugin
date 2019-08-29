<?php

namespace Filipac\Comingsoon\Classes;

use October\Rain\Halcyon\Builder;
use October\Rain\Halcyon\Processors\Processor;
use October\Rain\Parse\Yaml;

class YamlProcessor extends Processor
{
    /**
     * @var Yaml
     */
    public $yaml;

    public function __construct()
    {
        $this->yaml = new Yaml();
    }

    /**
     * Process the results of a singular "select" query.
     *
     * @param  \October\Rain\Halcyon\Builder  $query
     * @param  array  $result
     * @param  string $fileName
     * @return array
     */
    public function processSelectOne(Builder $query, $result)
    {
        if ($result === null) {
            return null;
        }

        $fileName = array_get($result, 'fileName');

        return [$fileName => $this->parseTemplateContent($query, $result, $fileName)];
    }

    /**
     * Process the results of a "select" query.
     *
     * @param  \October\Rain\Halcyon\Builder  $query
     * @param  array  $results
     * @return array
     */
    public function processSelect(Builder $query, $results)
    {
        if (!count($results)) {
            return [];
        }

        $items = [];

        foreach ($results as $result) {
            $fileName = array_get($result, 'fileName');
            $items[$fileName] = $this->parseTemplateContent($query, $result, $fileName);
        }

        return $items;
    }

    /**
     * Helper to break down template content in to a useful array.
     * @param  int     $mtime
     * @param  string  $content
     * @return array
     */
    protected function parseTemplateContent($query, $result, $fileName)
    {
        $content = array_get($result, 'content');

        $processed = $this->yaml->parse($content);

        return [
                'fileName' => $fileName,
                'content' => $content,
                'mtime' => array_get($result, 'mtime'),
                'data' => $processed ?? []
            ];
    }

    /**
     * Process the data in to an insert action.
     *
     * @param  \October\Rain\Halcyon\Builder  $query
     * @param  array  $data
     * @return string
     */
    public function processInsert(Builder $query, $data)
    {
        return $this->yaml->render(isset($data['data']) ? $data['data'] : [], [
            'exceptionOnInvalidType' => \Symfony\Component\Yaml\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE,
            'objectSupport' => \Symfony\Component\Yaml\Yaml::DUMP_OBJECT,
        ]);
    }

    /**
     * Process the data in to an update action.
     *
     * @param  \October\Rain\Halcyon\Builder  $query
     * @param  array  $data
     * @return string
     */
    public function processUpdate(Builder $query, $data)
    {
        $existingData = $query->getModel()->attributesToArray();

        return $this->yaml->render($data['data'], [
            'exceptionOnInvalidType' => \Symfony\Component\Yaml\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE,
            'objectSupport' => \Symfony\Component\Yaml\Yaml::DUMP_OBJECT,
        ]);

//        return SectionParser::render($data + $existingData, $options);
    }
}
