<?php

namespace N11\Entity;

use N11\Entity;

class Category extends Entity
{
  // Entity Name
  protected $name = 'Category';

  // Service Name
  protected $serviceName = 'CategoryService';

  // Service Path
  protected $path = "/ws/CategoryService.wsdl";

  // GetTopLevelCategories Parser
  public function parseGetTopLevelCategories($results)
  {
    return isset($results['categoryList']['category']) ? $results['categoryList']['category'] : array();
  }

  // GetCategoryAttributes Method
  public function GetCategoryAttributes($categoryId)
  {
    if (!$categoryId) return false;
    return self::doRequest('GetCategoryAttributesId', array('categoryId' => $categoryId));
  }

  // GetCategoryDetail Method
  public function GetCategoryDetail($categoryId)
  {
    if (!$categoryId) return false;
    $results = self::doRequest('GetCategoryAttributes', array('categoryId' => $categoryId), false);
    if (!isset($results['category'])) return array();
    $results = $results['category'];
    $results['attributes'] = array();
    if (isset($results['attributeList']['attribute']))
    {
      $results['attributes'] = $results['attributeList']['attribute'];
      unset($results['attributeList']);
    }
    if (!empty($results['attributes']) && !isset($results['attributes'][0])) $results['attributes'] = array($results['attributes']);
    foreach ($results['attributes'] as $key => $value)
    {
      $results['attributes'][$key]['values'] = isset($value['valueList']['value']) ? $value['valueList']['value'] : array();
      if (isset($value['valueList'])) unset($results['attributes'][$key]['valueList']);
    }
    return $results;
  }

  // GetCategoryAttributes Parser
  public function parseGetCategoryAttributes($results)
  {
    if (!isset($results['category']['attributeList']['attribute'])) return array();
    $results = $results['category']['attributeList']['attribute'];
    if (!empty($results) && !isset($results[0])) $results = array($results);
    foreach ($results as $key => $value) {
      $results[$key]['values'] = isset($value['valueList']['value']) ? $value['valueList']['value'] : array();
      if (isset($value['valueList'])) unset($results[$key]['valueList']);
    }
    if (!isset($results[0])) $results = array($results);
    return $results;
  }

  // GetSubCategories Method
  public function GetSubCategories($categoryId)
  {
    if (!$categoryId) return false;
    return self::doRequest('GetSubCategories', array('categoryId' => $categoryId));
  }

  // GetSubCategories Parser
  public function parseGetSubCategories($results)
  {
    $results = isset($results['category']['subCategoryList']['subCategory']) ? $results['category']['subCategoryList']['subCategory'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetParentCategory Method
  public function GetParentCategory($categoryId)
  {
    if (!$categoryId) return false;
    $results = $this->parseGetParentCategory(self::doRequest('GetCategoryAttributes', array('categoryId' => $categoryId), false));
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetParentCategory Method
  public function parseGetParentCategory($results)
  {
    if (isset($results['result']['status']) && $results['result']['status'] != "success") return false;
    $results = isset($results['category']['parentCategory']) ? $results['category']['parentCategory'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }


}
