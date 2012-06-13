<?php

/**
 * Factory class to allow easy initiation of payment objects
 */
class PaymentFactory {
  /**
   * Construct an instance of this object given the name of the desired payment gateway
   * 
   * @param $gatewayName
   * @return PaymentProcessor
   */
  public static function createGateway($gatewayName) {
  		if(ClassInfo::exists($gatewayName)){
  			return new $gatewayName();
		}
  		return null;
	}
  
	public static function createPayment($data){
  		$payment = new Payment();
  		$payment->update(Convert::raw2sql($data));
  		$payment->Amount->Amount = $data['Amount'];
  		$payment->Amount->Currency = $data['Currency'];
  		$payment->write();
  		return $payment;
	}
  	
	static $field_map = array(
		'amount' => 'CurrencyField',
		'gateway' => 'TextField', //should be a dropdown
		'currency' => 'TextField', //should be a dropdown
		'address1' => 'TextField'
	);
	
	/**
	 * Generate fields for a gateway
	 */
	public static function scaffoldFields($fields){
		$fieldlist = new FieldList();
		foreach($fields as $field){
			if(ClassInfo::exists($field) && $field instanceof FormField){
				$fieldlist->add(Object::create($field));
			}
		}
		return $fieldlist;
	}
	
}