<?php 

/**
 * "Abstract" class for a number of payment models
 * 
 *  @package payment
 */
class Payment extends DataObject {
  
  /**
   * Incomplete (default): Payment created but nothing confirmed as successful
   * Success: Payment successful
   * Failure: Payment failed during process
   * Pending: Payment awaiting receipt/bank transfer etc
   */
  public static $db = array(
    'Status' => "Enum('Incomplete, Success, Failure, Pending')",
    'Amount' => 'Money',
    'Message' => 'Text',
    'PaidForID' => "Int",
    'PaidForClass' => 'Varchar',

    //Used for storing any Exception during this payment Process.
    'ExceptionError' => 'Text'
  );
  
  public static $has_one = array(
    'PaidObject' => 'Object',
    'PaidBy' => 'Member',
  );
  
  /**
   * Make payment table transactional.
   */
  static $create_table_options = array(
    'MySQLDatabase' => 'ENGINE=InnoDB'
  );
  
  /**
   * The currency code used for payments.
   * @var string
   */
  protected static $site_currency = 'USD';
  
  /**
   * Set the currency code that this site uses.
   * @param string $currency Currency code. e.g. "NZD"
   */
  public static function set_site_currency($currency) {
    self::$site_currency = $currency;
  }
  
  /**
   * Return the site currency in use.
   * @return string
   */
  public static function site_currency() {
    return self::$site_currency;
  }
  
  function populateDefaults() {
    parent::populateDefaults();
  
    $this->Amount->Currency = Payment::site_currency();
  }
}