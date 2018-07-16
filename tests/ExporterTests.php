<?php

namespace Tests\Downloader;

use App\Importer\XmlImporter;
use App\Importer\JsonImporter;
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

        $arrayExporterJson = new JsonImporter($this->generator($json));
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

        $arrayExporterXml = new XmlImporter($this->generator($data));
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
        $expected = '<?xml version="1.0"?>'.PHP_EOL.'<data><row><exchangerate><ccy>USD</ccy><base_ccy>UAH</base_ccy><buy>26.1</buy><sale>26.3</sale></exchangerate></row></data>'.PHP_EOL;

        $arrayExporterXml = new XmlExporter($data);
        $arrayExporterXml->save('actual');

        $actual = file_get_contents("App/../XmlFiles/actual.xml");
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
        $expected = '{"row":{"exchangerate":{"ccy":"USD","base_ccy":"UAH","buy":"26.1","sale":"26.3"}}}';

        $arrayExporterJson = new JsonExporter($data);
        $arrayExporterJson->save('actual');

        $actual = file_get_contents("App/../Json/actual.json");
        $this->assertSame($expected, $actual);
    }
}

//var_dump(memory_get_peak_usage(false));