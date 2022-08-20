<?php require_once('../Connections/Wandering.php'); ?>
<?php
function br2nl($text){
    return preg_replace('/<br\\s*?\/??>/i','',$text);
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
include('resize.php');
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",52428800);
define("DESTINATION_FOLDER", "../images");
define("no_error", "");
define("yes_error", "");
$_accepted_extensions_ = "png,gif,jpg";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['fileField'])){
	if(is_uploaded_file($HTTP_POST_FILES['fileField']['tmp_name']) && $HTTP_POST_FILES['fileField']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['fileField'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		
						if($_size_ > MAX_SIZE && MAX_SIZE > 0){
			$errStr = "檔案大小超過限制";
		}
		$_ext_ = explode(".", $_name_);
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		if(!in_array($_ext_, $_accepted_extensions_) && count($_accepted_extensions_) > 0){
			$errStr = "不接受的檔案格式";
		}
		if(!is_dir(DESTINATION_FOLDER) && is_writeable(DESTINATION_FOLDER)){
			$errStr = "指定位置非目錄";
		}
		if(empty($errStr)){
			$_name_ = date("YmdHis") . "." . $_ext_;
			if(@move_uploaded_file($_tmp_name_,DESTINATION_FOLDER . "/" . $_name_)){
				//header("Location: " . no_error);
				//縮圖
				$src  = DESTINATION_FOLDER . "/" . $_name_;
				$dest = $src;
				$destW = 800;
				$destH = 568;
				imagesResize($src,$dest,$destW,$destH);

			@unlink(DESTINATION_FOLDER . "/" . $_POST['Filename']);
	
			} else {
				$errStr = "複製檔案至目的位置失敗";
				//header("Location: " . yes_error);
			}
		} else {
			//header("Location: " . yes_error);
		}
	}
	else{
		switch($_FILES['fileField']['error']){
			case 1 : $errStr = "檔案大小超出 php.ini:upload_max_filesize 限制";
			case 2 : $errStr = "檔案大小超出 MAX_FILE_SIZE 限制";
			case 3 : $errStr = "檔案僅被部分上傳";
			case 4 : $_name_= $_POST['Filename'];
			
			
		}
	}
	
	if($errStr != ""){
		header ('Content-type: text/html; charset=utf-8');
		echo "<script>javascript:alert(\"錯誤! " . $errStr . "\");</script>";
		echo "<script>parent.location=\"" . $_SERVER['REQUEST_URI'] . "\"</script>";
		exit;	
	}		
	
	
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
  $updateSQL = sprintf("UPDATE collect SET cName=%s, cPicture=%s, cIntroduction=%s, cManagement=%s, cHphone=%s, cCphone=%s, cEmail=%s, cMap=%s, cMaplat=%s, cMaplong=%s, cContent=%s, cInfo=%s WHERE cId=%s",
                       GetSQLValueString($Wandering,$_POST['cName'], "text"),
					   GetSQLValueString($Wandering,$_name_, "text"),
                       GetSQLValueString($Wandering,$_POST['cIntroduction'], "text"),
                       GetSQLValueString($Wandering,$_POST['cManagement'], "text"),
                       GetSQLValueString($Wandering,$_POST['cHphone'], "text"),
                       GetSQLValueString($Wandering,$_POST['cCphone'], "text"),
                       GetSQLValueString($Wandering,$_POST['cEmail'], "text"),
                       GetSQLValueString($Wandering,$_POST['cMap'], "text"),
                       GetSQLValueString($Wandering,$_POST['cMaplat'], "text"),
                       GetSQLValueString($Wandering,$_POST['cMaplong'], "text"),
                       GetSQLValueString($Wandering,nl2br($_POST['cContent']), "text"),
					   GetSQLValueString($Wandering,nl2br($_POST['cInfo']), "text"),
                       GetSQLValueString($Wandering,1, "int"));

  
  $Result1 = mysqli_query($Wandering, $updateSQL) or die(mysqli_error());

  $updateGoTo = "edit-collect.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已編輯集貨站→" . $_POST['cName'] . "成功')</script>"; 
echo "<script>document.location.href='" . $updateGoTo . "';</script>";
}




$query_ed_collect = "SELECT * FROM collect WHERE cId = 1";
$ed_collect = mysqli_query($Wandering, $query_ed_collect) or die(mysqli_error());
$row_ed_collect = mysqli_fetch_assoc($ed_collect);
$totalRows_ed_collect = mysqli_num_rows($ed_collect);
?>

<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>編輯集貨站資料</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/colors/main.css" id="colors">
 <script src="../../ck/ckeditor/ckeditor.js"></script>
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
          <div id="logo"> <a href="../index.php" class="dashboard-logo"><img src="../images/logo.png" alt=""></a> </div>
          <!-- Mobile Navigation -->
          <div class="menu-responsive"> <i class="fa fa-reorder menu-trigger"></i> </div>
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
				
					<a href="add-dogpoint.php" class="button border with-icon">新增狗場<i class="sl sl-icon-plus"></i></a>
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
        <li><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>貼文管理</a> </li>
        <li><a   href="show-dogpoint.php"> <i class="sl sl-icon-location"></i> 狗場管理</a></li>
         
                <li  class="active"><a> <i class="sl sl-icon-social-dropbox"></i> 物資集貨</a>
          <ul>
            <li class="active"><a href="edit-collect.php">物資集貨站</a></li>
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
             
         <li ><a> <i class="sl sl-icon-paper-plane"></i> 網站內容設定</a>
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
					<h2>編輯<?php echo $row_ed_collect['cName']; ?></h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">後臺管理</a></li>
							<li><a href="#">物資集貨</a></li>
							<li>集貨站編輯</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
        
    <form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12">
          <div id="add-listing">
            <!-- Section -->
            <div class="add-listing-section">
              <!-- Headline -->
              <div class="add-listing-headline">
                <h3><i class="sl sl-icon-note"></i>基本資訊</h3>
              </div>
              <!-- Title -->
              <div class="row with-forms">
                <div class="col-md-6">
                  <h5>集貨站名稱</h5>
                  <input name="cName" type="text" required  class="search-field" placeholder="輸入集貨站名稱" value="<?php echo $row_ed_collect['cName']; ?>" />
                </div>
                
                <div class="col-md-6">
                  <h5>負責人</h5>
                  <input name="cManagement" type="text" required  class="search-field" placeholder="輸入負責人名稱" value="<?php echo $row_ed_collect['cManagement']; ?>" />
                </div>
                  
              </div>
              
               <div class="row with-forms">
               
               <div class="col-md-4">
                  <h5>家電號碼</h5>
                  <input name="cHphone" type="text"  class="search-field" placeholder="輸入家電號碼" value="<?php echo $row_ed_collect['cHphone']; ?>" />
                </div>
                
                <div class="col-md-4">
                  <h5>手機號碼</h5>
                  <input name="cCphone" type="text"  class="search-field" placeholder="輸入手機號碼" value="<?php echo $row_ed_collect['cCphone']; ?>" />
                </div>
                
                  <div class="col-md-4">
                  <h5>聯絡Email</h5>
                  <input name="cEmail" type="text"  class="search-field" placeholder="輸入Email" value="<?php echo $row_ed_collect['cEmail']; ?>" />
                </div>
              </div>
              
              
              <!-- Row -->
              <div class="row with-forms">
 <div class="col-md-12">
                  <h5>甚麼是集貨站(選填)</h5>
                  <textarea name="cContent" class="search-field" id="cContent"><?php echo br2nl($row_ed_collect['cContent']); ?></textarea>
</div>
                <div class="col-md-12">
                  <h5>寄送注意事項</h5>
                  <textarea name="cInfo" class="search-field" id="cInfo"><?php echo br2nl($row_ed_collect['cInfo']); ?></textarea>
</div>

                <div class="col-md-12">
                  <h5>集貨站簡介</h5>
                  <div class="form">
 
              <textarea name="cIntroduction" cols="40" rows="3" required class="WYSIWYG" id="summary" spellcheck="true"><?php echo $row_ed_collect['cIntroduction']; ?></textarea>
              
              <script>
				  CKEDITOR.replace('summary',
				  {
					 	filebrowserBrowseUrl: '../../ck/ckfinder/ckfinder.html',
						filebrowserImageBrowseUrl: '../../ck/ckfinder/ckfinder.html?type=Images',
						filebrowserFlashBrowseUrl: '../../ck/ckfinder/ckfinder.html?type=Flash',
						filebrowserUploadUrl: '../../ck/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
						filebrowserImageUploadUrl: '../../ck/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
						filebrowserFlashUploadUrl: '../../ck/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
					});
					
				  </script>
                  
            </div>
</div>

              </div>

              <!-- Row / End -->
            
      
             <div class="add-listing-headline margin-top-15">
                <h3><i class="sl sl-icon-location"></i>集貨站位置設定</h3>
              </div>
              
               <div class="row with-forms">
              <div class="col-md-12">
					<h5>集貨站地址</h5>
									<input name="cMap" type="text" required id="sButtonname" value="<?php echo $row_ed_collect['cMap']; ?>">
								</div>

           </div>
           
           
               <div class="row with-forms">

              <div class="col-md-6">
					<h5>位置緯度</h5>
									<input name="cMaplat" type="text" required id="sButtonname" value="<?php echo $row_ed_collect['cMaplat']; ?>">
								</div>
                                
                  <div class="col-md-6">
					<h5>位置經度</h5>
					  <input name="cMaplong" type="text" required id="sButtonline" value="<?php echo $row_ed_collect['cMaplong']; ?>">
					</div>
              
                    
              </div>
              
              
           
           
              
                            </div>
                            
                            
                             <!-- Section -->
        <div class="add-listing-section margin-top-25">
          <!-- Headline -->
          <div class="add-listing-headline">
            <h3><i class="sl sl-icon-picture"></i>代表照片(建議大小800*568)</h3>
          </div>
          <!-- Dropzone -->
          <div class="submit-section">
             <div class="photoUpload">
							    <span><i class="sl sl-icon-arrow-up-circle"></i> 上傳照片</span>
							    <input name="fileField" type="file" class="upload" id="fileField"/>
                                <input name="Filename" type="hidden" id="Filename" value="<?php echo $row_ed_collect['cPicture']; ?>">
							</div>
           
          </div>
        </div>
        <!-- Section / End -->
        
        
            </div>
          </div>
          <!-- Section / End -->
        
        <center>
          <button class="button preview">完成編輯<i class='fa fa-arrow-circle-right'></i></button>
        </center>
      </div>
      <input type="hidden" name="MM_update" value="form1">
     

    </form>
    <!-- Copyrights -->
    <div class="col-md-12">
      <div class="copyrights">© 2017 Wandering Team. All Rights Reserved.</div>
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


<!-- DropZone | Documentation: https://dropzonejs.com -->
<script type="text/javascript" src="../scripts/dropzone.js"></script>


</body>
</html>
<?php
mysqli_free_result($ed_collect);
?>
