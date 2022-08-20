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
include('resize.php');
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",52428800);
define("DESTINATION_FOLDER", "../images/dogpoint");
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
			case 4 : $errStr = "檔案未上傳成功";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dogpoint (dType, dName, dHavedog, dIntroduction, dPicture, dManagement, dHphone, dCphone, dMap, dMappoint, dYoutube, dFb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($Wandering,$_POST['dType'], "int"),
                       GetSQLValueString($Wandering,$_POST['dName'], "text"),
                       GetSQLValueString($Wandering,$_POST['dHavedog'], "int"),
                       GetSQLValueString($Wandering,$_POST['dIntroduction'], "text"),
                       GetSQLValueString($Wandering,$_name_, "text"),
                       GetSQLValueString($Wandering,$_POST['dManagement'], "text"),
                       GetSQLValueString($Wandering,$_POST['dHphone'], "text"),
                       GetSQLValueString($Wandering,$_POST['dCphone'], "text"),
                       GetSQLValueString($Wandering,$_POST['dMap'], "text"),
                       GetSQLValueString($Wandering,$_POST['dMappoint'], "text"),
                       GetSQLValueString($Wandering,$_POST['dYoutube'], "text"),
                       GetSQLValueString($Wandering,$_POST['dFb'], "text"));

  
  $Result1 = mysqli_query($Wandering, $insertSQL) or die(mysqli_error());



$query_rs_findpoint = sprintf("SELECT dId FROM dogpoint WHERE dPicture = %s", GetSQLValueString($Wandering,$_name_, "text"));
$rs_findpoint = mysqli_query($Wandering, $query_rs_findpoint) or die(mysqli_error());
$row_rs_findpoint = mysqli_fetch_assoc($rs_findpoint);
$totalRows_rs_findpoint = mysqli_num_rows($rs_findpoint);



echo "<script>javascript:alert('此處狗場是編號●" . $row_rs_findpoint['dId'] . "。')</script>";
  //插入需求
   foreach($_POST['nName'] as $i => $val){
	   
	   echo "<script>javascript:alert('需要★基本的" . $_POST['nName'][$i] . "物品。')</script>";
	   
   if($_POST['nName'][$i] != ""){
    $insertSQL = sprintf("INSERT INTO dogneed (nLdid, nLtid, nName, nRemarks) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($Wandering,$row_rs_findpoint['dId'], "int"),
                       GetSQLValueString($Wandering,$_POST['nLtid'][$i], "int"),
                       GetSQLValueString($Wandering,$_POST['nName'][$i], "text"),
                       GetSQLValueString($Wandering,$_POST['nRemarks'][$i], "text"));

    
  $Result1 = mysqli_query($Wandering, $insertSQL) or die(mysqli_error());
  }
}

//插入其它需求
   foreach($_POST['nName2'] as $i => $val){
	   
	    echo "<script>javascript:alert('需要▲其它的" . $_POST['nName2'][$i] . "物品。')</script>";
  
  if($_POST['nName2'][$i] != ""){
   $insertSQL = sprintf("INSERT INTO dogneed (nLdid, nLtid, nName, nRemarks) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($Wandering,$row_rs_findpoint['dId'], "int"),
                       GetSQLValueString($Wandering,1, "int"),
                       GetSQLValueString($Wandering,$_POST['nName2'][$i], "text"),
                       GetSQLValueString($Wandering,$_POST['nRemarks2'][$i], "text"));

   
  $Result1 = mysqli_query($Wandering, $insertSQL) or die(mysqli_error());
  }
}
mysqli_free_result($rs_findid);

  header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('已成功新增" . $_POST['dName'] . "成功')</script>"; 
echo "<script>document.location.href='./show-dogpoint.php';</script>";

}

?>


<?php


$query_rs_things = "SELECT * FROM thingstable WHERE tId > 1 ORDER BY tId ASC";
$rs_things = mysqli_query($Wandering, $query_rs_things) or die(mysqli_error());
$row_rs_things = mysqli_fetch_assoc($rs_things);
$totalRows_rs_things = mysqli_num_rows($rs_things);


?>


