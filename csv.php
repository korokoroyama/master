<?php
$dbname="postgres";
$usern="postgres";//�ڑ����[�U��
$passw="korokoroyama";//���[�U�p�X���[�h
$conn = "host=localhost dbname=".$dbname." user=".$usern." password=".$passw;
$link = pg_connect($conn);
if (!$link) {
              die('�ڑ����s�ł��B'.pg_last_error());
}

//����SQL�쐬
$table=$_GET["table"];
// �o�͏��̐ݒ�
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$table.".csv");
header("Content-Transfer-Encoding: binary");

// �ϐ��̏�����
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

//����SQL���s
$result = pg_query($sqlact);
$i = pg_num_fields($result);
$column=pg_num_fields($result);
for ($j = 0; $j < $i; $j++) {
	$fieldname = pg_field_name($result, $j);
	// 1�s�ڂ̃��x�����쐬
	if($j>0){
		$csv=$csv.",";
	}
	$csv =$csv.'"'.$fieldname.'"';
	$countries[$j] = $fieldname;
}
$csv=$csv."\n";

//�����ʕ���-------------------------------------------------------
for ($x = 0 ; $x < pg_num_rows($result) ; $x++){
	//�����R�[�h���擾
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
// CSV�t�@�C���o��
echo $csv;
return;