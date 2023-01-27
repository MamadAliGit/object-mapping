<?php

namespace mamadali\ObjectMapping\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use http\Exception\InvalidArgumentException;
use mamadali\ObjectMapping\Interfaces\ObjectMappingInterface;
use Psr\Http\Message\ResponseInterface;

trait HasMapModel
{
    private string $_method = 'GET';
    private array $_headers = [];
    private Client $_client;
    private ResponseInterface $_response;

    public function __construct()
    {
        if(!$this instanceof ObjectMappingInterface){
            throw new InvalidArgumentException(get_class($this) . ' must be implement from mamadali\Interfaces\ObjectMappingInterface');
        }

        $this->_client = new Client();
    }

    /**
     * set headers request for send to api url
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers): void
    {
        $this->_headers = $headers;
    }

    /**
     * set method name for api url
     * @param string $method
     * @return void
     */
    public function setRequestMethod(string $method): void
    {
        $this->_method = $method;
    }

    /**
     * to use mapData method your class must be implemented from ObjectMapping interface and declared 'mapAttributes' method
     * @param string $url the url to send request
     * @throws GuzzleException
     */
    public function mapDataFromUrl(string $url): void
    {
        $this->_response = $this->_client->request($this->_method, $url, [
            'headers' => $this->_headers,
        ]);

        $data = $this->initializeData();

        $this->mapData($data);
    }

    /**
     * get response body from request and convert body content to array
     * @return array
     * @throws Exception
     */
    private function initializeData() : array
    {
        $contentType = $this->_response->getHeader('content-type')[0];

        if($contentType == 'application/json')  {
            return (array)json_decode($this->_response->getBody()->getContents());
        } elseif ($contentType == 'application/xml') {
            return (array)(new \SimpleXMLElement($this->_response->getBody()->getContents()));
        }

        return [];
    }

    /**
     * to use mapData method your class must be implemented from ObjectMapping interface and declared 'mapAttributes' method
     * @param array $data
     * @return void
     */
    public function mapData(array $data): void
    {
        $mapAttributes = $this->mapAttributes();
        foreach (($data ?? []) as $key => $value) {
            $attribute = array_key_exists($key, $mapAttributes) ? $mapAttributes[$key] : $key;
            $this->{$attribute} = $value;
        }
    }

}
