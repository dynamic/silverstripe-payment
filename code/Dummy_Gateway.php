<?php 

class Dummy_Gateway extends Payment_Gateway {
  
  public function process($data) { 
    Session::set('amount', $data['Amount']);
    Director::redirect($this->returnURL);
  }
  
  public function getResponse($response) {
    $amount = Session::get('amount');
    $cents = round($amount - intval($amount), 2);
    return new Dummy_Gateway_Result($cents);
    
  }
}

class Dummy_Gateway_Result extends Gateway_Result{
	
	function parse(){
		switch ($this->data) {
			case 0.01:
				$this->status = Gateway_Result::SUCCESS;
				break;
			case 0.02:
				$this->status = Gateway_Result::FAILURE;
				break;
			case 0.03:
				$this->status = Gateway_Result::INCOMPLETE;
				break;
		}
	}
	
}

class Dummy_Production_Gateway extends Dummy_Gateway { }