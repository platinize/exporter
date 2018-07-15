<?php

namespace Tests\Downloader;

use App\Downloader\Downloader;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class DownloaderTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @test */
    public function test_download()
    {
        $contents = ['1', '2'];
        
        $client = $this->getClient($contents);
        
        $downloader = new Downloader($client);
        
        $actualContents = iterator_to_array($downloader->download(...['/', '/']));
        
        $this->assertEquals($contents, $actualContents);
    }
    public function getClient(array $contents)
    {
        $responses = array_map(function (string $content) {
            return new Response(200, [], $content);
        }, $contents);
        
        $handler = new MockHandler($responses);
        return new Client(compact('handler'));
    }
}