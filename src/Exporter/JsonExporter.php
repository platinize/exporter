<?php

namespace App\Exporter;

class ArrayExporter
{
    private $jsonContent;

    public function __construct($jsonContent)
    {
        $this->jsonContent = $jsonContent;
    }

    public function create()
    {
        foreach ($this->jsonContent as $content) {
            return json_decode($content, TRUE);
        }
    }

}