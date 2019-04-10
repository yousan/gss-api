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
	$url = 'https://docs.google.com/spreadsheets/d/' . $gss_id . '/export?format=csv&gid=635058114';

	$csv   = file_get_contents( $url );
	$array = array_map( "str_getcsv", explode( "\n", $csv ) );
	$json  = json_encode( $array );
	var_dump( $json );
	echo 'hello';
}

function parseCSV( $url ) {
	// @see https://blog.keinos.com/20170523_2295
	$file = new NoRewindIterator( new SplFileObject( $url ) );

	$file->setFlags( SplFileObject::READ_CSV );

	$datas  = [];
	$header = null;
	while ( $row = $file->fgetcsv() ) {
		if ( null === $header ) { // 初回の一行目
			$header = $row;
			continue;
		}
		if ( count( $row ) === 1 || // 空行だったりした場合
		     empty( $row[0] ) || // 最初の行はIDで固定だが、そこが省かれている場合には省く
		     'null' === $row[0] // 最初の列にnullと書いてある行は省く
		) {
			continue;
		}
		$data = array_combine( $header, $row );
		foreach ( $data as $key => $value ) {
			if ( ! is_numeric( $data[ $key ] ) && // emptyが 0 を trueと解釈してしまうため
			     empty( $data[ $key ] ) ) { // 空行　
				unset( $data[ $key ] ); // 空行は許されないのでNULLにしておく
			}
		}
		if ( empty( $data['created'] ) ) {
			$data['created'] = date( 'Y-m-d H:i:s' );
		}
		if ( empty( $data['modified'] ) ) {
			$data['modified'] = date( 'Y-m-d H:i:s' );
		}

		$datas[] = $data;
	}

	return $datas;
}

function main() {
// https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114

// スプレッドシートのID
	$gss_id = $_GET['gss_id'];
// シートID
	$gid = $_GET['gid'];

	$url = 'https://docs.google.com/spreadsheets/d/' . $gss_id . '/export?format=csv&gid=' . $gid;

	$data = parseCSV($url);
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: *');

	echo json_encode($data);
}

main();
