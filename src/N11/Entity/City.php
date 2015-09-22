<?php

namespace N11\Entity;

use N11\Entity;

class City extends Entity
{
  // Entity Name
  protected $name = 'City';

  // Service Name
  protected $serviceName = 'CityService';

  // Service Path
  protected $path = "/ws/CityService.wsdl";

  // GetCities Method
  public function parseGetCities($results)
  {
    $results = isset($results['cities']['city']) ? $results['cities']['city'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetCity Method
  public function GetCity($cityCode)
  {
    if (!$cityCode) return false;
    $results = self::doRequest('GetCity', array('cityCode' => $cityCode));
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetCities Method
  public function parseGetCity($results)
  {
    $results = isset($results['city']) ? $results['city'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetDistrict Method
  public function GetDistrict($cityCode)
  {
    if (!$cityCode) return false;
    $results = self::doRequest('GetDistrict', array('cityCode' => $cityCode));
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

  // GetDistrict Parse
  public function parseGetDistrict($results)
  {
    $results = isset($results['districts']['district']) ? $results['districts']['district'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }



}
