<?php require_once('../Connections/Wandering.php'); ?>


<?php

//資料集分頁Function
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_rs_showpost,$totalRows_rs_showpost;
	$pagesArray = ""; $firstArray = ""; $lastArray = "";
	if($max_links<2)$max_links=2;
	if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
	{
		if ($pageNum_Recordset1 > ceil($max_links/2))
		{
			$fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
			$egp = $pageNum_Recordset1 + ceil($max_links/2);
			if ($egp >= $totalPages_Recordset1)
			{
				$egp = $totalPages_Recordset1+1;
				$fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
			}
		}
		else {
			$fgp = 0;
			$egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
		}
		if($totalPages_Recordset1 >= 1) {
			//檢查目前頁碼位置
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_rs_showpost") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_showpost=$precedente$_get_vars\" class='pagenate-prev fa fa-angle-left' rel='prev'></a>" :  "$prev_Recordset1";
			//頁碼
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_rs_showpost) + 1;
					$max_l = ($a*$maxRows_rs_showpost >= $totalRows_rs_showpost) ? $totalRows_rs_showpost : ($a*$maxRows_rs_showpost);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_rs_showpost=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a></li>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "<li><a href='#' class='current'>";
					$pagesArray .= "$textLink</a></li>"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_showpost=$successivo$_get_vars\" class='pagenate-next fa fa-angle-right' rel='next'></a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?>

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

$maxRows_rs_showpost = 15;
$pageNum_rs_showpost = 0;
if (isset($_GET['pageNum_rs_showpost'])) {
  $pageNum_rs_showpost = $_GET['pageNum_rs_showpost'];
}
$startRow_rs_showpost = $pageNum_rs_showpost * $maxRows_rs_showpost;


$query_rs_showpost = "SELECT * FROM post ORDER BY pStime DESC";
$query_limit_rs_showpost = sprintf("%s LIMIT %d, %d", $query_rs_showpost, $startRow_rs_showpost, $maxRows_rs_showpost);
$rs_showpost = mysqli_query($Wandering, $query_limit_rs_showpost) or die(mysqli_error());
$row_rs_showpost = mysqli_fetch_assoc($rs_showpost);

if (isset($_GET['totalRows_rs_showpost'])) {
  $totalRows_rs_showpost = $_GET['totalRows_rs_showpost'];
} else {
  $all_rs_showpost = mysqli_query($Wandering, $query_rs_showpost);
  $totalRows_rs_showpost = mysqli_num_rows($all_rs_showpost);
}
$totalPages_rs_showpost = ceil($totalRows_rs_showpost/$maxRows_rs_showpost)-1;
?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>顯示貼文列表</title>
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
				 <div class="header-widget"> <a href="add-post.php" class="button border with-icon">新增貼文<i class="sl sl-icon-plus"></i></a> </div>
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
      <ul data-submenu-title="網站內容"><li  class="active"><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>貼文管理</a> </li>
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
					<h2>貼文列表</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">後臺管理</a></li>
							<li><a href="#">貼文管理</a></li>
							<li>編輯貼文列表</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
			
			<!-- Listings -->
			<div class="col-lg-12 col-md-12">
				<div class="dashboard-list-box margin-top-0">
					
					<ul>
                    
                    <?php if($totalRows_rs_showpost != 0){ ?>
					  <?php do { ?>
					   	<li>
							<div class="list-box-listing">
								<div class="list-box-listing-img"><a href="#"><img src="../images/post/<?php echo $row_rs_showpost['pPicture']; ?>" alt=""></a></div>
								<div class="list-box-listing-content">
									<div class="inner">
										<h3><a href="#"><?php echo $row_rs_showpost['pTitle']; ?></a></h3>
										<span>上次編輯時間-> <?php echo date('Y-m-d 時間H:i',strtotime($row_rs_showpost['pEtime'])); ?></span>
										<br><span>建立時間-> <?php echo date('Y-m-d 時間H:i',strtotime($row_rs_showpost['pStime'])); ?>(
										<?php if($row_rs_showpost['pType'] == 0){ echo "消息";}
elseif($row_rs_showpost['pType'] == 1){ echo "募集";}
elseif($row_rs_showpost['pType'] == 2){ echo "活動";}
elseif($row_rs_showpost['pType'] == 3){ echo "系統";}
elseif($row_rs_showpost['pType'] == 4){ echo "綜合";} ?>)</span>
																			
									</div>
								</div>
							</div>
							<div class="buttons-to-right">
                         
								<a href="edit-post.php?pId=<?php echo $row_rs_showpost['pId']; ?>" class="button gray"><i class="sl sl-icon-note"></i> 編輯</a>
								<a href="del-post.php?pId=<?php echo $row_rs_showpost['pId']; ?>" class="button gray"  onclick="javascript:return confirm('確定刪除貼文「<?php echo $row_rs_showpost['pTitle']; ?>」？')" ><i class="sl sl-icon-close"></i> 刪除</a>
							</div>
						</li>
                        <?php } while ($row_rs_showpost = mysqli_fetch_assoc($rs_showpost)); ?>
                       <?php }else{ ?>
                        
                        <h1><center> 尚未新增任何貼文 </center></h1>
                        
                        <?php } ?>
                      </ul> 
                       
    
			  </div>
              
              
              <div class="pagenate theme-pagenate">
        
             <?php 
//分頁的變數設定以及分頁函式呼叫
$prev_rs_showpost = "";
$next_rs_showpost = "";
$separator = " ";
$max_links = 5;
$pages_navigation_rs_showpost = buildNavigation($pageNum_rs_showpost,$totalPages_rs_showpost,$prev_rs_showpost,$next_rs_showpost,$separator,$max_links,true); 

print $pages_navigation_rs_showpost[0]; ?>
 <?php print $pages_navigation_rs_showpost[2]; ?>
 <ul class="pagenate-body"> 
 <?php print $pages_navigation_rs_showpost[1]; ?>
 </ul>
             
</div>


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
</html><?php
mysqli_free_result($rs_showpost);

mysqli_free_result($rs_showpoint);

mysqli_free_result($rs_showpoint2);
?>
