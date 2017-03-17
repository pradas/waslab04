<?php
ini_set("soap.wsdl_cache_enabled","0");

try{

  $sClient = new SoapClient('http://www.webservicex.net/airport.asmx?WSDL');

  // Get the necessary parameters from the request
  // Use $sClient to call the operation GetWeather
  // echo the returned info as a JSON object

  $code = new stdClass();
  $code->airportCode = $_GET['code'];
  
  $result = $sClient->GetAirportInformationByAirportCode($code);
  $info = new SimpleXMLElement($result->getAirportInformationByAirportCodeResult);

  echo json_encode($info->Table);
  
}
catch(SoapFault $e){
  header(':', true, 500);
  echo json_encode($e);
}
?>
