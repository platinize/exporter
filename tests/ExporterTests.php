<?php

namespace Tests\Downloader;

use App\Exporter\ArrayExporterJson;
use App\Exporter\ArrayExporterXml;
use App\Exporter\JsonExporter;
use App\Exporter\XmlExporter;
use PHPUnit\Framework\TestCase;
use Generator;

class ExporterTests extends TestCase
{
    public function generator($data): Generator
    {
        yield $data;
    }

    public function test_json_export_to_array()
    {
        $data = ['id' => 1,'name' => "ivan",'country' => 'Russia',"office" => ["yandex"," management"] ];
        $json = json_encode($data);
        $expected = $data;

        $arrayExporterJson = new ArrayExporterJson($this->generator($json));
        $actual = $arrayExporterJson->create();

        $this->assertSame($expected, $actual);
    }

    public function test_xml_export_to_array()
    {
        $data = '<exchangerates>
                    <row><exchangerate ccy="USD" base_ccy="UAH" buy="26.1" sale="26.3"/></row>
                </exchangerates>';
        $expected = [
            'row' => [
                'exchangerate' => [
                    '@attributes' => [
                        'ccy' => 'USD', 'base_ccy' => 'UAH', 'buy' => '26.1', 'sale' => '26.3'
                    ]
                ]
            ]
        ];

        $arrayExporterXml = new ArrayExporterXml($this->generator($data));
        $actual = $arrayExporterXml->create();
        $this->assertSame($expected, $actual);
    }

    public function test_array_export_to_xml()
    {
        $data = [
            'row' => [
                'exchangerate' => [
                    'ccy' => 'USD', 'base_ccy' => 'UAH', 'buy' => '26.1', 'sale' => '26.3'
                ]
            ]
        ];
        $expected = simplexml_load_file("App/../XmlFiles/test.xml")->asXML();

        $arrayExporterXml = new XmlExporter($data);
        $arrayExporterXml->save('actual');

        $actual = simplexml_load_file("App/../XmlFiles/actual.xml")->asXML();
        $this->assertSame($expected, $actual);
    }

    public function test_array_export_to_json()
    {
        $data = [
            'row' => [
                'exchangerate' => [
                    'ccy' => 'USD', 'base_ccy' => 'UAH', 'buy' => '26.1', 'sale' => '26.3'
                ]
            ]
        ];
        $expected = file_get_contents("App/../Json/test.json");

        $arrayExporterJson = new JsonExporter($data);
        $arrayExporterJson->save('actual');

        $actual = file_get_contents("App/../Json/actual.json");
        $this->assertSame($expected, $actual);
    }
}