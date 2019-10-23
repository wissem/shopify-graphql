<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:00
 */

namespace Shopify;


use GraphQL\ArrayToGraphQL;
use GraphQL\Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class Shop extends AbstractShop
{

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        if (!preg_match('/^https:\/\//i', $this->getDomain())) {
            return sprintf("https://%s.myshopify.com/api/graphql", $this->getDomain());
        }

        return $this->getDomain();
    }

    /**
     * Shop constructor.
     *
     * @param $domain
     * @param $key
     * @param ClientInterface $client
     */
    public function __construct($domain, $key, ClientInterface $client)
    {
        $this->setKey($key)
            ->setDomain($domain)
            ->setClient($client);
    }

    public function getRequestBody($graphQL, $variables = null)
    {
        $body = ['query' => $graphQL];
        $body['variables'] = $variables;
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Storefront-Access-Token' => $this->getKey()
            ],
            'body' => json_encode($body)
        ];
    }
}
