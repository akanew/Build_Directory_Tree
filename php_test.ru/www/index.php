<!DOCTYPE HTML>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Полная файловая система</title>
<script type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>

<!-- CSS3 --> 
<style>
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
	
/* РЎС‚РёР»Рё РґР»СЏ РґРµСЂРµРІРѕ РєР°С‚Р°Р»РѕРіРѕРІ */
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
.pathForm {margin: 3px; margin-bottom: -8px;}
</style> 
<script language='text/javascript'>
	window.path = '11';
	var path="";
	function addPath(subPath) {
		path+=subPath;
		console.log(path);
	}
	</script>
</head> 
<body>

<div style="overflow: hidden;">
    <div style="width: 100%; height: 100%;">
	
        <div style="float: left; width: 48%; height: 100%; border: 2px solid black; margin: 3px;">
		<div id="reader" style="margin:3px auto; width: 90%; color: black; border: 2px solid white; background-color: white;"></div>
		</div>
		
        <div style="float: right; width: 49%; height: 100%; border: 2px solid black; margin: 3px;">
		<form class="pathForm" name="pathForm" action="" method="POST">
		<input type="Text" name="text">
		<input type="submit" name="go" value="Построить иерархию">
		</form>
		 
			<?php			
				$path = "z:/";
				$createPath = $path;
				if (isset ($_POST['go'])) { $path = htmlspecialchars($_POST['text']);}
				
				/*Запуск js из php (помещаем в input данные)*/
				$arr = array('test'=>$path,'key'=>'value'); 
				$js_obj = json_encode($arr); 
				print "<script language='javascript'>var obj=$js_obj; document.forms['pathForm'].elements['text'].value = obj.test;</script>";

				function createDir($path = '.')
				{
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
						printQueue($queue, $path);
						echo "</ol>";
					}
				}
				
				function printQueue($queue, $path)
				{
					for($i=0; $i<count($queue); $i++)
						printFile($queue[$i], $path);
				}
				
				function printFile($file, $path)
				{
					echo "<li class=\"file\"><a href=\"".$path.$file."\">$file</a></li>";
				}
				
				function printSubDir($dir, $path)
				{
					echo "<li class=\"toggle\">$dir<input name=$dir type=\"checkbox\" onchange=\"
					if( this.checked ) {
						var fullPath = document.getElementById('fullPath').value,
						listLI = this.nextSibling.childNodes,
						isFind = false;
						for( var i = 0; i < listLI.length; i++ ) {
							if( listLI[i].className == 'file' && listLI[i].firstChild.text == 'README.txt' ) {
								isFind = true;
								$.ajax({
									url: 'makePath.php',
									dataType:'text',
									type: 'POST',
									data: {absolute: listLI[i].firstChild.href.replace(/^file:\/\/\//,'')},
									success: function(response) {
										document.getElementById('reader').textContent = response;
									},
									error: function(err) {
										console.log(err);
									}
								});
							}
						}
						if( !isFind ) document.getElementById('reader').textContent = 'Нет файла readMe(((';
					}
					else {
						var listLI = this.parentNode.parentNode.childNodes,
							isFind = false;
						for( var i = 0; i < listLI.length; i++ ) {
							if( listLI[i].className == 'file' && listLI[i].firstChild.text == 'README.txt' ) {
								isFind = true;
								$.ajax({
									url: 'makePath.php',
									dataType:'text',
									type: 'POST',
									data: {absolute: listLI[i].firstChild.href.replace(/^file:\/\/\//,'')},
									success: function(response) {
										document.getElementById('reader').textContent = response;
									},
									error: function(err) {
										console.log(err);
									}
								});
							}
						}
						if( !isFind ) document.getElementById('reader').textContent = 'Нет файла readMe(((';
					}
					\">";
					createDir($path.$dir."/");
					echo "</li>";
				}
				
				createDir($path);
			?>
		</div>
    </div>
	<?php echo '<input type="hidden" id="fullPath" value="'.$path.'" />'?>
	<script>
		var listLI = document.getElementsByTagName('OL')[0].childNodes,
		isFind = false;
		console.log(listLI)
		for( var i = 0; i < listLI.length; i++ ) {
			if( listLI[i].className == 'file' && listLI[i].firstChild.text == 'README.txt' ) {
				isFind = true;
				$.ajax({
					url: 'makePath.php',
					dataType:'text',
					type: 'POST',
					data: {absolute: listLI[i].firstChild.href.replace(/^file:\/\/\//,'')},
					success: function(response) {
						document.getElementById('reader').textContent = response;
					},
					error: function(err) {
						console.log(err);
					}
				});
			}
		}
		if( !isFind ) document.getElementById('reader').textContent = 'Нет файла readMe(((';
	</script>
	</div>
</body> 
</html> 