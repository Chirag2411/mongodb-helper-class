<?php
/*
 * ===============================================================
 * Class to retrive latest MongoDb Drivers to your website
 * ===============================================================
 */
/*
 * ===============================================================
 * Class to Help MongoDB operation in PHP
 * ===============================================================
 */

/*
 *  CLASS NAME: "MongoDbhelper"
 */

class MongoDbhelper
{
   
   // constructor
   public function __construct() 
   {
      // static info for driver hosting URL
      $this->driver_url  = 'https://s3.amazonaws.com/drivers.mongodb.org/';      
   }
   
    /** ----- This function is to init database connection (1) -------------------------------
   * @PARAMS: Username, Password, Database Name, Host Name
   * @RETURN: void
   * **/
   function MongoConnect($username, $password, $database, $host) {
      $con = new Mongo("mongodb://{$username}:{$password}@{$host}"); // Connect to Mongo Server
      $db = $con->selectDB($database); // Connect to Database
    }

   /** ----- This function is to retrive latest MongoDb Drivers to your website (1) -------------------------------
   * @PARAMS: Driver URL 
   * @RETURN: void
   * **/
   public function getDrivers(){

    $response = false;

    $XmlDriverObj = self::curl_request();

    if(!$XmlDriverObj){
      $response['error_server']   = debug_backtrace();
      $response['error_msg']      = 'ERROR: Request Failed';
    }else{
      self::parse_xml_to_driver($XmlDriverObj);
     }

     return $response;

   }

   private function curl_request(){
    $content = false;

    $ch = curl_init();

    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, $this->driver_url); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, '30');
    $content = trim(curl_exec($ch));
    curl_close($ch);

    return $content;

   }

   private function parse_xml_to_driver($xml=false)
   {
        $response = false;

        if($xml != false && 0 < strlen($xml) ){
             $xmlobj = simplexml_load_string($xml); // assume XML in $x

                foreach ($xmlobj->children()->Contents as $value) {
                      var_dump($value);
         
                }
        }
        return $response;
   }

}

    $objMongoDbhelper = new MongoDbhelper;
    $objMongoDbhelper->getDrivers();


?>
