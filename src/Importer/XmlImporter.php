<?php

namespace App\Importer;

class XmlImporter implements Createable
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function create(): array
    {
        $content = $this->content->current();
        $xml = simplexml_load_string($content);
        $json = json_encode($xml);

        return $data = json_decode($json, true);
    }

}