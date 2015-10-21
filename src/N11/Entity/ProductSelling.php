<?php

namespace N11\Entity;

use N11\Entity;

class ProductSelling extends Entity
{
  // Entity Name
  protected $name = 'ProductSelling';

  // Service Name
  protected $serviceName = 'ProductSellingService';

  // Service Path
  protected $path = "/ws/ProductSellingService.wsdl";

  // StopSellingProductByProductId Method
  public function StopSellingProductByProductId($productId)
  {
    if (!$productId) return false;
    return self::doRequest('StopSellingProductByProductId', array('productId' => $productId));
  }

  // StopSellingProductByProductId Parser
  public function parseStopSellingProductByProductId($results)
  {
    if (isset($results['result']['status']) && $results['result']['status'] == "success") return true;
    return false;
  }

  // StartSellingProductByProductId Method
  public function StartSellingProductByProductId($productId)
  {
    if (!$productId) return false;
    return self::doRequest('StartSellingProductByProductId', array('productId' => $productId));
  }

  // StartSellingProductByProductId Parser
  public function parseStartSellingProductByProductId($results)
  {
    if (isset($results['result']['status']) && $results['result']['status'] == "success") return true;
    return false;
  }

  // StopSellingProductBySellerCode Method
  public function StopSellingProductBySellerCode($sellerCode)
  {
    if (!$sellerCode) return false;
    return self::doRequest('StopSellingProductBySellerCode', array('productSellerCode' => $sellerCode));
  }

  // StopSellingProductBySellerCode Parser
  public function parseStopSellingProductBySellerCode($results)
  {
    if (isset($results['result']['status']) && $results['result']['status'] == "success") return true;
    return false;
  }




}
