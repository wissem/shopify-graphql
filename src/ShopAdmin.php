<?php
/**
 * Created by PhpStorm.
 * User: wissem
 * Date: 23/10/2019
 * Time: 09:00
 */

namespace Shopify;

use GuzzleHttp\ClientInterface;

class ShopAdmin extends AbstractShop
{
    const VERSION = '2019-10';

    /**
     * @var string
     */
    private $version;

    public function __construct($domain, $key, ClientInterface $client, $version = self::VERSION)
    {
        $this->setKey($key)
            ->setDomain($domain)
            ->setClient($client);

        $this->version = $version;
    }

    public function getRequestUri(): string
    {
        if (!preg_match('/^https:\/\//i', $this->getDomain())) {
            return sprintf("https://%s.myshopify.com/admin/api/%s/graphql.json", $this->getDomain(), $this->getVersion());
        }
        return $this->getDomain();
    }

    public function getRequestBody($graphQL, $variables = null)
    {
        $body = ['query' => $graphQL];
        $body['variables'] = $variables;

        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => $this->getKey()
            ],
            'body' => json_encode($body)
        ];
    }

    private function getVersion(): string
    {
        return $this->version;
    }
}
