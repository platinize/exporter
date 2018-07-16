<?php

namespace App\Importer;

class JsonImporter implements Createable
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function create(): array
    {
        return json_decode($this->content->current(), true);
    }

}