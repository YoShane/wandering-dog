<?php require_once('../Connections/Wandering.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "uLevel";
  $MM_redirectLoginSuccess = "add-dogpoint.php";
  $MM_redirectLoginFailed = "../index.php";
  $MM_redirecttoReferrer = true;
  
  	
  $LoginRS__query=sprintf("SELECT uAccount, uPassword, uLevel FROM `user` WHERE uAccount=%s AND uPassword=%s",
  GetSQLValueString($Wandering,$loginUsername, "text"), GetSQLValueString($Wandering,$password, "text")); 
   
  $LoginRS = mysqli_query($Wandering, $LoginRS__query) or die(mysqli_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysqli_result($LoginRS,0,'uLevel');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<html>

<head>
  <title>登入帳號</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
         <link rel="stylesheet" type="text/css" href="../../css/style.css" />
   <script type="text/javascript" src="../../js/modernizr-1.5.min.js"></script>
  
 <script>
        $(function () {
            $("#password").keypress(function (e) {
                $("#sCapsLockWarning").toggle(
                    //沒按下Shift鍵，卻輸入大寫字母
                    (e.which >= 65 && e.which <= 90 && !e.shiftKey) ||
                    //按下Shift鍵時，卻輸入小寫字母
                    (e.which >= 97 && e.which <= 122 && e.shiftKey)
                    );
            }).focusout(function () { $("#sCapsLockWarning").hide(); });
        });
    </script>
    <style>#sCapsLockWarning { font-size: 15pt; color: Red; display: none; }</style>
    
 <style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
  </style></head>

<body>
<!-- 透過網站編輯軟體Dreamweaver可針對CSS元素點擊右鍵->程式碼導覽器->點擊裡面對應到的ID.CLASS等設定即可切換至該CSS語法設定位置 --><!-- top雲朵版面 -->
  <div id="container">
    <div id="main"><div id="site_content">
      <blockquote><!-- 網站內容縮排設定 -->
        <div>
          <p>&nbsp;</p>
          <div align="center"></div>
          
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:36px;font-weight:bold;">
              <form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
                <tr>
                  <td height="35" colspan="2" align="left" class="samll_word" style="text-align: center">歡迎來到踏浪後台系統，請先進行登錄，謝謝</td>
                </tr>
                <tr>
                  <td align="right" class="samll_word">&nbsp;</td>
                  <td height="35" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right" class="samll_word">帳號</td>
                  <td width="317" height="35" align="left"> <input name="username" type="text" required id="username" style="font-size:30px;font-family:Microsoft JhengHei;margin-left: 20px;margin-top: 5px;margin-bottom:20px;">
                    <strong>
                    <input name="uIp" type="hidden" id="uIp" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                  </strong></td>
                </tr>
                <tr>
                  <td align="right" class="samll_word">密碼</td>
                  <td height="35" align="left"><input name="password" type="password" required id="password" style="font-size:30px;font-family:Microsoft JhengHei;margin-left: 20px;margin-top: 5px;margin-bottom:20px;" pattern="(?=.*\d)(?=.*[a-zA-Z]).{6,}" title="請輸入英數混和，6字元以上的密碼"><span style="color:#FF0004;" id="sCapsLockWarning">※大寫鎖定已啟用</span></td>
                </tr>
                <tr>
                  <td height="17" colspan="2" align="center" class="samll_word"></td>
                </tr>
                
                <tr>
                  <td  width="83" align="right" class="samll_word"></td>
                  <td height="35"><p></br>
                   <input type="submit" name="button" id="button" value="" style="background-image:url(/images/login.png);width:202px;height:92px;border-radius:7px;" />
                 <!-- <a href="account/verify.php"><span style="font-weight: bold"> 註冊帳號 </span></a></p> --></td>
                </tr>
              </form>
            </table>
          
          <p align="center">&nbsp;</p>
          <p align="center" style="font-size:34px;color:#760FB1;font-weight:600;">&nbsp;</p>
        </div>
        <p>&nbsp;</p>
   </blockquote>
      </div>
    </div>
  </div> 
<!-- JavaScript函式載入 -->
</body>
</html>