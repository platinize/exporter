<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

use App\Downloader\Downloader;
use App\Exporter\ArrayExporter;
use App\Exporter\XmlExporter;

$load = new Downloader(new Client);
$arrayExporter = new ArrayExporter($load->download('https://laravel-news.com/feed/json'));
$array = $arrayExporter->create();
//var_dump($array);
$xmlExporter = new XmlExporter($array);
$xmlExporter->save('NewFile');


die;
    $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
    array_to_xml($array, $xml_data);
    $result = $xml_data->asXML(__DIR__.'/namea.xml');

function array_to_xml($data, &$xml_data)
{
    foreach ($data as $key => $value) {
        if (is_numeric($key)) {
            $key = 'item' . $key;
        }
        if (is_array($value)) {
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}
