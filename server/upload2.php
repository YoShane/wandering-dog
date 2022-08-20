<?php
require_once('../Connections/Wandering.php');
require_once('simpleImage_class.php');
$ds = DIRECTORY_SEPARATOR;
$dir= '../images/gallery/';   
 
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];                    
      
    $targetPath = $dir . $ds;
	
	$file = $_FILES['file']['name'];
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	
	$fn = 'img-'.time().rand(0,10).'.jpg';
     
    $targetFile =  $targetPath. $fn; 
	
       if(move_uploaded_file($tempFile,$targetFile))
	{
	$image = new SimpleImage();
   $image->load($targetPath. $fn);
   $image->resizeToWidth(200);
   $image->save($targetPath.'thumb-'.$fn);	
	}
	
	
	if (false !== $pos = strripos($file, '.')) {

    $file = substr($file, 0, $pos);

}
 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($Wandering,$theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($Wandering, $theValue) : mysqli_escape_string($Wandering, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



  $insertSQL = sprintf("INSERT INTO galleryphoto (gMode, gLid, gName, gNote) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($Wandering,$_GET['Mode'], "int"),
					   GetSQLValueString($Wandering,$_GET['Id'], "int"),
                       GetSQLValueString($Wandering,$fn, "text"),
                       GetSQLValueString($Wandering,$file, "text"));

  
  $Result1 = mysqli_query($Wandering, $insertSQL) or die(mysqli_error());


}
echo json_encode($fn);
?>  