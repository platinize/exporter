<?php

namespace App\Exporter;

class JsonExporter implements Saveable
{
    private $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function save(string $fileName): void
    {
        $data = $this->create();
        file_put_contents('Json/' . $fileName . '.json', $data);
    }

    public function create()
    {
        return json_encode($this->content, true);
    }

}