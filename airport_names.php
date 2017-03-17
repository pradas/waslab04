<?php
ini_set("soap.wsdl_cache_enabled","0");

try{

  $sClient = new SoapClient('http://www.webservicex.net/airport.asmx?WSDL');

  $country = new stdClass();
  $country->country = $_GET["country"];

  $result = $sClient->GetAirportInformationByCountry($country);
  $airports = new SimpleXMLElement($result->GetAirportInformationByCountryResult);

  $arr = Array();

  $i = 0;
  foreach ($airports->Table as $airport) {
    $arr[$i]["name"] = (string)$airport->CityOrAirportName;
    $arr[$i]["code"] = (string)$airport->AirportCode;
    $i++;
  }
  sort($arr);

  $arr2 = Array();
  $i = 0;
  foreach ($arr as $item) {
  	if($i % 2 == 0) {
       $arr2[]=$arr[$i]; 
  	}
    $i++;
  }

  echo json_encode($arr2);

}
catch(SoapFault $e){
  header(':', true, 500);
  echo json_encode($e);
}

