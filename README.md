# graphql
A GraphQL query builder class

## Basic Usage 

Below is a basic example of using Admin GraphQL for a basic search query by SKU:
```php
<?php

$shop = 'mydomainidentifier'; // mydomainidentifier.myshopify.com
$accessToken = '123456'; // your app access token
$client = new \GuzzleHttp\Client();
$shopAdmin = new \Shopify\ShopAdmin($shop, $accessToken, $client);

$sku = "foobar";
$query = <<<EOF
query {
  
 productVariants(first: 3, sku:$sku") { 
      edges { 
          node {
          product {
            id
            title
            handle
            images(first: 1) {
              edges {
                node {
                  id
                  originalSrc
                }
              }
            }
            product_type: productType
            published_at: publishedAt
            
          }
         
        } 
      } 
    } 
}
EOF;

$queryResult = $shopAdmin->query($query);
```
## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/cfpinto/shopify-graphql/badge.svg?style=beer-square)](https://beerpay.io/cfpinto/shopify-graphql)  [![Beerpay](https://beerpay.io/cfpinto/shopify-graphql/make-wish.svg?style=flat-square)](https://beerpay.io/cfpinto/shopify-graphql?focus=wish)
