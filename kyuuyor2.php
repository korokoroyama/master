<?php
//共通ファイルの読み込み
require_once('../common.php');
 
//コネクション取得
$conn = getConnection();  //←共通ファイルのfunctionが使える
?>
<html>
  <head>
<meta charset="utf-8">
<meta name="description" content="Scroll Table のデモでーす。">
    <title>DB Connect Test</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.22/themes/base/jquery-ui.css" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script src="jquery.scrolltable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script>
$(function(){
  $('.scrollTable').scrolltable({
    stripe: true,
    oddClass: 'odd'
   });
});
</script>

<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
}
th {
 word-break : break-all;	
    background-color: #ccc;
}
th, td {
    border: 1px solid #666;
    padding: 5px;
}
.key, .value {
    width: 100px;
}
thead, tbody {
    display: block;
}
tbody {
    overflow-y: scroll;
    height: 400px;
}
</style>  </head>
  <body>
    <strong>DB Connect Succeeded.</strong>
    <?php

$sql='select ';
$sql=$sql.'m_nenrei.m_nenrei_nenrei as nenrei1,m_nenrei.m_nenrei_nenreikyu as nenreikyu1,';
$sql=$sql.'m_nenrei.m_nenrei_gobo as gobo1,';
$sql=$sql.'m_shikaku.m_shikaku_shikaku as shikaku1,m_shikaku.m_shikaku_syokui as syokui1,m_shikaku.m_shikaku_syokusekikyu as syokusekikyu1,m_shikaku.m_shikaku_pitch as pitch1 ';
$sql=$sql.',m_shikaku.m_shikaku_itijikin as itiritu1,m_shikaku.m_shikaku_utikiri as utikiri1 ';
$sql=$sql.'from m_nenrei ';
//$sql=$sql.'left outer join gobo on nenrei.nenrei = gobo.nenrei ';
$sql=$sql.'left outer join m_shikaku on m_nenrei.m_nenrei_nenrei = (m_shikaku.m_shikaku_nenji + 21)';
//      $result= pg_query($dbconn,"SELECT * FROM test WHERE name='abc';");
///  	$result = pg_query('select * from nenrei left outer join gobo on nenrei.nenrei = gobo.nenrei left outer join syokuseki on nenrei.nenrei = (syokuseki.nenrei + 21)');
  	$result = pg_query($sql);
	if (!$result) {
		die('クエリーが失敗しました。'.pg_last_error());
	}


$seireki=2012;
$nenrei=22;
$syokunoukyu=142814;
$itiritu1=0;
$utikiri1=0;
$kijunn_nensyu=0;
$gai_nensyu=0;
$label='"'.$seireki.'年"';
$nenrei_gra='0';
$syokuseki_gra='0';
$syokuno_gra='0';
$gai_gra='0';


	//echo '<hr><table class="scrollTable" cellpadding="0" cellspacing="0" border="0">';
	
	echo '<hr>';
	echo '<table>';
//	echo '<table class="scrollTable" cellpadding="0" cellspacing="0" border="0">';

	echo '<thead>';
	echo' <tr>';
	echo '<th class="key">西暦</th>';
	echo '<th class="value">月</th>';
	echo '<th class="value">年次</th>';
	echo '<th class="value">年齢</th>';
	echo '<th class="value">資格</th>';
	echo '<th class="value">職位</th>';
	echo '<th class="value">号棒</th>';
	echo '<th class="value">ピッチ</th>';
	echo '<th class="value">年齢給</th>';
	echo '<th class="value">職責給</th>';
	echo '<th class="value">職能給</th>';
	echo '<th class="value">基準賃金</th>';
	echo '<th class="value">一律額</th>';
	echo '<th class="value">時給基礎額</th>';
	echo '<th class="value">業務打切手当</th>';
	echo '<th class="value">基準外賃金</th>';
	echo '<th class="value">月収</th>';
	echo '<th class="value">基準年収</th>';
	echo '<th class="value">基準外年収</th>';
	echo '<th class="value">年収</th>';
	echo '</tr>';
	echo '</thead>';	
	echo '<tbody>';
	for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
		$rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
