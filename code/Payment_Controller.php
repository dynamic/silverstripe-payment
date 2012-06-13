<?php

/**
 * Helpful controller class for making payments.
 * Handles return redirects from external gateways.
 * 
 * @package payment
 */
class Payment_Controller extends Controller {
	
	private $gateway, $post_redirect;
	
	static $allowed_actions = array(
		'response'		
	);
  
	static $url_segment = 'payment';
	
	function __construct(Gateway $gateway){ //TODO: this won't work for redirects
		$this->gateway = $gateway;
	}

	function Link($action = ""){
		return Controller::join_links(self::$url_segment,$action);
	}

	/**
	 * Inject a payment gateway into this controller.
	 */
	function setGateway(PaymentGateway $g) {
		$this->gateway = $g;
	}
	
	/**
	 * Choose where to redirect after payment has been attempted
	 */
	function setPostRedirect($link){
		$this->post_redirect = $link;
	}
	
	/**
	 * Performs the actual payment, and redirects to the appropriate place:
	 * the gateway, or the passed redirect location
	 * 
	 * @return Payment $payment
	 */
	function processPayment(Payment $payment){
		if($this->gateway instanceof Payment_ExternalGateway){
			$this->gateway->setReturnLink(Controller::join_links($this->Link('response'),$payment->ID));
		}
		$redirect = $this->gateway->process($payment);
		if(!$redirect) $redirect = $this->post_redirect;
		if($redirect){
			$this->redirect($redirect);
		}
		return $payment;
	}
  
	/**
	 * Response action for handling redirects from the external gateway.
	 */
	function response($request){
		$payment = DataObject::get_by_id('Payment',$request->param('ID'));
		$responsehandler = $this->gateway->postProcess($payment->amount); //TODO: remove this model coupling
		$this->redirect($this->post_redirect);
		return;
	}

}