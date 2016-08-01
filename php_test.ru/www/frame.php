<!DOCTYPE HTML>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Дерево каталогов на PHP и jQuery</title>

<!-- CSS3 --> 
<style>
*, html { font-family: Verdana, Arial, Helvetica, sans-serif; }
body, form {
	margin: 0;
	padding: 0;
}
body { 
  background-color: #616161; 
  color: #fff; margin: 0; 
}
img { 
  border: none; 
}
p {
	font-size: 1em;
	margin: 0 0 1em 0;
}
	
/* Стили для дерево каталогов */
ol.tree {
	padding: 0 0 0 30px;
	width: 300px;
}
li { 
  position: relative; 
	margin-left: -15px;
	list-style: none;
}
li.file {
	margin-left: -1px !important;
}
li.file a {
	background: url(img/document.png) 0 2px no-repeat;
	color: #fff;
	padding-left: 21px;
	text-decoration: none;
	display: block;
}
li.file a:hover {
  color: #aff;
  text-decoration: underline;
}
li.toggle {
  background: url(img/folder-horizontal.png) 15px 1px no-repeat;
  cursor: pointer;
  padding-left: 37px;
}
li.file [href*='.pdf']	{ 
  background: url(img/document-pdf.png) 0 0 no-repeat; 
}
li.file [href*='.htm'], 
li.file [href*='.html']	{ 
  background: url(img/document-html.png) 0 3px no-repeat; 
}
li.file [href*='.txt'] { 
  background: url(img/document-txt.png) 0 3px no-repeat; 
}
li.file [href*='.zip'],
li.file [href*='.gz'] { 
  background: url(img/document-zip.png) 0 3px no-repeat; 
}
li.file [href$='.jpg'],
li.file [href$='.gif'],
li.file [href$='.ico']	{ 
  background: url(img/document-jpg.png) 0 2px no-repeat; 
}
li.file [href$='.png']	{ 
  background: url(img/document-png.png) 0 2px no-repeat; 
}
li.file [href$='.css']	{ 
  background: url(img/document-css.png) 0 2px no-repeat; 
}
li.file [href$='.js']	{ 
  background: url(img/document-js.png) 0 2px no-repeat; 
}
li.file [href$='.php']	{ 
  background: url(img/document-php.png) 0 4px no-repeat; 
}
li input {
  position: absolute;
  left: 0;
  margin-left: 0;
  opacity: 0;
  z-index: 2;
  cursor: pointer;
  height: 1em;
  width: 1em;
  top: 0;
}
li input + ol {
	background: url(img/toggle-small-expand.png) 5px -3px no-repeat;
	margin: -0.938em 0 0 -44px; /* 15px */
	height: 1em;
}
li input + ol > li { 
  display: none; 
  margin-left: -14px !important; 
  padding-left: 1px; 
}
li input:checked + ol {
  background: url(img/toggle-small.png) 5px 2px no-repeat;
  margin: -1.25em 0 0 -44px; /* 20px */
  padding: 1.563em 0 0 80px;
	height: auto;
}
li input:checked + ol > li { display: block; margin: 0 0 0.125em;  /* 2px */}
li input:checked + ol > li:last-child { margin: 0 0 0.063em; /* 1px */ } 

.brb
{width: 100px;}
</style> 
</head> 
<body> 
 
<?php
	echo '<form width=100px;>';
	$path = "z:/";

	function createDir($path = '.')
	{
		//echo '<form class=brb>';		
		if ($handle = opendir($path)) 
		{
			echo '<ol class="tree">';
		
			while (false !== ($file = readdir($handle))) 
			{
				if (is_dir($path.$file) && $file != '.' && $file !='..')
					printSubDir($file, $path, $queue);
				else if ($file != '.' && $file !='..')
					$queue[] = $file;
			}			
			//printQueue($queue, $path);
			echo "</ol>";
		}
		//echo '</form>';
	}
	
	function printQueue($queue, $path)
	{
		foreach ($queue as $file) 
		{
			printFile($file, $path);
		} 
	}
	
	function printFile($file, $path)
	{
		echo "<li class=\"file\"><a href=\"".$path.$file."\">$file</a></li>";
	}
	
	function printSubDir($dir, $path)
	{
		echo "<li class=\"toggle\">$dir<input type=\"checkbox\">";
		createDir($path.$dir."/");
		echo "</li>";
	}
	
	createDir($path);
	echo '</form>';
?>

</body> 
</html> 