//		$seireki=$seireki+1;

		for ($m = 0 ; $m < 12 ; $m++){

			echo '<tr>';
			if ($m == 0){
				if(!empty($rows['shikaku1'])){
					$shikaku=$rows['shikaku1'];
				}
				if(!empty($rows['syokui1'])){
					$syokui=$rows['syokui1'];
				}
				if(!empty($rows['pitch1'])){
					$pitch=$rows['pitch1'];
				}
				if(!empty($rows['gobo1'])){
					$syokunoukyu=$syokunoukyu+($pitch*$rows['gobo1']);
					//$pitch=$rows['pitch1'];
				}
				if(!empty($rows['nenreikyu1'])){
					$nenreikyu=$rows['nenreikyu1'];
				}
				if(!empty($rows['syokusekikyu1'])){
					$syokusekikyu1=$rows['syokusekikyu1'];
				}
				if(!empty($rows['itiritu1'])){
					$itiritu1=$rows['itiritu1'];
				}
				if(!empty($rows['utikiri1'])){
					$itiritu1=0;
					$utikiri1=$rows['utikiri1'];
				}
				$kijunn_nensyu=0;
				$gai_nensyu=0;
				$nensyu=0;
					
			}


			if ($m == 9){
				$seireki=$seireki+1;
			}
			if ($m > 8){
				$month=($m-8);
			}else{
				$month=($m+4);
			}

			if ($m == 7){
				$nenrei=$nenrei+1;
			}

			echo '<td class="key">'.$seireki.'</td>';
			echo '<td class="value">'.$month.'</td>';
			echo '<td class="value">'.($i+1).'</td>';
			echo '<td class="value">'.$nenrei.'</td>';
//			echo '<td class="value">'.$rows['int'].'</td>';

			echo '<td class="value">'.$shikaku.'</td>';
			echo '<td class="value">'.$syokui.'</td>';

			if ($m == 0){
				echo '<td class="value">'.$rows['gobo1'].'</td>';
				echo '<td class="value">'.$pitch.'</td>';
			}else{
				echo '<td class="value">-</td>';
				echo '<td class="value">-</td>';
			}

			echo '<td class="value">'. number_format($nenreikyu).'</td>';
			echo '<td class="value">'. number_format($syokusekikyu1).'</td>';
			echo '<td class="value">'. number_format($syokunoukyu).'</td>';

			echo '<td class="value"><b>'. number_format($nenreikyu+$syokusekikyu1+$syokunoukyu).'</b></td>';

			$nensyu=$nensyu+($nenreikyu+$syokusekikyu1+$syokunoukyu);
			$kijunn_nensyu=$kijunn_nensyu+($nenreikyu+$syokusekikyu1+$syokunoukyu);
			echo '<td class="value">'. number_format($itiritu1).'</td>';
			if($itiritu1==0){
				echo '<td class="value">0</td>';
				$niju=0;
			}else{
				echo '<td class="value">'. number_format(intval(($nenreikyu+$syokusekikyu1+$syokunoukyu)*0.23)).'</td>';
				$niju=intval(($nenreikyu+$syokusekikyu1+$syokunoukyu)*0.23);
			}
			echo '<td class="value">'. number_format($utikiri1).'</td>';

			echo '<td class="value"><b>'. number_format($itiritu1+$utikiri1+$niju).'</b></td>';

			$nensyu=$nensyu+$itiritu1+$utikiri1+$niju;
			$gai_nensyu=$gai_nensyu+$itiritu1+$utikiri1+$niju;

			echo '<td class="value">'. number_format($nenreikyu+$syokusekikyu1+$syokunoukyu+$itiritu1+$utikiri1+$niju).'</td>';

			if ($m == 9){//★$label
				$label=$label.',"'.$seireki.'年"';// "1月","2月","3月","4月","5月","6月","7月"
				$nenrei_gra=$nenrei_gra.','.$nenreikyu;//4,5,9,14,15,24,30
				$syokuseki_gra=$syokuseki_gra.','.$syokusekikyu1;
				$syokuno_gra=$syokuno_gra.','.$syokunoukyu;
				$gai_gra=$gai_gra.','.($itiritu1+$utikiri1+$niju);
			}

			if ($m == 11){
				echo '<td class="value">'. number_format(($kijunn_nensyu)).'</td>';
				echo '<td class="value">'. number_format(($gai_nensyu)).'</td>';
				echo '<td class="value"><b>'. number_format($nensyu).'</b></td>';
			}else{
				echo '<td class="value"></td>';
				echo '<td class="value"></td>';
				echo '<td class="value"></td>';
			}


			echo '</tr>';

		}
	}
	echo '</tbody>';
	echo '</table>';
	echo '<hr>';


$result = pg_query($sqlact);
//echo '<table rules="all">';

