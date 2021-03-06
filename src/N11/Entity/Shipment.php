<?php

namespace N11\Entity;

use N11\Entity;

class Shipment extends Entity
{
  // Entity Name
  protected $name = 'Shipment';

  // Service Name
  protected $serviceName = 'ShipmentService';

  // Service Path
  protected $path = "/ws/ShipmentService.wsdl";

  // Product Per Page
  private $productPerPage = 100;

  // GetProductByProductId Parser
  public function parseGetShipmentTemplateList($results)
  {
    $results = isset($results['shipmentTemplates']['shipmentTemplate']) ? $results['shipmentTemplates']['shipmentTemplate'] : array();
    if (!empty($results) && !isset($results[0])) $results = array($results);
    return $results;
  }

}
