<?php

namespace Onetoweb\Deployteq;

use Onetoweb\Deployteq\Endpoint\Endpoints;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;

/**
 * Deployteq Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * Base href
     */
    public const BASE_HREF = 'https://webhook.myclang.com/app/api/rest/public/v2/project/datahook/data-receiver';
    
    /**
     * Methods.
     */
    public const METHOD_POST = 'POST';
    
    /**
     * @var string
     */
    private $token;
    
    /**
     * @var string
     */
    private $endpoint;
    
    /**
     * @param string $token
     * @param string $endpoint
     */
    public function __construct(string $token, string $endpoint)
    {
        $this->token = $token;
        $this->endpoint = $endpoint;
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return rtrim(self::BASE_HREF, '/') . '/' . ltrim($this->endpoint, '/');
    }
    
    /**
     * @param array $data = []
     * 
     * @return array|NULL
     */
    public function post(array $data = []): ?array
    {
        return $this->request(self::METHOD_POST, $data);
    }
    
    /**
     * @param string $method
     * @param array $data = []
     * @param array $query = []
     * 
     * @return array|NULL
     */
    public function request(string $method, array $data = [], array $query = []): ?array
    {
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => true,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->token}",
            ],
            RequestOptions::JSON => $data,
            RequestOptions::QUERY => $query,
        ];
        
        // make request
        $response = (new GuzzleCLient())->request($method, $this->getUrl(), $options);
        
        // decode json
        $json = json_decode($response->getBody()->getContents(), true);
        
        return $json;
    }
}
