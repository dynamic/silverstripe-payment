<?php

/**
 * Dummy gateway for making test payments.
 * 
 * Test cent values:
 * .01 - incomplete payment
 * .02 - failed payment
 * .03 - payment is pending
 * else - successful payment
 */
class Dummy_Gateway extends Payment_MerchantHosted{
	
	function process($amount, $options = array()){
		$cents = round($amount - intval($amount),2);
		switch($cents){
			case 0.01:
				$payment->Status = "Incomplete";
				break;
			case 0.02:
				$payment->Status = "Failure";
				break;
			case 0.03;
				$payment->Status = "Pending";
				break;
			default:
				$payment->Status = "Success";	
		}
		$payment->write();
	}
	
	public function getFormFields() {
		$fields = parent::getFormFields();
		$fields->push(new TextField('PaymentMethod', 'Payment Method', get_class($this)));
		$fields->push(new NumericField('Amount', 'Amount', '10.00'));
		$fields->push(new TextField('Currency', 'Currency', 'NZD'));
		return $fields;
	}
	
}

/**
 *
 */
class Dummy_ExternalGateway extends Payment_ExternalGateway{
	
	static $redirect_url = "Dummy_ExternalGateway";
	
	function process($amount, $options = array()){
		
	}
	
}

/**
 * Imaginary place to visit external gateway
 */
class Dummy_ExternalGateway_Controller extends Controller{
	
	function pay($request){
		Session::set('returnurl',$request->requesetVar("returnurl"));
		return array(
			'Content' => "Fill out this form to make payment",
			'Form' => $this->PayForm()
		);
	}
	
	function PayForm(){
		$fields = new FieldList(
			new TextField("name"),
			new CreditCardField("creditcard"),
			new DateField("issued"),
			new DateField("expiry")
		);
		$actiions = new FieldList(
			new FormAction("dopay")
		);
		return Form($this,"PayForm",$fields,$actions);
	}
	
	function dopay(){
		
		//TODO: get stats values
		
		Director::redirect(Session::get('returnurl')); //TODO: add get params
	}
	
}