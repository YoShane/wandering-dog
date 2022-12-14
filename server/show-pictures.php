<?php
#	BuildNav for Dreamweaver MX v0.2
#              10-02-2002
#	Alessandro Crugnola [TMM]
#	sephiroth: alessandro@sephiroth.it
#	https://www.sephiroth.it
#	
#	Function for navigation build ::
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_rs_pointp,$totalRows_rs_pointp;
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
			#	------------------------
			#	Searching for $_GET vars
			#	------------------------
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_rs_pointp") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_pointp=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_rs_pointp) + 1;
					$max_l = ($a*$maxRows_rs_pointp >= $totalRows_rs_pointp) ? $totalRows_rs_pointp : ($a*$maxRows_rs_pointp);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_pointp=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_pointp=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?>
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
echo "<script>javascript:alert('??????????????????????????????????????????????????????:)')</script>"; 
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

$maxRows_rs_pointp = 15;
$pageNum_rs_pointp = 0;
if (isset($_GET['pageNum_rs_pointp'])) {
  $pageNum_rs_pointp = $_GET['pageNum_rs_pointp'];
}
$startRow_rs_pointp = $pageNum_rs_pointp * $maxRows_rs_pointp;

$colname_rs_pointp = "-1";
if (isset($_GET['dId'])) {
  $colname_rs_pointp = $_GET['dId'];
}

$query_rs_pointp = sprintf("SELECT * FROM pointalbum WHERE pLdid = %s ORDER BY pId DESC", GetSQLValueString($Wandering,$colname_rs_pointp, "int"));
$query_limit_rs_pointp = sprintf("%s LIMIT %d, %d", $query_rs_pointp, $startRow_rs_pointp, $maxRows_rs_pointp);
$rs_pointp = mysqli_query($Wandering, $query_limit_rs_pointp) or die(mysqli_error());
$row_rs_pointp = mysqli_fetch_assoc($rs_pointp);

if (isset($_GET['totalRows_rs_pointp'])) {
  $totalRows_rs_pointp = $_GET['totalRows_rs_pointp'];
} else {
  $all_rs_pointp = mysqli_query($Wandering, $query_rs_pointp);
  $totalRows_rs_pointp = mysqli_num_rows($all_rs_pointp);
}
$totalPages_rs_pointp = ceil($totalRows_rs_pointp/$maxRows_rs_pointp)-1;
?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>??????????????????</title>
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

						<li><a href="../index.php">??????</a></li>

						<li><a href="../pages-blog.php">????????????</a></li>


						<li><a href="../dogpoint-grid-full-width.php">????????????</a></li>

						<li><a href="../gallery.php">??????</a></li>
                        
                        <li><a href="../about.php">????????????</a></li>
                        

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
				
					<a href="add-picture.php?dId=<?php echo $_GET['dId']; ?>" class="button border with-icon">????????????<i class="sl sl-icon-plus"></i></a>
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
    <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> ??????????????????</a>
    <div class="dashboard-nav">
      <ul data-submenu-title="????????????">
        <li><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>????????????</a> </li><li  class="active"><a  href="show-dogpoint.php"> <i class="sl sl-icon-location"></i> ????????????</a></li>
         
                <li><a> <i class="sl sl-icon-social-dropbox"></i> ????????????</a>
          <ul>
            <li><a href="edit-collect.php">???????????????</a></li>
            <li><a href="material.php">??????????????????</a></li>
            <li><a href="show-send.php">??????????????????</a></li>
          </ul>
        </li>
        
        <li><a href="show-gallery.php"> <i class="sl sl-icon-picture"></i> ????????????</a></li>
        
        <li><a> <i class="sl sl-icon-ghost"></i> ????????????</a>
          <ul>
            <li><a href="edit-aboutus.php">????????????</a></li>
            <li><a href="edit-operating.php">????????????</a></li>
            <li><a href="show-ourteam.php">???????????????</a></li>
            <li><a href="show-webfaq.php">???????????????</a></li>
          </ul>
        </li>
             
         <li><a> <i class="sl sl-icon-paper-plane"></i> ??????????????????</a>
          <ul>
            <li><a href="show-slider.php">??????????????????</a></li>
            <li><a href="edit-footer.php">??????????????????</a></li>
            <li><a href="changemapcenter.php">?????????????????????</a></li>
            <li><a href="changeneed.php">?????????????????????</a></li>
          </ul>
        </li>
      </ul>

      <ul data-submenu-title="??????">
      <li><a href="changepw.php"><i class="sl sl-icon-lock"></i>????????????</a></li>
        <li><a href="<?php echo $logoutAction ?>"><i class="sl sl-icon-power"></i>??????</a></li>
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
				  <h2>??????????????????</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">????????????</a></li>
							<li><a href="#">????????????</a></li>
							<li>??????????????????</li>
                            <li>??????????????????</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
        
        <?php if($row_rs_pointp != 0){ ?>
          <?php do { ?>
          <div class="col-sm-6 col-md-6 col-lg-4 other" style="margin-bottom:50px;"><table border="0" cellspacing="0" cellpadding="0"  align="center">
              <tbody>
                <tr>
                  <td><img src="../images/uploads/thumb-<?php echo $row_rs_pointp['pName']; ?>" alt=""/></td>
                </tr>
                <tr align="center">
                  <td><?php echo $row_rs_pointp['pNote']; ?><br>
                  <a href="del-picture.php?pId=<?php echo $row_rs_pointp['pId']; ?>&dId=<?php echo $_GET['dId'];?>" class="button gray"  onclick="javascript:return confirm('?????????????????????<?php echo $row_rs_pointp['pNote']; ?>???')" >??????</a></td>
                </tr>
                </tbody>
              </table></div>
              
            <?php } while ($row_rs_pointp = mysqli_fetch_assoc($rs_pointp)); ?>
            <?php }else{ ?>
            
            <center><h1>????????????????????????(??????????????????)</h1></center>
            <?php } ?>
            
            
          <div align="right">
            <?php 
# variable declaration
$prev_rs_pointp = "?? previous";
$next_rs_pointp = "next ??";
$separator = " ";
$max_links = 10;
$pages_navigation_rs_pointp = buildNavigation($pageNum_rs_pointp,$totalPages_rs_pointp,$prev_rs_pointp,$next_rs_pointp,$separator,$max_links,true); 

print $pages_navigation_rs_pointp[0]; 
?>
            <?php print $pages_navigation_rs_pointp[1]; ?> <?php print $pages_navigation_rs_pointp[2]; ?><br>
          </div>
        </div>


			<!-- Copyrights -->
			<div class="col-md-12">
				<div class="copyrights">?? 2017 Wandering. All Rights Reserved.</div>
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
mysqli_free_result($rs_pointp);
?>
