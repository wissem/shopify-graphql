<?php
/**
 * Created by PhpStorm.
 * User: wissem
 * Date: 23/10/2019
 * Time: 09:00
 */

namespace Shopify;

use GuzzleHttp\ClientInterface;

abstract class AbstractShop
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var ClientInterface
     */
    private $client;

    abstract public function getRequestUri(): string;
    abstract public function getRequestBody($graphQL, $variables = null);

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param $key
     *
     * @return AbstractShop
     */
    public function setKey($key): AbstractShop
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param $domain
     *
     * @return AbstractShop
     */
    public function setDomain($domain): AbstractShop
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     *
     * @return AbstractShop
     */
    public function setClient(ClientInterface $client): AbstractShop
    {
        $this->client = $client;
        return $this;
    }

    public function query($query, $parameters = null, $raw = false)
    {
        if (is_string($query)) {
            $body = $this->getRequestBody($query, $parameters);
        } else {
            $reflection = new \ReflectionFunction($query);
            if ($reflection->isClosure()) {
                $body = $this->getRequestBody($query(), $parameters);
            } else {
                throw new Exception("Invalid GraphQL \$query. Expecting Closure or string");
            }
        }

        return $this->run($body, $raw);
    }

    private function run($body, $raw = false)
    {
        /** @var Response $response */
        $response = $this
            ->client
            ->post($this->getRequestUri(), $body);

        if ($raw) {
            return $response;
        }

        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }
}
