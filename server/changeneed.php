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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	$nHave = 0;$count = 0;
	$oStart = $_POST['oStart'];
	$nStart = $_POST['nStart'];
	$oHave = $_POST['oHave'];
	
	  foreach($_POST['tName'] as $i => $val){
		  $nHave++;
	  }

	  for($i =$oStart ; $i<$oStart+$oHave ; $i++ ){
		     
		  $colname_finddogneed = $i;


$query_finddogneed = sprintf("SELECT * FROM dogneed WHERE nLtid = %s", GetSQLValueString($Wandering,$colname_finddogneed, "int"));
$finddogneed = mysqli_query($Wandering, $query_finddogneed) or die(mysqli_error());
$row_finddogneed = mysqli_fetch_assoc($finddogneed);
$totalRows_finddogneed = mysqli_num_rows($finddogneed);


            if(($totalRows_finddogneed != 0) AND ($count < $nHave)){
               do{
	
	$updateSQL = sprintf("UPDATE dogneed SET nLtid=%s WHERE nId=%s",
                       GetSQLValueString($Wandering,$nStart+$count, "text"),
                       GetSQLValueString($Wandering,$row_finddogneed['nId'], "int"));

  
  $Result1 = mysqli_query($Wandering, $updateSQL) or die(mysqli_error());
  
                } while ($row_finddogneed = mysqli_fetch_assoc($finddogneed)); 
			}elseif(($totalRows_finddogneed != 0) AND ($count >= $nHave)){
				
				  $deleteSQL = sprintf("DELETE FROM dogneed WHERE nId=%s",
                       GetSQLValueString($Wandering,$row_finddogneed['nId'], "int"));

  
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());
				
			}

$count++;

mysqli_free_result($finddogneed);

		  }
	
    $deleteSQL = sprintf("DELETE FROM thingstable WHERE tId>1");
  
  $Result1 = mysqli_query($Wandering, $deleteSQL) or die(mysqli_error());


 foreach($_POST['tName'] as $i => $val){
		
	 $insertSQL = sprintf("INSERT INTO thingstable (tName) VALUES (%s)",
                       GetSQLValueString($Wandering,$_POST['tName'][$i], "text"));

  
  $Result1 = mysqli_query($Wandering, $insertSQL) or die(mysqli_error());
  }
  

  header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已成功編輯基本需求表')</script>"; 
echo "<script>document.location.href='./changeneed.php';</script>";
  
}


 


$query_rs_basic = "SELECT * FROM thingstable WHERE tId > 1 ORDER BY tId ASC";
$rs_basic = mysqli_query($Wandering, $query_rs_basic) or die(mysqli_error());
$row_rs_basic = mysqli_fetch_assoc($rs_basic);
$totalRows_rs_basic = mysqli_num_rows($rs_basic);




?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>踏浪</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/colors/main.css" id="colors">

</head>

