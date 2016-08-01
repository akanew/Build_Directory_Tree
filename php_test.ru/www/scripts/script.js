/*function getName(){
name = document.forms["pathForm"].elements["name"].value;
alert(name);

/*
$.ajax({
  type:'POST',
  url:'scripts/delete.php',
  dataType:'json',
  data:"param="+JSON.stringify(ob),
  success:function(html) {
   console.log(html);
   f('user_data.html','#info');//location.href = 'index.html';
   }
  });
*/
//}*/
$(document).ready(function() {
var id = 2;
var ob = {'id':id}
$.ajax({
  type:'POST',
  url:'index.php',
  dataType:'json',
  data:"param="+JSON.stringify(ob),
  success:function(html) {
   console.log(html);
   }
  });
  console.log("load");
});