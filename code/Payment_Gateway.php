<?php

/**
 * Abstract class for a number of payment gateways 
 * 
 * @package payment
 */
class Payment_Gateway {
  
  /**
   * The link to return to after processing payment  
   */
  protected  $returnURL;
  
  /**
   * Type of the gateway to be used: dev/live/test
   */
  protected static $type = 'live';
  
  public function setReturnURL($url) {
    $this->returnURL = $url;
  }
  
  public static function set_type($type) {
    if ($type == 'dev' || $type == 'live' || $type == 'test') {
      self::$type = $type;
    }
  }
  
  /**
   * Get the class name of the desired gateway.
   * 
   * @param unknown_type $gatewayName
   */
  public static function gateway_class_name($gatewayName) {
    if (! self::$type) {
      return null;
    }
    
    switch(self::$type) {
      case 'live':
        $gatewayClass = $gatewayName . '_Production_Gateway';
        break;
      case 'dev':
        $gatewayClass = $gatewayName . '_Sandbox_Gateway';
        break;
      case 'test':
        $gatewayClass = $gatewayName . '_Mock_Gateway';
        break;
    }
    
    if (class_exists($gatewayClass)) {
      return $gatewayClass;
    } else {
      return null;
    }
  }
  
  /**
   * Send a request to the gateway to process the payment. 
   * To be implemented by individual gateway
   * 
   * @param $data
   */
  public function process($data) {
    user_error("Please implement process() on $this->class", E_USER_ERROR);
  } 
  
  /**
   * Process the response from the external gateway
   * 
   * @return Gateway_Result
   */
  public function getResponse($response) {
    return new Gateway_Result();
  }
}

/**
 * Class for gateway results
 */
abstract class Gateway_Result {
	
  const SUCCESS = 'Success';
  const FAILURE = 'Failure';
  const INCOMPLETE = 'Incomplete';
  
  protected $status = INCOMPLETE;
  protected $data;
  protected $adminmessage, $usermessage;

  /**
   * 
   * @param unknown_type $data - could be an array
   */
  function __construct($data) {
  	$this->data = $data;
    $this->parse();
  }
  
  /**
   * Parse the stored data, and set status.
   */
  abstract protected function parse();

  function getStatus() {
    return $this->status;
  }
  
  function getAdminMessage(){
  	return $this->adminmessage;
  }
  
  function getUserMessage(){
  	return $this->usermessage;
  }
  
}