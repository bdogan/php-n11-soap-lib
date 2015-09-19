<?php
/*
 * N11 Soap Service class
 */

namespace N11;

use SoapClient;
use Exception;
use N11\Entity;

class Service
{

  // N11 Debug Flag
  private $_isDebug = true;

  // N11 Api Key
  private $_apiKey = null;

  // N11 Api Pass
  private $_apiPass = null;

  // N11 Api Last Call
  private $_lastCall = array();

  // N11 Api Last Exception
  private $_lastException = null;

  // Last Service Used
  private $_lastServiceAddress = null;

  // Last Soap Client
  private $_soapClient = null;

  // Check If Valid
  private function isValidAuth($_apiKey, $_apiPass)
  {
    return is_string($_apiKey) && !empty($_apiKey) && is_string($_apiPass) && !empty($_apiPass);
  }

  // Set Debug Mode
  public function setDebugMode($mode = false)
  {
    $this->_isDebug = $mode;
  }

  // Get Generic Soap Options
  private function getSoapOptions()
  {
    $options = array(
      'trace' => $this->_isDebug,
      'exceptions' => 1
    );
    return $options;
  }

  // Parse Soap Arguments
  private function parseArguments($args = null)
  {
    if (empty($args) || is_null($args)) $args = array();
    if (!is_array($args)) $args = array($args);
    $args['auth'] = array(
      'appKey' => $this->_apiKey,
      'appSecret' => $this->_apiPass
    );
    return $args;
  }

  // Return last call details
  public function getLastCall()
  {
    $this->_lastCall = array('request' => null, 'requestHeaders' => null, 'response' => null, 'responseHeaders' => null);
    if (!$this->_soapClient) return $this->_lastCall;
    $this->_lastCall['request'] = $this->_soapClient->__getLastRequest();
    $this->_lastCall['requestHeaders'] = $this->_soapClient->__getLastRequestHeaders();
    $this->_lastCall['response'] = $this->_soapClient->__getLastResponse();
    $this->_lastCall['responseHeaders'] = $this->_soapClient->__getLastResponseHeaders();
    return $this->_lastCall;
  }

  // Return last exception
  public function getLastException()
  {
    return $this->_lastException;
  }

  // Return last address
  public function getLastServiceAddress()
  {
    return $this->_lastServiceAddress;
  }

  // Create Soap Object
  private function createSoapObj($serviceAddress)
  {
    if ($this->_lastServiceAddress == $serviceAddress) return $this->_soapClient;
    if (is_object($this->_soapClient)) unset($this->_soapClient);
    $this->_soapClient = new SoapClient($serviceAddress, $this->getSoapOptions());
    $this->_lastServiceAddress = $serviceAddress;
    return $this->_soapClient;
  }

  // Do request
  public function doRequest($serviceAddress, $method, $args = null)
  {
    $this->_lastException = null;
    try
    {
      $args = $this->parseArguments($args);
      $client = $this->createSoapObj($serviceAddress);
      return json_decode(json_encode($client->{$method}($args)), true);
      unset($client);
    }
    catch (Exception $e)
    {
      $this->_lastException = $e;
      throw new ServiceException($e->getMessage());
    }
  }

  // Validate auth data
  public function validateAuth()
  {
    try
    {
      $results = $this->Category->GetTopLevelCategories();
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  // Set Api Key & Api Pass
  public function setAuth($_apiKey, $_apiPass)
  {
    if (!$this->isValidAuth($_apiKey, $_apiPass)) throw new ServiceException('Service auth validation failure');
    $this->_apiKey = $_apiKey;
    $this->_apiPass = $_apiPass;
  }

  // Public Constructor
  function __construct($_apiKey, $_apiPass)
  {
    $this->setAuth($_apiKey, $_apiPass);
    $entityFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Entity' . DIRECTORY_SEPARATOR . '*.php';
    foreach (glob($entityFolder) as $entity)
    {
      $entity = str_replace('.php', '', basename($entity));
      $entityClass = 'N11\\Entity\\' . $entity;
      $this->{$entity} = new $entityClass($this);
    }
  }

}
?>
