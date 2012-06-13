<?php

/**
 * Base class for gateway implementations
 * 
 * @package payment
 */
class Payment_Gateway {
	
	protected $api_username,$api_password;
	
	function setAuthorization($username,$password){
		$this->api_username = $username;
		$this->api_password = $password;
	}
	
	/**
	 * Perform the payment. Also known as 'capture' in other systems.
	 */
	function process($amount,$options = array()){
		
	}
	
}

class Payment_ExternalGateway extends Payment_Gateway{ //could extend Payment
  	
	static $redirect_url;
	protected $returnlink;
	
	/**
	 * Get or generate the link to redirect to external gateway.
	 */
	function getRedirectLink(){
	
	}
	
	/**
	 * Set the link to redirect FROM external gateway site.
	 * This will be given to the external gateway site to use
	 * at some stage;
	 */
	function setReturnLink($link){
		$this->returnlink = $link;
	}
	
	/**
	 * 
	 */
	function process($amount, $options = array()){
		//do processing
		return $this->getRedirectLink();
	}
	
}

class Payment_MerchantHosted extends Payment_Gateway{
	
}