//echo '<table class="scrollTable" cellpadding="0" cellspacing="0" border="0"><thead>';
echo '<table><thead>';

echo '<tr>';
echo '<th class="key">';
echo "番号</th>";
$i = pg_num_fields($result);
$column=pg_num_fields($result);
for ($j = 0; $j < $i; $j++) {
	$fieldname = pg_field_name($result, $j);
//	echo '<th>';
	echo '<th class="value">';
//	echo '<th class="key">';
              echo '<a href="'.$filename.'.php?table='.$table."&sequence=".$fieldname.'" target="_blank">〇</a>'.$fieldname;
              echo "<br><hr>型:".pg_field_type($result, $j);
		echo "</th>";
              $countries[$j] = $fieldname;
		if($fieldname==$table."_id"){
			$id=$j;
		}

/*
              echo "fieldname: $fieldname\n";
              echo "<br>";
              echo "printed length: " . pg_field_prtlen($result, $fieldname) . " characters\n";
              echo "<br>";
              echo "storage length: " . pg_field_size($result, $j) . " bytes\n";
              echo "<br>";
              echo "field type: " . pg_field_type($result, $j) . " \n\n";
              echo "<br>";
*/

}

//★★個別部分-------------------------------------------------------

//★★整理用--------------------

//★★初期値既定
echo '</tr>';
echo "</thead><tbody>";
//echo $column."::<br>";

//★★カラム作成
for ($x = 0 ; $x < pg_num_rows($result) ; $x++){
              //★レコード情報取得
              $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
              echo "<tr>";
              //★テーブル作成
		echo '<td class="key">';
              //echo '<td>';.
		echo ($x+1).'</td>';
              for ($k = 0; $k < $column; $k++) {
//                        if(0 === strncmp($table, 'm_', 2)){
                            if( (0 === strncmp($table, 'm_', 2)) AND ($k==$id)){
	//				echo "<td>";
					echo '<td class="value">';
					echo '<script language="javascript"> ';
					echo 'function test'.$rows[$countries[$k]].'() { ';
					echo 'window.open("about:blank","ATMARK","width=600,height=450,scrollbars=yes");';
					//echo 'window.open("about;blank", "ATMARK") ;';
					echo 'window.document.inform'.$rows[$countries[$k]].'.action = "upsert.php" ;'; 
					echo 'window.document.inform'.$rows[$countries[$k]].'.target = "ATMARK" ; ';
					echo 'window.document.inform'.$rows[$countries[$k]].'.method = "POST" ; ';
					echo 'window.document.inform'.$rows[$countries[$k]].'.submit() ; ';
					echo '}';
					echo '</script>';

					echo '<form name="inform'.$rows[$countries[$k]].'">';
					echo '<input type="hidden" name="table" value="'.$table.'"/>';
					echo '<input type="hidden" name="id" value="'.$rows[$countries[$k]].'"/>';
					echo '<input type="button" value="'.$rows[$countries[$k]].'番の変更" onclick="test'.$rows[$countries[$k]].'();">';
					echo '</form> ';

					$maxid=MAX($maxid,$rows[$countries[$k]]);
                                          echo "</td>";                  
                            }else{
//                                          echo "<td>";
						echo '<td class="value">';
						echo $rows[$countries[$k]]."</td>";
                            }
              }
              echo "</tr>";
}
echo "</tr></tbody></table>";
echo '<hr>';

    ?>
  <canvas id="ch"></canvas>
<script>
var ctx = document.getElementById("ch").getContext("2d");
var chart = new Chart(ctx, {
  type: "bar",
  data:{
<?php
echo 'labels:['.$label.'],';
echo 'datasets:[';
echo '{';
echo "label: '"."年齢給"."',";
echo 'data:['.$nenrei_gra.'],';
echo 'backgroundColor: "red"';
echo '},';

echo '{';
echo "label: '"."職責給"."',";
echo 'data:['.$syokuseki_gra.'],';
echo 'backgroundColor: "orange"';
echo "},";

echo '{';
echo "label: '"."職能給"."',";
echo 'data:['.$syokuno_gra.'],';
echo 'backgroundColor: "blue"';
echo "},";

echo '{';
echo "label: '"."基準外賃金"."',";
echo 'data:['.$gai_gra.'],';
echo 'backgroundColor: "green"';
echo "}";
?>
]
  },
  options:{
    scales:{
      xAxes:[{
        stacked: true
      }],
      yAxes:[{
        stacked: true
      }]
    }
  }
});
</script>
  </body>
</html>