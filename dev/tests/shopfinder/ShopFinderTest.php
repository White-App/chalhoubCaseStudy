<?php

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\ConfigInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\GraphQlAbstract;

class ShopFinderTest extends GraphQlAbstract
{
    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
    }

    public function testGetShopsQuery(): void
    {
        $query = <<<QUERY
query {
  getShops {
    shop_id
    name
    identifier
    country
    image
    longitude
    latitude
  }
}
QUERY;

        $response = $this->graphQlQuery($query);
        $this->assertArrayHasKey('getShops', $response);
        $this->assertNotEmpty($response['getShops']);
    }

    public function testGetShopByIdentifierQuery(): void
    {
        $identifier = 'example-shop';
        $query = <<<QUERY
query {
  getShopByIdentifier(identifier: "{$identifier}") {
    shop_id
    name
    identifier
    country
    image
    longitude
    latitude
  }
}
QUERY;

        $response = $this->graphQlQuery($query);
        $this->assertArrayHasKey('getShopByIdentifier', $response);
        $this->assertNotEmpty($response['getShopByIdentifier']);
    }

    public function testUpdateShopMutation(): void
    {
        $shopId = 1;
        $newName = 'Updated Shop Name';
        $query = <<<QUERY
mutation {
  updateShop(
    shop_id: {$shopId},
    name: "{$newName}"
  ) {
    shop_id
    name
  }
}
QUERY;

        $response = $this->graphQlMutation($query);
        $this->assertArrayHasKey('updateShop', $response);
        $this->assertEquals($newName, $response['updateShop']['name']);
    }

    public function testDeleteShopMutation(): void
    {
        $shopId = 1;
        $query = <<<QUERY
mutation {
  deleteShop(shop_id: {$shopId})
}
QUERY;

        $response = $this->graphQlMutation($query);
        $this->assertArrayHasKey('deleteShop', $response);
        $this->assertTrue($response['deleteShop']);
    }

    protected function _getQueriesAndMutations(): array
    {
        return [
            'queries' => [],
            'mutations' => []
        ];
    }
}
