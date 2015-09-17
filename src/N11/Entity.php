<?php
/*
 * N11 Entity
 */

namespace N11;

use Exception;
use BadMethodCallException;

class Entity
{

  // Entity Name
  protected $name = null;

  // Service Name
  protected $serviceName = null;

  // Service Path
  protected $path = null;

  // Service End Point Base
  protected $endPointBase = 'https://api.n11.com';

  // Service Object
  protected $service = null;

  // Constructor
  function __construct($service)
  {
    $this->service = $service;
  }

  function __call($method, $args)
  {
    if (strpos($method, 'parse') === 0) throw new BadMethodCallException("Method '" . $method ."' not found");
    return $this->doRequest($method, $args);
  }

  protected function doRequest($method, $args, $parse = true)
  {
    $results = $this->service->doRequest($this->endPointBase . $this->path, $method, $args);
    if ($parse) return $this->__parse($results, $method);
    return $results;
  }

  protected function __defaultParse($results, $method)
  {
    return $results;
  }

  protected function __parse($results, $method)
  {
    $method = 'parse' . $method;
    $results = $this->__defaultParse($results, $method);
    if (!method_exists($this, $method)) return $results;
    return $this->{$method}($results);
  }
}
