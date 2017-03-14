<?php
header("Content-Type: text/plain");
ini_set("soap.wsdl_cache_enabled","0");
date_default_timezone_set("Europe/Andorra");

try{
	$sClient = new SoapClient('http://localhost:8080/waslab04/WSLabService.wsdl', array('trace' => 1));

	$fahrenheitTemp = "63.5";
	$response = $sClient->FahrenheitToCelsius($fahrenheitTemp);

	echo "\n   ";
	echo $fahrenheitTemp, ' Fahrenheit ==> ', $response["cresult"], ' Celsius ';
	echo "[Server TimeStamp: ", date('l jS \of F Y @ h:i:s A',strtotime($response["timeStamp"])), "]\n";

	/* Task #2: Write your code here. Use the function xmlpp (implemented below)
	 * to print the 2 SOAP messages (request and response).*/

  echo "\n \n----------- HTTP REQUEST : \n";
  echo $sClient->__getLastRequestHeaders() . "\n";
  echo xmlpp($sClient->__getLastRequest());
  echo "\n \n----------- HTTP RESPONSE : \n";
  echo $sClient->__getLastResponseHeaders() . "\n";
  echo xmlpp($sClient->__getLastResponse());
	
	// Task #3: Uncomment the following lines:
	$inCur = "EUR";
	$outCur = "CNY";
	$inAmount = 100;
	$outAmount = $sClient->CurrencyConverter($inCur,$outCur,$inAmount);
	echo "\n   ", $inAmount, " ",$inCur, " ==> ",$outAmount, " ",$outCur,"\n\n";
	
	
	// Task #4: Call CurrencyConverterPlus and display its result:
	$currency = new stdClass();
  $currency->from_Currency = "CNY";
  $currency->to_Currency = ["EUR", "CAD", "TRY"];
  $currency->amount = 1000;

  $outAmount = $sClient->CurrencyConverterPlus($currency);

  echo $currency->amount, " ", $currency->from_Currency, "\n";
  foreach ($outAmount as $value) {
    echo "        ==> ", $value->amount, " ",$value->currency, "\n";
  }
	
	
} catch(SoapFault $e){
	echo "ERROR";
	var_dump($e);
}

// ---------------------------------------------------------------------------
// Function xmlpp prints a xml-formatted string ($xml) with a proper nesting
function xmlpp($xml) {  
    $xml_obj = new SimpleXMLElement($xml);  
    $level = 4;  
    $indent = 0; // current indentation level  
    $pretty = array();  
      
    // get an array containing each XML element  
    $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));  
  
    // shift off opening XML tag if present  
    if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {  
      $pretty[] = array_shift($xml);  
    }  
  
    foreach ($xml as $el) {  
      if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {  
          // opening tag, increase indent  
          $pretty[] = str_repeat(' ', $indent) . $el;  
          $indent += $level;  
      } else {  
        if (preg_match('/^<\/.+>$/', $el)) {              
          $indent -= $level;  // closing tag, decrease indent  
        }  
        if ($indent < 0) {  
          $indent += $level;  
        }  
        $pretty[] = str_repeat(' ', $indent) . $el;  
      }  
    }     
    $xml = implode("\n", $pretty);     
    return $xml;  
}  
?>
