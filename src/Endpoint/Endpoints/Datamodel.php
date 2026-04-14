<?php

namespace Onetoweb\Deployteq\Endpoint\Endpoints;

use Onetoweb\Deployteq\Endpoint\AbstractEndpoint;

/**
 * Datamodel Endpoint.
 */
class Datamodel extends AbstractEndpoint
{
    /**
     * @param array $data
     * 
     * @return array|NULL
     */
    public function create(array $data): ?array
    {
        return $this->client->post($data);
    }
}
