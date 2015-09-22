<?php

namespace N11\Entity;

use N11\Entity;

class Product extends Entity
{
  // Entity Name
  protected $name = 'Product';

  // Service Name
  protected $serviceName = 'ProductService';

  // Service Path
  protected $path = "/ws/ProductService.wsdl";

  // Product Per Page
  private $productPerPage = 100;

  // GetProductByProductId Method
  public function GetProductByProductId($productId)
  {
    if (!$productId) return false;
    return self::doRequest('GetProductByProductId', array('productId' => $productId));
  }

  // GetProductByProductId Parser
  public function parseGetProductByProductId($results)
  {
    $results = isset($results['product']) ? $results['product'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetProductByProductId Method
  public function GetProductBySellerCode($sellerCode)
  {
    if (!$sellerCode) return false;
    return self::doRequest('GetProductBySellerCode', array('sellerCode' => $sellerCode));
  }

  // GetProductBySellerCode Parser
  public function parseGetProductBySellerCode($results)
  {
    $results = isset($results['product']) ? $results['product'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetProductBySellerCode Method
  public function GetProductList($page = 0, $stackProducts = array())
  {
    //if (!$sellerCode) return false;
    $pageData = array('currentPage' => $page, 'pageSize' => $this->productPerPage);
    $results = self::doRequest('GetProductList', array('pagingData' => $pageData), false);
    $stackProducts = array_merge($stackProducts, $this->parseGetProductList($results));
    if (!isset($results['pagingData'])) return $stackProducts;
    $this->productPerPage = $results['pagingData']['pageSize'];
    if ((($page + 1) * $this->productPerPage) < $results['pagingData']['totalCount'])
      return $this->GetProductList($page + 1, $stackProducts);
    else
      return $stackProducts;
  }

  // GetProductList Parser
  public function parseGetProductList($results)
  {
    $results = isset($results['products']['product']) ? $results['products']['product'] : array();
    if (!isset($results[0])) $results = array($results);
    return $results;
  }

}
