<?php

namespace App\Exporter;

class ArrayExporterXml
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function create()
    {
        foreach ($this->content as $content) {
            $xml = simplexml_load_string($content);
            $json = json_encode($xml);
            return $data = json_decode($json, true);
        }
    }

}