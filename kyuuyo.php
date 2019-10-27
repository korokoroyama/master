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
<style type="text/css">
		body{ font-size: 0.9em; font-family: Arial, Verdana, sans-serif; color:#555; }
		h1{ margin-top: 0; float: left; }
		#controls{ float: left; padding: 0.3em 1em; }
		table.scrollTable{
			width:100%; 
			border:1px solid #ddd000;
		}
		thead{

			background-color: #eee;
		}
		thead th{
			border-top:1px solid #eee000;
			border-right:1px solid #eeF000;
			text-align: center;
			padding:0.1em 0.3em;
		}
		tbody td{
			border-top:1px solid #eee000;
			border-right:1px solid #eee000;
			padding:0.1em 0.3em;
		}
		tbody tr.odd td{
			background-color: #f9f9f9;
		}
	</style>




  </head>
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
	
	echo '<hr><table class="scrollTable" cellpadding="0" cellspacing="0" border="0">';
	echo' <tr>';
	echo '<thead>';
	echo '<th>西暦</th>';
	echo '<th>月</th>';
	echo '<th>年次</th>';
	echo '<th>年齢</th>';
	echo '<th>資格</th>';
	echo '<th>職位</th>';
	echo '<th>号棒</th>';
	echo '<th>ピッチ</th>';
	echo '<th>年齢給</th>';
	echo '<th>職責給</th>';
	echo '<th>職能給</th>';
	echo '<th>基準賃金</th>';
	echo '<th>一律額</th>';
	echo '<th>時給基礎額</th>';
	echo '<th>業務打切手当</th>';
	echo '<th>基準外賃金</th>';
	echo '<th>月収</th>';
	echo '<th>基準年収</th>';
	echo '<th>基準外年収</th>';
	echo '<th>年収</th>';
	echo '</tr>';
	echo '</thead>';	
	echo '<tbody>';
	for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
		$rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
//		$seireki=$seireki+1;

		for ($m = 0 ; $m < 12 ; $m++){
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
			if($seireki==2019 AND $month==10){
				echo '<tr bgcolor="#FFF000">';
			}else{
				echo '<tr>';
			}
			echo '<td>'.$seireki.'</td>';
			echo '<td>'.$month.'</td>';
			echo '<td>'.($i+1).'</td>';
			echo '<td>'.$nenrei.'</td>';
//			echo '<td>'.$rows['int'].'</td>';

			echo '<td>'.$shikaku.'</td>';
			echo '<td>'.$syokui.'</td>';

			if ($m == 0){
				echo '<td>'.$rows['gobo1'].'</td>';
				echo '<td>'.$pitch.'</td>';
			}else{
				echo '<td>-</td>';
				echo '<td>-</td>';
			}

			echo '<td>'. number_format($nenreikyu).'</td>';
			echo '<td>'. number_format($syokusekikyu1).'</td>';
			echo '<td>'. number_format($syokunoukyu).'</td>';

			echo '<td><b>'. number_format($nenreikyu+$syokusekikyu1+$syokunoukyu).'</b></td>';

			$nensyu=$nensyu+($nenreikyu+$syokusekikyu1+$syokunoukyu);
			$kijunn_nensyu=$kijunn_nensyu+($nenreikyu+$syokusekikyu1+$syokunoukyu);
			echo '<td>'. number_format($itiritu1).'</td>';
			if($itiritu1==0){
				echo '<td>0</td>';
				$niju=0;
			}else{
				echo '<td>'. number_format(intval(($nenreikyu+$syokusekikyu1+$syokunoukyu)*0.23)).'</td>';
				$niju=intval(($nenreikyu+$syokusekikyu1+$syokunoukyu)*0.23);
			}
			echo '<td>'. number_format($utikiri1).'</td>';

			echo '<td><b>'. number_format($itiritu1+$utikiri1+$niju).'</b></td>';

			$nensyu=$nensyu+$itiritu1+$utikiri1+$niju;
			$gai_nensyu=$gai_nensyu+$itiritu1+$utikiri1+$niju;

			echo '<td>'. number_format($nenreikyu+$syokusekikyu1+$syokunoukyu+$itiritu1+$utikiri1+$niju).'</td>';

			if ($m == 9){//★$label
				$label=$label.',"'.$seireki.'年"';// "1月","2月","3月","4月","5月","6月","7月"
				$nenrei_gra=$nenrei_gra.','.$nenreikyu;//4,5,9,14,15,24,30
				$syokuseki_gra=$syokuseki_gra.','.$syokusekikyu1;
				$syokuno_gra=$syokuno_gra.','.$syokunoukyu;
				$gai_gra=$gai_gra.','.($itiritu1+$utikiri1+$niju);
			}

			if ($m == 11){
				echo '<td>'. number_format(($kijunn_nensyu)).'</td>';
				echo '<td>'. number_format(($gai_nensyu)).'</td>';
				echo '<td><b>'. number_format($nensyu).'</b></td>';
			}else{
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';
			}


			echo '</tr>';

		}
	}
	echo '</tbody>';
	echo '</table>';
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