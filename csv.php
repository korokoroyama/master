<?php
$dbname="postgres";
$usern="postgres";//接続ユーザ名
$passw="korokoroyama";//ユーザパスワード
$conn = "host=localhost dbname=".$dbname." user=".$usern." password=".$passw;
$link = pg_connect($conn);
if (!$link) {
              die('接続失敗です。'.pg_last_error());
}

//★★SQL作成
$table=$_GET["table"];
// 出力情報の設定
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$table.".csv");
header("Content-Transfer-Encoding: binary");

// 変数の初期化
$member = array();
$csv = null;

$sqlact="select * ";
$sqlact=$sqlact."FROM ".$table;
/*
$sql='select ';
$sql=$sql.'m_nenrei.m_nenrei_nenrei as nenrei1,m_nenrei.m_nenrei_nenreikyu as nenreikyu1,';
$sql=$sql.'m_nenrei.m_nenrei_gobo as gobo1,';
$sql=$sql.'m_shikaku.m_shikaku_shikaku as shikaku1,m_shikaku.m_shikaku_syokui as syokui1,m_shikaku.m_shikaku_syokusekikyu as syokusekikyu1,m_shikaku.m_shikaku_pitch as pitch1 ';
$sql=$sql.',m_shikaku.m_shikaku_itijikin as itiritu1,m_shikaku.m_shikaku_utikiri as utikiri1 ';
$sql=$sql.'from m_nenrei ';
//$sql=$sql.'left outer join gobo on nenrei.nenrei = gobo.nenrei ';
$sql=$sql.'left outer join m_shikaku on m_nenrei.m_nenrei_nenrei = (m_shikaku.m_shikaku_nenji + 21)';
$sqlact=$sql;
*/

//★★SQL実行
$result = pg_query($sqlact);
$i = pg_num_fields($result);
$column=pg_num_fields($result);
for ($j = 0; $j < $i; $j++) {
	$fieldname = pg_field_name($result, $j);
	// 1行目のラベルを作成
	if($j>0){
		$csv=$csv.",";
	}
	$csv =$csv.'"'.$fieldname.'"';
	$countries[$j] = $fieldname;
}
$csv=$csv."\n";

//★★個別部分-------------------------------------------------------
for ($x = 0 ; $x < pg_num_rows($result) ; $x++){
	//★レコード情報取得
	$rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
	for ($k = 0; $k < $column; $k++) {
		if($k>0){
			$csv=$csv.",";
		}
		$member[$x][$k]=$rows[$countries[$k]];
		$csv=$csv.'"'.$rows[$countries[$k]].'"';
	}
	$csv=$csv."\n";
}
// CSVファイル出力
echo $csv;
return;