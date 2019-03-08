<?php
/**
* Created by PhpStorm.
* User: yousan
* Date: 2019-03-08
* Time: 18:17
*/


function main1() {
// https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114

// スプレッドシートのID
$gss_id = '1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE';
// シートID
$gid = '635058114';
$url = 'https://docs.google.com/spreadsheets/d/'.$gss_id.'/export?format=csv&gid=635058114';

$csv= file_get_contents($url);
$array = array_map("str_getcsv", explode("\n", $csv));
$json = json_encode($array);
var_dump($json);
echo 'hello';
}

function main() {
// https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114

// スプレッドシートのID
$gss_id = $_GET['gss_id'];
// シートID
$gid = $_GET['gid'];

$url = 'https://docs.google.com/spreadsheets/d/'.$gss_id.'/export?format=csv&gid='.$gid;

$csv= file_get_contents($url);
$array = array_map("str_getcsv", explode("\n", $csv));
$json = json_encode($array);
var_dump($json);
echo 'hello';
}

main();
