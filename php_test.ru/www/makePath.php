<?php

if(isset($_POST['absolute'])){
	//header("Content-type: text/txt; charset=UTF-8");
	$makePath.=$_POST['absolute'];
	$fp = readfile($makePath);
	echo $fp;
}
?>