<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>新增狗場</title>
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
        <li><a  href="show-post.php"><i class="sl sl-icon-notebook"></i>貼文管理</a> </li><li  class="active"><a  href="show-dogpoint.php"> <i class="sl sl-icon-location"></i> 狗場管理</a></li>
         
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
          <h2>新增狗場</h2>
          <!-- Breadcrumbs -->
          <nav id="breadcrumbs">
            <ul>
              <li><a href="#">後臺管理</a></li>
              <li><a href="#">狗場管理</a></li>
              <li>新增狗場</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <form action="<?php echo $editFormAction; ?>"  name="form1" id="form1" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12">
          <div id="add-listing">
            <!-- Section -->
            <div class="add-listing-section">
              <!-- Headline -->
              <div class="add-listing-headline">
                <h3><i class="sl sl-icon-doc"></i>基本資訊</h3>
              </div>
              <!-- Title -->
              <div class="row with-forms">
                <div class="col-md-12">
                  <h5>狗場名稱</h5>
                  <input name="dName" type="text" required  class="search-field" placeholder="請在此輸入狗場名稱" />
                </div>
              </div>
              <!-- Row -->
              <div class="row with-forms">
                <!-- Types -->
                <div class="col-md-6">
                  <h5>狗場類型</h5>
                  <select name="dType" class="chosen-select-no-single" >
                    <option value="1">一般狗場</option>
                    <option value="1000">集貨站狗場</option>
                  </select>
                </div>
                <!-- Type -->
                <div class="col-md-6">
                  <h5>狗場負責人</h5>
                  <input name="dManagement" type="text" required="required"  placeholder="輸入負責人">
                </div>
              </div>
              <!-- Row / End -->
              <!-- Row -->
              <div class="row with-forms">
                <!-- have -->
                <div class="col-md-6">
                  <h5>毛小孩數量</h5>
                  <input name="dHavedog" type="number" required="required"  placeholder="輸入數量單位">
                </div>
              </div>
              <!-- Row / End -->
            </div>
          </div>
          <!-- Section / End -->
          <!-- Section -->
          <div class="add-listing-section margin-top-25">
            <!-- Headline -->
            <div class="add-listing-headline">
              <h3><i class="sl sl-icon-docs"></i>詳細資料</h3>
            </div>
            <!-- Description -->
            <div class="form">
              <h4>場所簡介<i class="tip" data-tip-content="參考格式標題28px,內容20px，圖片內容和標題可空一格(不一定要做標題)，圖片最後插入，設定右方的指令，再將圖片移動到第一格位置。"></i>→首張圖片class格式請設定：col-md-4 col-sm-12 res-margin2<br>
