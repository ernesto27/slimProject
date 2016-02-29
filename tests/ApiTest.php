<?php
require_once 'vendor/autoload.php';
require_once "config_phpunit.php";

use GuzzleHttp\Exception\ClientException;

class ApiTest extends \PHPUnit_Framework_TestCase
{
	/**
     * The base url of the api
     * @var string
     */
    private $baseUri = "http://localhost/api";
    
	/**
     * The Guzzle http client
     * @var object
     */
    private $client;

    protected function setUp()
    {   
        $this->client = new GuzzleHttp\Client([
                            'base_uri' => $this->baseUri,
                            'defaults' => ['exceptions' => false ],
                            'headers'  => [ 'Auth-Token' => 'valid-token']

                        ]);
    }

    public static function setUpBeforeClass()
    {
        
    }


	public function testVersionApi()
	{
		$response = $this->client->get('');
		$data = json_decode($response->getBody(true), true);
    	$this->assertEquals("Api version", $data);
	}



}

?>
























