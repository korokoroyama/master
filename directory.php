<html>
<head>
<title>ディレクトリ一覧</title>
</head>
<body>
<?php
function loop($path,$x,$home,$webpath){
	$excludes = array(
		'.',
		'..',
		'css',
		'test',
		'test2',
		'js',
		'html',
		'.git',
//		'jquery.scrolltable.js',
	);
	$x++;
	$y=$x;
	$dirs = scandir($path);
	$dx=0;
	foreach ($dirs AS $dir) {
		if ((is_dir($path.'/'.$dir) == "1")) {
			$dirsx[$dx][dir]=$dir;
			$dirsx[$dx][number]=1;
		}else{
			$dirsx[$dx][dir]=$dir;
			$dirsx[$dx][number]=0;
		}
		$dx++;
	}
	foreach ((array) $dirsx as $key => $value) {
		$sort[$key] = $value['number'];
	}
	array_multisort($sort, SORT_ASC, $dirsx);
	echo "<h3>★第".$x."層:".$home."</h3>";
	echo '<ul>';
	foreach ($dirsx AS $dir1) {
		$dir=$dir1['dir'];
		$dir1="/^".$dir."/";
//		echo $dir1."<br>";
//		if(preg_grep($dir1,$excludes)){
		if(in_array($dir, $excludes)) {
			//echo "<br>death---".$dir;
			continue;
		}else{
		        if ((is_dir($path.'/'.$dir) == "1")) {
				$webpath1=$webpath."/".$dir;
				if($y>10){
					echo "階層が深いため停止します<br>";
				}else{
					loop($path.'/'.$dir,$y,$dir,$webpath1);
				}
				echo "<hr>";
			}else{
				echo '<li><a href="'.$webpath."/".$dir . '" target="_blank">ファイル：'.$dir.'</a></li>';
			}
		}
	}
	echo '</ul>';
}
echo "<hr>";
$path[0] = dirname(__FILE__);// .'/';
$x=0;
$folder[0]="home";
$webpath="./";
loop($path[0],$x,$folder[0],$webpath);
echo "<hr>";
?>
</body>
</html>