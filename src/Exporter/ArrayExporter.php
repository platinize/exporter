<?php

namespace App\Exporter;

class ArrayExporter
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function create()
    {
        foreach ($this->content as $content) {
            return json_decode($content, true);
        }
    }

}