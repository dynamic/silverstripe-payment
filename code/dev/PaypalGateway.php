<?php

class PaypalExpress_Gateway extends Payment_ExternalGateway{
	
	private static $api_endpoint = "https://api-3t.paypal.com/nvp";
	private static $external_redirect = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
	
	function getRedirectLink(){
	
		return self::$external_redirect.$token.'&useraction=commit'; //useraction=commit ensures the payment is confirmed on PayPal, and not on a merchant confirm page.
	}
	
	
	
}

class PaypalExpress_Gateway_Test extends PaypalExpress_Gateway{
	
	private static $api_endpoint = "https://api-3t.sandbox.paypal.com/nvp";
	private static $external_redirect = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
	
	
}

class PaypalExpress_Gateway_Mock extends PaypalExpress_Gateway{
	
}