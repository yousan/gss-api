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
			// GSSでは見出し行（１行目）に何も入っていなくても、下の行に要素がある場合にはCSVとして空の要素を作成する。
			// そのまま配列として使うと名前の無いAttributeになってしまうので、それを取り除く
			// e.g. https://gyazo.com/5e945b857038be7b0b066554824f9afc
			$header = array_filter( $row, 'strlen' );
			continue;
		}
		if ( count( $row ) === 1 || // 空行だったりした場合
		     empty( $row[0] ) || // 最初の行はIDで固定だが、そこが省かれている場合には省く
		     'null' === $row[0] // 最初の列にnullと書いてある行は省く
		) {
			continue;
		}
		$data_row = array_reduce_number( $row, count( $header ) ); // ヘッダー行のカラム数以下に減らす
		$data     = array_combine( $header, $data_row );
		foreach ( $data as $key => $value ) {
			if ( ! is_numeric( $data[ $key ] ) && // emptyが 0 を trueと解釈してしまうため
			     empty( $data[ $key ] ) ) { // 空行　
				unset( $data[ $key ] ); // 空行は許されないのでNULLにしておく
			}
		}
		if ( empty( $data['created_at'] ) ) {
			$data['created_at'] = date( 'Y-m-d H:i:s' );
		}
		if ( empty( $data['updated_at'] ) ) {
			$data['updated_at'] = date( 'Y-m-d H:i:s' );
		}

		$datas[] = $data;
	}

	return $datas;
}

/**
 * 配列の先頭から$count個まで減らす。
 *
 * e.g. array_reduce_number([1,2,3,4], 3) => [1,2,3]
 */
function array_reduce_number( $array, $count ) {
	$ret = [];
	for ( $i = 0; $i < count( $array ) && $i < $count; $i ++ ) {
		$ret[] = $array[ $i ];
	}

	return $ret;
}

function main() {
	// e.g. https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114
	// スプレッドシートのID
	$gss_id = $_GET['gss_id'];
	// シートID
	$gid = $_GET['gid'];

	$url = 'https://docs.google.com/spreadsheets/d/' . $gss_id . '/export?format=csv&gid=' . $gid;

	$data = parseCSV( $url );
	header( "Access-Control-Allow-Origin: *" );
	header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' );
	header( 'Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization' );
	header( 'Content-Type: application/json' );

	echo json_encode( $data, JSON_PRETTY_PRINT );
}

main();
