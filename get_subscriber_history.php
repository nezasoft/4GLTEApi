<?php
/**
 * @author Walter Omedo - Frontier Optical Networks Limited -- Get Subscriber History
 * 31st May 2017
 */
ini_set('soap.wsdl_cache_enabled', 0);
ini_set('soap.wsdl_cache_ttl', 900);
ini_set('default_socket_timeout', 15);
ini_set('display_errors',false);

class MySoapClient extends SoapClient {
    public function __doRequest($sRequest, $sLocation, $sAction, $iVersion, $iOneWay = 0) {
        $sRequest = str_replace('ns1', 'get', $sRequest);
        $this->__last_request = $sRequest;

        return parent::__doRequest(ltrim($sRequest), $sLocation, $sAction, $iVersion, $iOneWay);
    }
}

//User credentials
  $portaluser ='FON';
  $username='FON';
  $password ='e240b9820925d75275a506efc774effa';
  $partner_code ='1002';
  $cur_time = date('Ymd');
  $action ='getTransactionHistory';
  $service ='getHistory';
  $version ='1.0';
  $method ='get';
  $subscriber_no =798567935;
  $date_from = '2017-05-20';
  $date_to ='2011-05-31';
  $start =0;
  $maxRecords = 10;


function call_soap_wsdl($method,$portaluser,$username,$password,$partner_code,$cur_time,$action,$version,$params,$subscriber_no,$service,$date_from,$date_to,$start,$maxRecords) {
  
  $xml = new XMLWriter();
  $xml->openMemory();
  $xml->startElementNS($method,'ServiceRequest',null);//Service Request
	$xml->startElementNS($method,'Header',null);//Header
		$xml->startElementNS($method,'RequestId',null);//RequestId
		$xml->Text(1);
		$xml->endElement();
		$xml->startElementNS($method,'RequestTimeStamp',null);//RequestTimeStamp
		$xml->Text($cur_time);
		$xml->endElement();
		$xml->startElementNS($method,'Service',null);//Service
		$xml->Text($service);
		$xml->endElement();
		$xml->startElementNS($method,'PartnerCode',null);//PartnerCode
		$xml->Text($partner_code);
		$xml->endElement();
		$xml->startElementNS($method,'Version',null);//Version
		$xml->Text($version); 
		$xml->endElement();
		$xml->startElementNS($method,'Credentials',null);//Credentials
			$xml->startElementNS($method,'PortalUserName',null);//Portal Username
			$xml->Text($portaluser); 
			$xml->endElement();
			$xml->startElementNS($method,'APIUsername',null);//APIUsername
			$xml->Text($username); 
			$xml->endElement();
			$xml->startElementNS($method,'APIPassword',null);//API Password
			$xml->Text($password); 
			$xml->endElement();
		$xml->endElement();
	$xml->endElement();//End of Header
	//Start Body
	$xml->startElementNS($method,'Body',null);//Body
		$xml->startElementNS($method,'SubscriberNo',null);//Subscriber No
		$xml->Text($subscriber_no);
		$xml->endElement();
		$xml->startElementNS($method,'FromDate',null);//From Date
		$xml->Text($date_from);
		$xml->endElement();
		$xml->startElementNS($method,'ToDate',null);//To Date
		$xml->Text($date_to);
		$xml->endElement();
		$xml->startElementNS($method,'StartRecordIndex',null);//Start Record Index
		$xml->Text($start);
		$xml->endElement();
		$xml->startElementNS($method,'MaxRecords',null);//Maximum Records
		$xml->Text($maxRecords);
		$xml->endElement();
	$xml->endElement();
	
  $xml->endElement();//End of service request

  //Convert it to a valid SoapVar
  $args = new SoapVar($xml->outputMemory(), XSD_ANYXML);
  
  $options = array(
		'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
		'style'=>SOAP_RPC,
		'use'=>SOAP_ENCODED,
		'soap_version'=>SOAP_1_1,
		'cache_wsdl'=>WSDL_CACHE_NONE,
		'connection_timeout'=>30,
		'trace'=>true,
		'encoding'=>'UTF-8',
		'exceptions'=>true,
	);
  $wsdl = 'http://196.201.214.115:5600/?wsdl';
  $client = new MySoapClient($wsdl, $options);  
  $client->__setLocation('http://196.201.214.115:5600/LTESharing');                                                                              
  $ns = 'http://safaricom.co.ke/schemas/partners/LTE_sharing/GetTransactionHistory'; //Namespace of the web service.
  $header = new SOAPHeader($ns,'Body','',false);
  //set the Headers of Soap Client. 
  $client->__setSoapHeaders($header);
  try{
   $result = $client->__SoapCall($action, array($args));
	   //$result = $client->__SoapCall('insertUser', $params);
	
	//echo "Request :<br>", $client->__getLastRequest(), "<br>";
    echo "Response :<br>", $client->__getLastResponse(), "<br>";
  }catch (Exception $e) {
    //Handle Exception - Use $client->__getLastRequestHeaders(), 
    //$client->__getLastRequest(), $client->__getLastResponse().
    $result = FALSE;
	echo $e->getMessage();
  }
  return $result;
}
echo call_soap_wsdl($method,$portaluser,$username,$password,$partner_code,$cur_time,$action,$version,$params,$subscriber_no,$service,$date_from,$date_to,$start,$maxRecords);
?>




