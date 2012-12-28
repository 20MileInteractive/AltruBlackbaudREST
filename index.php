<?php 

require_once("xml2array.php");

// $startTime      = mktime(0, 0, 5, 12, 1, 2012);
// $endTime        = mktime(0, 0, 5, 1, 1, 2013);

$startTime      = time();
$endTime        = strtotime('+30 days');

$startDate      = date(DATE_ATOM, $startTime);
$endDate        = date(DATE_ATOM, $endTime);
$maxRows        = 0;
$sort           = 'Ascending';
$includeMeta    = 'true';

$post_string = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <DataListLoadRequest xmlns="Blackbaud.AppFx.WebService.API.1">
            <ClientAppInfo REDatabaseToUse="B52D22BB-0D98-41B7-B227-4CD58FA556E8" ClientAppName="Cotuit_Test" TimeOutSeconds="0" RunAsUserID="00000000-0000-0000-0000-000000000000" />
            <DataListID>d1c3c00a-b56e-4a05-9fca-c43ec737b5d9</DataListID>
            <ContextRecordID>2</ContextRecordID>
            <Parameters>
                <Values xmlns="bb_appfx_dataforms">
                    <fv ID="CONSTITUENTID"><Value xmlns:q1="http://microsoft.com/wsdl/types/" xsi:type="q1:guid">00000000-0000-0000-0000-000000000000</Value></fv>
                    <fv ID="DATESELECTTYPE"><Value xsi:type="xsd:int">4</Value></fv>
                    <fv ID="STARTDATE"><Value xsi:type="xsd:dateTime">$startDate</Value></fv>
                    <fv ID="ENDDATE"><Value xsi:type="xsd:dateTime">$endDate</Value></fv>
                    <fv ID="SHOWPAST"><Value xsi:type="xsd:boolean">true</Value></fv>
                </Values>
            </Parameters>
            <MaxRows>$maxRows</MaxRows>
            <ViewFormID>00000000-0000-0000-0000-000000000000</ViewFormID>
            <SortDirection>$sort</SortDirection>
            <IncludeMetaData>$includeMeta</IncludeMetaData>
            <ResultsAsXml>true</ResultsAsXml>
        </DataListLoadRequest>
    </soap:Body>
</soap:Envelope>
EOF;

$url = 'https://altrurig01bo3.blackbaudhosting.com/48291_f3ee9791-4fd7-4c0a-87a3-2dc28928e2e3/appfxwebservice.asmx';

$user = 'areddington48291';
$password = 'pw@20mile';

$soap_do = curl_init(); 
curl_setopt($soap_do, CURLOPT_URL,            $url );   
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($soap_do, CURLOPT_POST,           true ); 
curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $post_string); 
curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) )); 
curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password);

$result = curl_exec($soap_do);
$err = curl_error($soap_do); 

$arr = xml2array($result);

// var_dump($arr["soap:Envelope"]["soap:Body"]["DataListLoadReply"]["XmlResults"]["listItems"]);
var_dump($arr["soap:Envelope"]["soap:Body"]["DataListLoadReply"]["XmlResults"]["listItems"]);

?>