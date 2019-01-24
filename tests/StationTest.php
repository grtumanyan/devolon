<?php

require('../vendor/autoload.php');

class StationTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost'
        ]);
    }

    public function testGet_ValidInput_Stations()
    {
        $response = $this->client->get('/task/public/api/station/list/latitude=26.990871&longitude=43.654115&kilometers=9000');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('result', $data);
        $this->assertArrayHasKey('station', $data['result']);
        $this->assertArrayHasKey('id', $data['result']['station']);
        $this->assertEquals(1411, $data['result']['distance']);
    }
}