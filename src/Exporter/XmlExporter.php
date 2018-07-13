<?php

namespace App\Exporter;

use SimpleXMLElement;

class XmlExporter
{
    private $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function save(string $fileName)
    {
        $xmlData = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        $this->create($this->content, $xmlData);
        $result = $xmlData->asXML('App/../XmlFiles/'.$fileName.'.xml');
    }

    private function create($data, $xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }

            if (is_array($value)) {
                $subnode = $xmlData->addChild($key);
                $this->create($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}