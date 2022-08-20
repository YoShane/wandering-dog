
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

$colname_rs_showphoto = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_showphoto = $_GET['Id'];
}

$mode = "-1";
if (isset($_GET['Mode'])) { //讀入模式0=狗場(後續新增圖片),1=手動新增
  $mode = $_GET['Mode'];
}


$query_rs_showphoto = sprintf("SELECT * FROM galleryphoto WHERE gLid = %s AND gMode = %s", GetSQLValueString($Wandering,$colname_rs_showphoto, "int"), GetSQLValueString($Wandering,$mode, "int"));
$rs_showphoto = mysqli_query($Wandering, $query_rs_showphoto) or die(mysqli_error());
$row_rs_showphoto = mysqli_fetch_assoc($rs_showphoto);
$totalRows_rs_showphoto = mysqli_num_rows($rs_showphoto);




if($_GET['Mode'] == 0){ //狗場模式讀入原始特殊照片
$colname_rs_pointphoto = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_pointphoto = $_GET['Id'];
}

$query_rs_pointphoto = sprintf("SELECT * FROM pointalbum WHERE pLdid = %s", GetSQLValueString($Wandering,$colname_rs_pointphoto, "int"));
$rs_pointphoto = mysqli_query($Wandering, $query_rs_pointphoto) or die(mysqli_error());
$row_rs_pointphoto = mysqli_fetch_assoc($rs_pointphoto);
$totalRows_rs_pointphoto = mysqli_num_rows($rs_pointphoto);


 //讀入狗場名稱
$query_rs_pointname = sprintf("SELECT dName FROM dogpoint WHERE dId = %s", GetSQLValueString($Wandering,$colname_rs_pointphoto, "int"));
$rs_pointname = mysqli_query($Wandering, $query_rs_pointname) or die(mysqli_error());
$row_rs_pointname = mysqli_fetch_assoc($rs_pointname);
$totalRows_rs_pointname = mysqli_num_rows($rs_pointname);

}else{
	
	

$query_rs_showphotolist = sprintf("SELECT lName FROM listgallery WHERE lId = %s", GetSQLValueString($Wandering,$colname_rs_showphoto, "int"));
$rs_showphotolist = mysqli_query($Wandering, $query_rs_showphotolist) or die(mysqli_error());
$row_rs_showphotolist = mysqli_fetch_assoc($rs_showphotolist);
$totalRows_rs_showphotolist = mysqli_num_rows($rs_showphotolist);

} 

