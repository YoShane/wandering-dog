<?php require_once('../Connections/Wandering.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
	   header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已成功登出管理帳號，祝您有美好的一天:)')</script>"; 
echo "<script>document.location.href='" . $logoutGoTo . "';</script>";
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "user,admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php

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

$colname_rs_findneed = "-1";
if (isset($_GET['dId'])) {
  $colname_rs_findneed = $_GET['dId'];
}

$query_rs_findneed = sprintf("SELECT * FROM dogneed WHERE nLdid = %s", GetSQLValueString($Wandering,$colname_rs_findneed, "int"));
$rs_findneed = mysqli_query($Wandering, $query_rs_findneed) or die(mysqli_error());
$row_rs_findneed = mysqli_fetch_assoc($rs_findneed);
$totalRows_rs_findneed = mysqli_num_rows($rs_findneed);

$colname_rs_delp = "-1";
if (isset($_GET['dId'])) {
  $colname_rs_delp = $_GET['dId'];
}

$query_rs_delp = sprintf("SELECT dName, dPicture FROM dogpoint WHERE dId = %s", GetSQLValueString($Wandering,$colname_rs_delp, "int"));
$rs_delp = mysqli_query($Wandering, $query_rs_delp) or die(mysqli_error());
$row_rs_delp = mysqli_fetch_assoc($rs_delp);
$totalRows_rs_delp = mysqli_num_rows($rs_delp);

$colname_rs_delrep = "-1";
if (isset($_GET['dId'])) {
  $colname_rs_delrep = $_GET['dId'];
}

$query_rs_delrep = sprintf("SELECT rPicture FROM repdog WHERE rLdid = %s", GetSQLValueString($Wandering,$colname_rs_delrep, "int"));
$rs_delrep = mysqli_query($Wandering, $query_rs_delrep) or die(mysqli_error());
$row_rs_delrep = mysqli_fetch_assoc($rs_delrep);
$totalRows_rs_delrep = mysqli_num_rows($rs_delrep);

$colname_rs_delalbum = "-1";
if (isset($_GET['dId'])) {
  $colname_rs_delalbum = $_GET['dId'];
}

$query_rs_delalbum = sprintf("SELECT pName FROM pointalbum WHERE pLdid = %s", GetSQLValueString($Wandering,$colname_rs_delalbum, "int"));
$rs_delalbum = mysqli_query($Wandering, $query_rs_delalbum) or die(mysqli_error());
$row_rs_delalbum = mysqli_fetch_assoc($rs_delalbum);
$totalRows_rs_delalbum = mysqli_num_rows($rs_delalbum);



if ((isset($_GET['dId'])) && ($_GET['dId'] != "")) {
  $deleteSQL = sprintf("DELETE FROM dogpoint WHERE dId=%s",
                       GetSQLValueString($Wandering,$_GET['dId'], "int"));

 
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());


 $deleteSQL = sprintf("DELETE FROM dogneed WHERE nLdId=%s",//清除需求表
                       GetSQLValueString($Wandering,$_GET['dId'], "int"));

 
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());
  
  
  $deleteSQL = sprintf("DELETE FROM faq WHERE fLdId=%s",//清除問與答
                       GetSQLValueString($Wandering,$_GET['dId'], "int"));

 
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());
  
  
   $deleteSQL = sprintf("DELETE FROM pointalbum WHERE pLdId=%s",//清除代表照片
                       GetSQLValueString($Wandering,$_GET['dId'], "int"));

 
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());
  
  
     $deleteSQL = sprintf("DELETE FROM repdog WHERE rLdId=%s",//清除代表狗狗
                       GetSQLValueString($Wandering,$_GET['dId'], "int"));

 
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());



 @unlink("../images/dogpoint/" . $row_rs_delp['dPicture']);


 do {  //刪除代表狗照片
  @unlink("../images/dogpoint/" . $row_rs_delp['dPicture']);
  } while ($row_rs_delrep = mysqli_fetch_assoc($rs_delrep)); 
  
  
   do {  //刪除狗場代表照片
  @unlink("../images/dogpoint/" . $row_rs_delp['dPicture']);
  } while ($row_rs_delalbum = mysqli_fetch_assoc($rs_delalbum)); 
  

header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已成功刪除" . $row_rs_delp['dName'] . "成功')</script>"; 
echo "<script>document.location.href='./show-dogpoint.php';</script>";


}


mysqli_free_result($rs_findneed);

mysqli_free_result($rs_delp);

mysqli_free_result($rs_delrep);

mysqli_free_result($rs_delalbum);
?>