</h4>
              <textarea name="dIntroduction" cols="40" rows="3" required class="WYSIWYG" id="summary" spellcheck="true"></textarea>
              
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
                  
            </div><br>
            <!-- Row -->
            <div class="row with-forms">
              <!-- Phone -->
              <div class="col-md-4">
                <h5>聯絡手機<span>(選填)</span></h5>
                <input type="text" name="dCphone">
              </div>
              <!-- Website -->
              <div class="col-md-4">
                <h5>連絡家電<span>(選填)</span></h5>
                <input type="text" name="dHphone">
              </div>
              <!-- FB -->
              <div class="col-md-4">
                <h5 class="fb-input"><i class="fa fa-facebook-square"></i>Facebook專頁<span>(選填)</span></h5>
                <input name="dFb" type="text" placeholder="e.g. https://www.facebook.com/abc">
              </div>
              <!-- YOUTUBE -->
              <div class="col-md-12">
                <h5>介紹影片連結<span>(請插入在簡介中，此處設定不生效)</span></h5>
                <input type="text" name="dYoutube">
              </div>
            </div>
            <!-- Row / End -->
          </div>
          <!-- Section / End -->
          <!-- Section -->
          <div class="add-listing-section margin-top-25">
            <!-- Headline -->
            <div class="add-listing-headline">
              <h3><i class="sl sl-icon-location"></i>位置內容</h3>
            </div>
            <div class="submit-section">
              <!-- Row -->
              <div class="row with-forms">
                <!-- Address -->
                <div class="col-md-12">
                  <h5>地址(選填)</h5>
                  <input name="dMap" type="text" placeholder="e.g. 台中市新社區">
                </div>
                <!-- 座標 -->
                <div class="col-md-12">
                  <h5>座標位置<i class="tip" data-tip-content="座標位置非公開地址，請先到GoogleMap標記誇張適合放的位置即可"></i></h5>
                  <input name="dMappoint" type="text" required placeholder="e.g. 24.248623,120.8372269">
                </div>
              </div>
              <!-- Row / End -->
            </div>
          </div>
          <!-- Section / End -->
          <!-- Section -->
          <div class="add-listing-section margin-top-45">
            <!-- Headline -->
            <div class="add-listing-headline">
              <h3><i class="sl sl-icon-book-open"></i>物資需求</h3>
            </div>
           
            
          
            
            <h5 class="margin-top-30 margin-bottom-10">基本物資</h5>
           
          	<div class="col-md-5">
									
									  <select id="selectthings" class="chosen-select" data-placeholder="請選擇" onChange='chg()'>
									    <option label="請選擇"></option>
                                        <?php $count = 0; ?>
									    <?php do { $count++; if($count==1){$food = $row_rs_things['tName'];$fistn = $row_rs_things['tId'];}?>
                                        <option><?php echo $row_rs_things['tName']; ?></option>
                                    <?php } while ($row_rs_things = mysqli_fetch_assoc($rs_things)); ?>
                                        
									    </select>
									  
								</div>
      
        
          <div class="row">
            <div class="col-md-12">
              <table id="pricing-list-container2">
                
                <tr class="pricing-list-item pattern2">
					<td>
						<div class="fm-input pricing-name"><input name="nName[]" type="text" placeholder="項目" value="<?php echo $food ?>" readonly /></div>
						<div class="fm-input pricing-ingredients"><input name="nRemarks[]" type="text" placeholder="備註" /></div>
						<div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div>
						<input name="nLtid[]" type="hidden" id="nLtid" value="<?php echo $fistn; ?>">
					</td>
				</tr>
                
              </table>
               </div>
          </div>
         
          <script type="text/javascript">
		  
		  function chg() { /*選中新增*/
		  var temp = Number(<?php echo $fistn; ?>);
		   var currSelectValue = document.getElementById('selectthings').selectedIndex;
		  var currSelectText = document.getElementById('selectthings').options[currSelectValue].text;
		 currSelectValue = currSelectValue + temp; 
		  	var newElem = $(''+
				'<tr class="pricing-list-item pattern2">'+
					'<td>'+
						'<div class="fm-input pricing-name"><input name="nName[]" type="text" placeholder="項目" value="'+ currSelectText +'" readonly="readonly" /></div>'+
						'<div class="fm-input pricing-ingredients"><input name="nRemarks[]" type="text" placeholder="備註" /></div>'+
						'<div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div>'+
						'<input name="nLtid[]" type="hidden" id="nLtid" value="'+ currSelectValue +'">'+
					'</td>'+
				'</tr>');

			newElem.appendTo('table#pricing-list-container2');
		  }
		  </script>

          <h5 class="margin-top-30 margin-bottom-10">其它物資</h5>
          <div class="row">
            <div class="col-md-12">
              <table id="pricing-list-container">
                <tr class="pricing-list-item pattern">
                  <td><div class="fm-move"><i class="sl sl-icon-cursor-move"></i></div>
                    <div class="fm-input pricing-name">
                      <input name="nName2[]" type="text" placeholder="項目" />
                    </div>
                    <div class="fm-input pricing-ingredients">
                      <input name="nRemarks2[]" type="text" placeholder="備註" />
                    </div>
                    <div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div></td>
                </tr>
              </table>
              <a href="#" class="button add-pricing-list-item">點我新增更多需求物資</a> </div>
          </div>
        </div>
        <!-- Section / End -->
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
							    <input name="fileField" type="file" class="upload" required id="fileField"/>
							</div>
           
          </div>
        </div>
        <!-- Section / End -->
        <center>
          <button class="button preview">新增完成<i class='fa fa-arrow-circle-right'></i></button>
        </center>
      </div>
      </div>
      <input type="hidden" name="MM_insert" value="form1">
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
</html><?php
mysqli_free_result($rs_things);

?>
