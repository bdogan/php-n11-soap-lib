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
    return isset($results['cities']['city']) ? $results['cities']['city'] : array();
  }

  // GetCity Method
  public function GetCity($cityCode)
  {
    if (!$cityCode) return false;
    return self::doRequest('GetCity', array('cityCode' => $cityCode));
  }

  // GetCities Method
  public function parseGetCity($results)
  {
    return isset($results['city']) ? $results['city'] : array();
  }

  // GetDistrict Method
  public function GetDistrict($cityCode)
  {
    if (!$cityCode) return false;
    return self::doRequest('GetDistrict', array('cityCode' => $cityCode));
  }

  // GetDistrict Parse
  public function parseGetDistrict($results)
  {
    return isset($results['districts']['district']) ? $results['districts']['district'] : array();
  }



}
