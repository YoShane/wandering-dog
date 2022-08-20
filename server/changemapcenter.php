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
  $updateSQL = sprintf("UPDATE mapcenter SET mLat=%s, mLng=%s, mZoom=%s WHERE mId=%s",
                       GetSQLValueString($Wandering,$_POST['mLat'], "text"),
                       GetSQLValueString($Wandering,$_POST['mLng'], "text"),
					   GetSQLValueString($Wandering,$_POST['mZoom'], "text"),
                       GetSQLValueString($Wandering,1, "int"));

  
  $Result1 = mysqli_query($Wandering, $updateSQL) or die(mysqli_error());

 header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已成功設定新座標" . $_POST['mLat'] . "," . $_POST['mLng'] . "及縮放" . $_POST['mZoom'] . "成功')</script>"; 
echo "<script>document.location.href='./changemapcenter.php';</script>";
}


$query_rs_dogpoint = "SELECT * FROM dogpoint WHERE dType = 1";
$rs_dogpoint = mysqli_query($Wandering, $query_rs_dogpoint) or die(mysqli_error());
$row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint);
$totalRows_rs_dogpoint = mysqli_num_rows($rs_dogpoint);


$query_rs_dogpoint2 = "SELECT * FROM dogpoint WHERE dType = 1000";
$rs_dogpoint2 = mysqli_query($Wandering, $query_rs_dogpoint2) or die(mysqli_error());
$row_rs_dogpoint2 = mysqli_fetch_assoc($rs_dogpoint2);
$totalRows_rs_dogpoint2 = mysqli_num_rows($rs_dogpoint2);


$query_rs_myset = "SELECT * FROM mapcenter WHERE mId = 1";
$rs_myset = mysqli_query($Wandering, $query_rs_myset) or die(mysqli_error());
$row_rs_myset = mysqli_fetch_assoc($rs_myset);
$totalRows_rs_myset = mysqli_num_rows($rs_myset);
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
            <li  class="active"><a href="changemapcenter.php">地圖中心點調整</a></li>
            <li><a href="changeneed.php">編輯基本需求表</a></li>
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
					<h2>調整地圖中心點</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">後臺管理</a></li>
							<li><a href="#">狗場設定</a></li>
							<li>調整地圖中心</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

<form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST">
 <!-- Row -->
              <div class="row with-forms">
                <!-- Types -->
                <div class="col-md-4">
                   <h5>緯度</h5>
                  <input name="mLat" type="text" required="required" value="<?php echo $row_rs_myset['mLat']; ?>">
                </div>
                <!-- Type -->
                <div class="col-md-4">
                  <h5>經度</h5>
                  <input name="mLng" type="text" required="required" value="<?php echo $row_rs_myset['mLng']; ?>">
                </div>
                 <!-- Type -->
                <div class="col-md-4">
                  <h5>縮放<i class="tip" data-tip-content="數字越小範圍越廣"></i></h5>
                  <input name="mZoom" type="text" required="required" value="<?php echo $row_rs_myset['mZoom']; ?>">
                </div>
                
              </div>
               <center><button class="button preview">完成設定<i class='fa fa-arrow-circle-right'></i></button></center>
               <input type="hidden" name="MM_update" value="form1">
                </form>
              <!-- Row / End -->
<!-- Map
================================================== -->

<script> 
		  function locationData(locationURL,locationImg,locationTitle, locationAddress, locationManagement, locationHavedog) {
          return(''+
            '<a href="'+ locationURL +'" class="listing-img-container" target="_blank">'+
               '<div class="infoBox-close"><i class="fa fa-times"></i></div>'+
               '<img src="'+locationImg+'" alt="">'+

               '<div class="listing-item-content">'+
                  '<h3>'+locationTitle+'</h3>'+
                  '<span>收留約 '+locationHavedog+' 隻狗狗</span>'+
               '</div>'+

            '</a>'+

            '<div class="listing-content">'+
               '<div class="listing-title">'+
                  '<div class="Management">狗場負責人：'+locationManagement+'</div></div>'+
               '</div>'+
            '</div>')
      }

      var locations = [   // 位置載入
	  <?php $count = 0; ?>
	  <?php do { $count++; ?>
        [ locationData('../Introduction.php?Id=<?php echo $row_rs_dogpoint['dId']; ?>','../images/dogpoint/<?php echo $row_rs_dogpoint['dPicture']; ?>',"<?php echo $row_rs_dogpoint['dName']; ?>",'<?php echo $row_rs_dogpoint['dMap']; ?>', '<?php echo $row_rs_dogpoint['dManagement']; ?>', '<?php echo $row_rs_dogpoint['dHavedog']; ?>'), <?php echo $row_rs_dogpoint['dMappoint']; ?>, Number(<?php echo $count ;?>), '<i class="im im-icon-Dog"></i>'],
      	  <?php } while ($row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint)); ?>
		   <?php do { $count++; ?>
        [ locationData('../Introduction.php?Id=<?php echo $row_rs_dogpoint2['dId']; ?>','../images/dogpoint/<?php echo $row_rs_dogpoint2['dPicture']; ?>',"<?php echo $row_rs_dogpoint2['dName']; ?>",'<?php echo $row_rs_dogpoint2['dMap']; ?>', '<?php echo $row_rs_dogpoint2['dManagement']; ?>', '<?php echo $row_rs_dogpoint2['dHavedog']; ?>'), <?php echo $row_rs_dogpoint2['dMappoint']; ?>, Number(<?php echo $count ;?>), '<i class="im im-icon-Box-Open"></i>'],
      	  <?php } while ($row_rs_dogpoint2 = mysqli_fetch_assoc($rs_dogpoint2)); ?>
	  ]; 
</script>


	
  <div id="map-container" class="fullwidth-home-map margin-top-50">
    
    <div id="map" data-map-zoom="<?php echo $row_rs_myset['mZoom']; ?>">
      <!-- map goes here -->
      </div>
    
    <!-- Scroll Enabling Button -->
	<a href="#" id="scrollEnabling" title="Enable or disable scrolling on map">開啟地圖滾動</a>
</div>
 
 
 
		
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


<!-- Maps -->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA2wXCdtQOx7tzeBDSea5K7zOQiccpzH8Q"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=zh-TW"></script>
<script type="text/javascript" src="../scripts/infobox.min.js"></script>
<script type="text/javascript" src="../scripts/markerclusterer.js"></script>
<script type="text/javascript">
mapcenter1=Number("<?php echo $row_rs_myset['mLat']; ?>");
mapcenter2=Number("<?php echo $row_rs_myset['mLng']; ?>");
</script>
<script type="text/javascript" src="../scripts/maps.js"></script>



</body>
</html><?php
mysqli_free_result($rs_dogpoint);

mysqli_free_result($rs_dogpoint2);

mysqli_free_result($rs_myset);
?>