<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container" class="fixed fullwidth dashboard">

	<!-- Header -->
	<div id="header" class="not-sticky">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="../index.php" class="dashboard-logo"><img src="../images/logo.png" alt=""></a>
				</div>

				<!-- Mobile Navigation -->
				<div class="menu-responsive">
					<i class="fa fa-reorder menu-trigger"></i>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<ul id="responsive">

						<li><a href="../index.php">首頁</a></li>

						<li><a href="../pages-blog.php">訊息發布</a></li>


						<li><a href="../dogpoint-grid-full-width.php">狗場列表</a></li>

						<li><a href="../gallery.php">相簿</a></li>
                        
                        <li><a href="../about.php">網站說明</a></li>
                        

						<li><a href="pages-icons.php" target="_blank">Icons</a></li>
						
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Dashboard -->
<div id="dashboard">

	 <!-- Navigation
	================================================== -->
    <!-- Responsive Navigation Trigger -->
     <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> 後台管理清單</a>
    <div class="dashboard-nav">
      <ul data-submenu-title="網站內容">
        <li><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>貼文管理</a> </li>
        <li><a   href="show-dogpoint.php"> <i class="sl sl-icon-location"></i> 狗場管理</a></li>
         
                <li><a> <i class="sl sl-icon-social-dropbox"></i> 物資集貨</a>
          <ul>
            <li><a href="edit-collect.php">物資集貨站</a></li>
            <li><a href="material.php">愛心物資登錄</a></li>
            <li><a href="show-send.php">運送流程編輯</a></li>
          </ul>
        </li>
        
        <li><a href="show-gallery.php"> <i class="sl sl-icon-picture"></i> 相簿管理</a></li>
        
        <li><a> <i class="sl sl-icon-ghost"></i> 網站說明</a>
          <ul>
            <li><a href="edit-aboutus.php">關於我們</a></li>
            <li><a href="edit-operating.php">網站操作</a></li>
            <li><a href="show-ourteam.php">我們的團隊</a></li>
            <li><a href="show-webfaq.php">網站問與答</a></li>
          </ul>
        </li>
             
         <li  class="active"><a> <i class="sl sl-icon-paper-plane"></i> 網站內容設定</a>
          <ul>
            <li><a href="show-slider.php">首頁滑動版面</a></li>
            <li><a href="edit-footer.php">頁尾內容編輯</a></li>
            <li><a href="changemapcenter.php">地圖中心點調整</a></li>
            <li  class="active"><a href="changeneed.php">編輯基本需求表</a></li>
          </ul>
        </li>
      </ul>

      <ul data-submenu-title="帳戶">
      <li><a href="changepw.php"><i class="sl sl-icon-lock"></i>變更密碼</a></li>
        <li><a href="<?php echo $logoutAction ?>"><i class="sl sl-icon-power"></i>登出</a></li>
      </ul>
    </div>
    <!-- Navigation / End -->

	<!-- Content
	================================================== -->
	<div class="dashboard-content">

		<!-- Titlebar -->
		<div id="titlebar">
			<div class="row">
				<div class="col-md-12">
					<h2>設定基本物資</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">後臺管理</a></li>
							<li><a href="#">狗場設定</a></li>
							<li>設定基本物資</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
        
        
        <div class="row">
                 <div class="col-md-12">
              
              <h3><i class="sl sl-icon-question"></i>重要須知</h3>
        
                下方清單順序比照上方，若下方清單數量少於上方，則會刪除多於順序的需求資料。舉例來說:情況一、上面有4筆需求，下方更新後變3比需求，則原始需求前3筆會更新成新的，第4筆會刪除；情況二、上面有4筆需求，下方更新共5筆需求，原始4筆需求名稱會更新成下方前4筆，第五筆會額外新增；情況三、都一樣需求，就純粹改名字而已。<br><br>
                
            
<?php $oHave = 0;$oStart = $row_rs_basic['tId'];  ?>
<?php do { $oHave++; $bkneed[$oHave]=$row_rs_basic['tName'];?> 
[ID=<?php echo $row_rs_basic['tId']; ?>] 第<?php echo $oHave; ?>順序→<?php echo $row_rs_basic['tName']; ?><br>
<?php } while ($row_rs_basic = mysqli_fetch_assoc($rs_basic)); ?>

<?php $nStart = $oStart + $oHave; ?>

     </div>
</div>


<form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST">

             <input name="oHave" type="hidden" id="oHave" value="<?php echo $oHave; ?>">
             <input name="oStart" type="hidden" id="oStart" value="<?php echo $oStart; ?>">
             <input name="nStart" type="hidden" id="nStart" value="<?php echo $nStart; ?>">
        <input name="bkneed" type="hidden" id="nStart" value="<?php echo $bkneed; ?>">
             
               <div class="row margin-top-25">
                 <div class="col-md-12">
                   <table id="pricing-list-container">
                     
                     <?php foreach ( $bkneed as $i => $name ){  ?>
                     <tr class="pricing-list-item pattern">
                       <td>
                           <div class="fm-input pricing-name">
                           <input name="tName[]" type="text" required placeholder="項目" value="<?php echo $name; ?>" />
                         </div>
                         
                       <div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div></td>
                     </tr>
                     
                     <?php } ?>
                     
                   </table>
                   <a href="#" class="button add-pricing-list-item">點我新增更多基本物資</a> </div>
                 </div>
               <input type="hidden" name="MM_update" value="form1">

        <center><button class="button preview">完成編輯<i class='fa fa-arrow-circle-right'></i></button></center>
                   <input type="hidden" name="MM_insert" value="form1">
                   
                </form>
            

		
	  <!-- Copyrights -->
			<div class="col-md-12">
				<div class="copyrights">© 2017 Wandering. All Rights Reserved.</div>
			</div>
		</div>

	</div>
	<!-- Content / End -->


</div>
<!-- Dashboard / End -->


</div>
<!-- Wrapper / End -->



<!-- Scripts
================================================== -->
<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="../scripts/jpanelmenu.min.js"></script>
<script type="text/javascript" src="../scripts/chosen.min.js"></script>
<script type="text/javascript" src="../scripts/slick.min.js"></script>
<script type="text/javascript" src="../scripts/rangeslider.min.js"></script>
<script type="text/javascript" src="../scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="../scripts/waypoints.min.js"></script>
<script type="text/javascript" src="../scripts/counterup.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="../scripts/tooltips.min.js"></script>
<script type="text/javascript" src="../scripts/custom.js"></script>



</body>
</html><?php
mysqli_free_result($rs_basic);

?>