?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>相簿圖片</title>
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

			<!-- Right Side Content / End -->
			<div class="right-side">
				<!-- Header Widget -->
				<div class="header-widget">
				
					<a href="add-photo.php?Id=<?php echo $_GET['Id']; ?>&Mode=<?php echo $_GET['Mode']; ?>" class="button border with-icon">新增照片<i class="sl sl-icon-plus"></i></a>
				</div>
				<!-- Header Widget / End -->
			</div>
			<!-- Right Side Content / End -->

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
        <li><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>貼文管理</a> </li><li><a  href="show-dogpoint.php"> <i class="sl sl-icon-location"></i> 狗場管理</a></li>
         
                <li><a> <i class="sl sl-icon-social-dropbox"></i> 物資集貨</a>
          <ul>
            <li><a href="edit-collect.php">物資集貨站</a></li>
            <li><a href="material.php">愛心物資登錄</a></li>
            <li><a href="show-send.php">運送流程編輯</a></li>
          </ul>
        </li>
        
        <li  class="active"><a href="show-gallery.php"> <i class="sl sl-icon-picture"></i> 相簿管理</a></li>
        
        <li><a> <i class="sl sl-icon-ghost"></i> 網站說明</a>
          <ul>
            <li><a href="edit-aboutus.php">關於我們</a></li>
            <li><a href="edit-operating.php">網站操作</a></li>
            <li><a href="show-ourteam.php">我們的團隊</a></li>
            <li><a href="show-webfaq.php">網站問與答</a></li>
          </ul>
        </li>
             
         <li><a> <i class="sl sl-icon-paper-plane"></i> 網站內容設定</a>
          <ul>
            <li><a href="show-slider.php">首頁滑動版面</a></li>
            <li><a href="edit-footer.php">頁尾內容編輯</a></li>
            <li><a href="changemapcenter.php">地圖中心點調整</a></li>
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
				  <h2><?php if($_GET['Mode'] == 0){ echo $row_rs_pointname['dName'];}else{ echo $row_rs_showphotolist['lName'];} ?>相簿</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">後臺管理</a></li>
							<li><a href="#">相簿管理</a></li>
							<li>顯示相簿圖片</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
        
        <?php if($_GET['Mode'] == 1){ ?>
        
        <?php if($row_rs_showphoto != 0){ ?>
          <?php do { ?>
          <div class="col-sm-6 col-md-6 col-lg-4 other" style="margin-bottom:50px;"><table border="0" cellspacing="0" cellpadding="0"  align="center">
              <tbody>
                <tr>
                  <td><img src="../images/gallery/thumb-<?php echo $row_rs_showphoto['gName']; ?>" alt=""/></td>
                </tr>
                <tr align="center">
                  <td><?php echo $row_rs_showphoto['gNote']; ?><br>
                  <a href="del-photo.php?gId=<?php echo $row_rs_showphoto['gId']; ?>&Id=<?php echo $_GET['Id'];?>&Mode=<?php echo $_GET['Mode'];?>" class="button gray"  onclick="javascript:return confirm('確定刪除此圖片<?php echo $row_rs_showphoto['gNote']; ?>？')" >刪除</a></td>
                </tr>
                </tbody>
              </table></div>
              
            <?php } while ($row_rs_showphoto = mysqli_fetch_assoc($rs_showphoto)); ?>
            <?php }else{ ?>
            
            <center><h1>尚未新增任何圖片(案右上角新增)</h1></center>
            <?php } ?>
            
            
            <?php } else { //如果是狗場 ?>
            
               <?php if(($totalRows_rs_pointphoto != 0) OR ($totalRows_rs_showphoto != 0)){ ?>
               
               <?php if($totalRows_rs_pointphoto != 0){ ?>
               <?php do { ?>
          <div class="col-sm-6 col-md-6 col-lg-4 other" style="margin-bottom:50px;"><table border="0" cellspacing="0" cellpadding="0"  align="center">
              <tbody>
                <tr>
                  <td><img src="../images/uploads/thumb-<?php echo $row_rs_pointphoto['pName']; ?>" alt=""/></td>
                </tr>
                <tr align="center">
                  <td><?php echo $row_rs_pointphoto['pNote']; ?><br>
                </td>
                </tr>
                </tbody>
              </table></div>
              
            <?php } while ($row_rs_pointphoto = mysqli_fetch_assoc($rs_pointphoto)); ?>
            <?php } ?>
            
            
            <?php if($totalRows_rs_showphoto != 0){ ?>
               <?php do { ?>
          <div class="col-sm-6 col-md-6 col-lg-4 other" style="margin-bottom:50px;"><table border="0" cellspacing="0" cellpadding="0"  align="center">
              <tbody>
                <tr>
                  <td><img src="../images/gallery/thumb-<?php echo $row_rs_showphoto['gName']; ?>" alt=""/></td>
                </tr>
                 <tr align="center">
                  <td><?php echo $row_rs_showphoto['gNote']; ?><br>
                  <a href="del-photo.php?gId=<?php echo $row_rs_showphoto['gId']; ?>&Id=<?php echo $_GET['Id'];?>&Mode=<?php echo $_GET['Mode'];?>" class="button gray"  onclick="javascript:return confirm('確定刪除此圖片<?php echo $row_rs_showphoto['gNote']; ?>？')" >刪除</a></td>
                </tr>
                </tbody>
              </table></div>
              
            <?php } while ($row_rs_showphoto = mysqli_fetch_assoc($rs_showphoto)); ?>
            <?php } ?>
            
            
               
               <?php } else { ?>
               
                <center><h1>尚未新增任何圖片(案右上角新增)</h1></center>
               <?php } ?> 
            
            
            <?php } ?>
            
        
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


</body>
</html>
<?php
mysqli_free_result($rs_showphoto);
mysqli_free_result($rs_pointphoto);
mysqli_free_result($rs_showphotolist);
mysqli_free_result($rs_pointname);
?>
