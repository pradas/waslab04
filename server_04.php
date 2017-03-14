<?php
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("http://localhost:8080/waslab04/WSLabService.wsdl");

function FahrenheitToCelsius($fdegree){
    $cresult = ($fdegree - 32) * (5/9);
    return array("cresult"=> $cresult, "timeStamp"=> date('c', time()) );
}

function CurrencyConverter($from_Currency,$to_Currency,$amount) {
	$uri = "http://currencies.apps.grandtrunk.net/getlatest/$from_Currency/$to_Currency";
	$rate = doubleval(file_get_contents($uri));
	return round($amount * $rate, 2);
};

// Task #4: Implement here the CurrencyConverterPlus function and add it to $server

function CurrencyConverterPlus($currencyConvert) {

	$currencyDesti = Array(); 

	$from_Currency = $currencyConvert->from_Currency;
	$amount = $currencyConvert->amount;

	foreach ($currencyConvert->to_Currency as $value) {
		$curren = new stdClass();
	    $curren->currency = $value;
	    $curren->amount =  CurrencyConverter($from_Currency, $value, $amount);

		$currencyDesti[] = $curren;
	}

	return $currencyDesti;
	
};

$server->addFunction("CurrencyConverterPlus");

$server->addFunction("FahrenheitToCelsius");

// Task #3 -> Uncomment the following line:
$server->addFunction("CurrencyConverter");

$server->handle();
 
?>
