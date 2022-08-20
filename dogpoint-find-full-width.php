<?php require_once('./Connections/Wandering.php'); ?>
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


if (isset($_GET['pageNum_rs_dogpoint'])) {
  $pageNum_rs_dogpoint = $_GET['pageNum_rs_dogpoint'];
}
$startRow_rs_dogpoint = $pageNum_rs_dogpoint * $maxRows_rs_dogpoint;

$find_name = "-1";
if (isset($_GET['Keyword'])) {
  $find_name = $_GET['Keyword'];
}
$find_condition = "-1";
if (isset($_GET['Condition'])) {
  $find_condition = $_GET['Condition'];
}
 
$query_rs_dogpoint = sprintf("SELECT * FROM dogpoint WHERE dName LIKE %s OR dIntroduction LIKE %s OR dManagement LIKE %s ORDER BY dType DESC,dHavedog DESC",GetSQLValueString($Wandering,"%" . $find_name . "%", "text"),GetSQLValueString($Wandering,"%" . $find_name . "%", "text"),GetSQLValueString($Wandering,"%" . $find_name . "%", "text"));
$query_limit_rs_dogpoint = sprintf("%s LIMIT %d, %d", $query_rs_dogpoint, $startRow_rs_dogpoint, $maxRows_rs_dogpoint);
$rs_dogpoint = mysqli_query($Wandering, $query_rs_dogpoint) or die(mysqli_error());
$row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint);
$totalRows_rs_dogpoint = mysqli_num_rows($rs_dogpoint);



$query_rs_allbasic = "SELECT * FROM thingstable WHERE tId > 1 ORDER BY tId ASC";
$rs_allbasic = mysqli_query($Wandering, $query_rs_allbasic) or die(mysqli_error());
$row_rs_allbasic = mysqli_fetch_assoc($rs_allbasic);
$totalRows_rs_allbasic = mysqli_num_rows($rs_allbasic);

?>

<?php
session_start();
$_SESSION['listURL'] = "";
	$tempList = "";   
$str = $_SERVER['QUERY_STRING'];
$str = str_replace('&list=',',',$str);
$newstr = explode(",",$str);
unset($newstr[0]);
$newstr = array_values($newstr);

	foreach ($newstr as $value){
		$tempList = $tempList.'&list='.$value;
	}
		
		

$_SESSION['listURL'] = $tempList;

//資料集分頁Function
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_rs_finshdog,$totalRows_rs_finshdog;
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
					if ($_get_name != "pageNum_rs_finshdog") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_finshdog=$precedente$_get_vars$_SESSION[listURL]\" class='pagenate-prev fa fa-angle-left' rel='prev'></a>" :  "$prev_Recordset1";
			//頁碼
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_rs_finshdog) + 1;
					$max_l = ($a*$maxRows_rs_finshdog >= $totalRows_rs_finshdog) ? $totalRows_rs_finshdog : ($a*$maxRows_rs_finshdog);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_rs_finshdog=$theNext$_get_vars$_SESSION[listURL]\">";
					$pagesArray .= "$textLink</a></li>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "<li><a href='#' class='current'>";
					$pagesArray .= "$textLink</a></li>"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_finshdog=$successivo$_get_vars$_SESSION[listURL]\" class='pagenate-next fa fa-angle-right' rel='next'></a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>踏浪-愛心狗場</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/main.css" id="colors">
<link rel="stylesheet" href="fonts/flaticons/flaticon.css" type="text/css">

</head>

<body>
 <!-- preloder -->
	<div class="preloader"></div>
	<!-- preloder -->
<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container">

	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="index.php"><img src="images/logo.png" alt=""></a>
				</div>

				<!-- Mobile Navigation -->
				<div class="menu-responsive">
					<i class="fa fa-reorder menu-trigger"></i>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<ul id="responsive">

						<li><a href="index.php">首頁</a></li>

						<li><a href="pages-blog.php">訊息發布</a></li>


						<li><a class="current" href="dogpoint-grid-full-width.php">狗場列表</a></li>


						<li><a href="gallery.php">相簿</a></li>
						<li><a href="https://docs.google.com/spreadsheets/d/1PeD9CopZ9D_x5UciLy9zcL-15LOGdsWkiD9MQCAyXyE/edit?usp=sharing" target="_blank">芳名錄</a></li>
                        
                        <li><a href="about.php">網站說明</a></li>
						
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->


			<!-- 捐贈物資欄位 -->
			<div class="right-side">
				<div class="header-widget">
					<a href="collectstation.php" target="_blank" class="button border with-icon">我要捐贈物資<i class="sl sl-icon-social-dropbox"></i></a>
				</div>
			</div>
			<!-- Right Side Content / End --><!-- Sign In Popup -->
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
	
	  $MM_redirectLoginFailed = $_SERVER['REQUEST_URI'];
require_once ('includes/recaptcha/autoload.php'); $secret = '6LcG5iwUAAAAAGxD8HeBJ95o_9AeVCsyUmCJMxx_';

    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        // 確認驗證碼與 IP
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        $var = var_export($_POST, true);
		
		 // 確認正確
        if ($resp->isSuccess()) {
           
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "uLevel";
  $MM_redirectLoginSuccess = "server/show-dogpoint.php";
  $MM_redirecttoReferrer = false;
  
  	
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

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	 header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('登入成功')</script>"; 
echo "<script>document.location.href='" . $MM_redirectLoginSuccess . "';</script>";
  }
  else {
	header ('Content-type: text/html; charset=utf-8');
	echo "<script>javascript:alert('帳號或密碼錯誤')</script>"; 
echo "<script>document.location.href='" . $MM_redirectLoginFailed . "';</script>";
  }


        }
        // 確認失敗
        else {
             header ('Content-type: text/html; charset=utf-8');
echo "<script>javascript:alert('安全驗證失敗')</script>"; 
echo "<script>document.location.href='" . $MM_redirectLoginFailed . "';</script>";

        }
    }
	
}
    ?>
    
    
            <?php
    // 註冊或查詢你的 API Keys: https://www.google.com/recaptcha/admin
    $siteKey = '6LcG5iwUAAAAAOJkrx2kx97KBVm4vbYiWFjVFmLm';

    // 所有支援的語系: https://developers.google.com/recaptcha/docs/language
    $lang = 'zh-TW'; ?>
	
	
	
			<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

				<div class="small-dialog-header">
					<h3>Welcome</h3>
				</div>

				<!--Tabs -->
				<div class="sign-in-form style-1">

					<ul class="tabs-nav">
						<li class=""><a href="#tab1">登入</a></li>
					</ul>

					<div class="tabs-container alt">

						<!-- Login -->
                        <form ACTION="<?php echo $loginFormAction; ?>" method="POST" id="form1" class="login">
                        
						<div class="tab-content" id="tab1" style="display: none;">
							
								<p class="form-row form-row-wide">
									<label for="username">帳號:
										<i class="im im-icon-Male"></i>
										<input name="username" type="text" required class="input-text" id="username" value="" />
									</label>
								</p>

								<p class="form-row form-row-wide">
									<label for="password">密碼:
										<i class="im im-icon-Lock-2"></i>
										<input name="password" type="password" required class="input-text" pattern="(?=.*\d)(?=.*[a-zA-Z]).{6,}" title="請輸入英數混和，6字元以上的密碼" id="password"/>
									</label>
									<span class="lost_password">
										<a onclick="forgetpw();">忘記您的密碼嗎?</a>
									</span>
								</p>


<div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl='<?php echo $lang;?>"></script>
            
           <br>
								<div class="form-row">
									<center><input type="submit" class="button border margin-top-5" name="login" value="登入" /></center>
								</div>
								
							
						</div>


    </form>
					</div>
				</div>
			</div>
		  <!-- Sign In Popup / End --></div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>狗場列表</h2><span>來看看這些狗場的介紹吧~</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" style="margin-bottom:-40px;">
					<ul>
						<li><a href="#">首頁</a></li>
						<li>狗場列表</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<?php 
$okpoint = 0;

do { 
      $tempNum = $row_rs_dogpoint['dId']; //第一次篩選結果
	  $check = false;
	 

$query_rs_needtable = sprintf("SELECT DISTINCT nLtid FROM dogneed WHERE nLdid = %s", GetSQLValueString($Wandering,$tempNum, "int"));
$rs_needtable = mysqli_query($Wandering, $query_rs_needtable) or die(mysqli_error());
$row_rs_needtable = mysqli_fetch_assoc($rs_needtable);
$totalRows_rs_needtable = mysqli_num_rows($rs_needtable);
     
		 
	 if($row_rs_needtable['nLtid'] != ""){
    do { 
          
		    foreach ($newstr as $value){
			     
				 if($value == $row_rs_needtable['nLtid']){
					 
					 /* echo "<script>javascript:alert('狗場id->" . $tempNum . "條件" . $value . "連結ltid->" . $row_rs_needtable['nLtid'] . "')</script>"; */
					  $check = true;
					  break;
					  
					 }
					 
		     }
		  
		  if($check){break;}
		  
	    }while ($row_rs_needtable = mysqli_fetch_assoc($rs_needtable));
	 }
mysqli_free_result($rs_needtable);


    if($check){
	
	$okid[$okpoint]	= $tempNum;
	
	$okpoint++;
	
	}

	} while ($row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint));

$stopnum = count($okid);
$count = 0;
			
	if($stopnum != 0){
$maxRows_rs_finshdog = 6;
$pageNum_rs_finshdog = 0;
if (isset($_GET['pageNum_rs_finshdog'])) {
  $pageNum_rs_finshdog = $_GET['pageNum_rs_finshdog'];
}
$startRow_rs_finshdog = $pageNum_rs_finshdog * $maxRows_rs_finshdog;
	
			

$query_rs_finshdog = "SELECT * FROM dogpoint WHERE ";
foreach ($okid as $value){ $count++;
$query_rs_finshdog = $query_rs_finshdog . "dId = " . $value . " ";
if($stopnum != $count ) {
	$query_rs_finshdog = $query_rs_finshdog . "OR ";
   }
}
$query_limit_rs_finshdog = sprintf("%s LIMIT %d, %d", $query_rs_finshdog, $startRow_rs_finshdog, $maxRows_rs_finshdog);
$rs_finshdog = mysqli_query($Wandering, $query_limit_rs_finshdog) or die(mysqli_error());
$row_rs_finshdog = mysqli_fetch_assoc($rs_finshdog);

if (isset($_GET['totalRows_rs_finshdog'])) {
  $totalRows_rs_finshdog = $_GET['totalRows_rs_finshdog'];
} else {
  $all_rs_finshdog = mysqli_query($Wandering, $query_rs_finshdog);
  $totalRows_rs_finshdog = mysqli_num_rows($all_rs_finshdog);
}
$totalPages_rs_finshdog = ceil($totalRows_rs_finshdog/$maxRows_rs_finshdog)-1;
	}

 ?>

<!-- Content
================================================== -->
<div class="container">
	<div class="row">
		
        <form action="dogpoint-find-full-width.php" method="get" id="form1" name="form1">
		<!-- Search -->
		<div class="col-md-12">
			<div class="main-search-input gray-style margin-top-0 margin-bottom-10">

				<div class="main-search-input-item">
					<input name="Keyword" type="text" id="Keyword" placeholder="輸入關鍵字(可留空，只篩選條件)" value="<?php echo $_GET['Keyword']; ?>"/>
				</div>

				

				<div class="main-search-input-item">
					<!-- Panel Dropdown -->
						<div class="panel-dropdown wide float-left">
							<a href="#">物資篩選條件</a>
							<div class="panel-dropdown-content checkboxes">                           

<script type="text/javascript">
function checkAll(field){

run = run + 1;
var a = run % 2;

	if (a == 0){
for (i = 0; i < field.length; i++)
	field[i].checked = true ;
	}
	else{
for (i = 0; i < field.length; i++)
     field[i].checked = false ;
	}

}

</script>

<?php $oneneed = ceil(($totalRows_rs_allbasic+1)/2);
$TT = 0;
do { $TT++;
	$tName[$TT] = $row_rs_allbasic['tName'];
	$tNum[$TT] = $row_rs_allbasic['tId'];
	} while ($row_rs_allbasic = mysqli_fetch_assoc($rs_allbasic));
	$TT++;
	$tName[$TT] = "其它";
	$tNum[$TT] = 1;
 ?>

								<!-- Checkboxes -->
								<div class="row">
								    <div class="col-md-6">
                                    <?php  for($i=1; $i <= $oneneed; $i++){ ?>
									    <input <?php if (in_array(sprintf("%d",$tNum[$i]),$newstr)) {echo "checked=\"checked\"";} ?>  name="list" type="checkbox" id="check-<?php echo $i; ?>" value="<?php echo $tNum[$i]; ?>">
									    <label for="check-<?php echo $i; ?>"><?php echo $tName[$i]; ?></label>
									   
                                        <?php } ?>
								      </div>

									<div class="col-md-6">
									  <?php  for($i=$oneneed+1; $i <= $TT; $i++){ if($tName[$i]!=""){ ?>
									    <input <?php if (in_array(sprintf("%d",$tNum[$i]),$newstr)) {echo "checked=\"checked\"";} ?>  name="list" type="checkbox" id="check-<?php echo $i; ?>" value="<?php echo $tNum[$i]; ?>">
									    <label for="check-<?php echo $i; ?>"><?php echo $tName[$i]; ?></label>
									   
                                        <?php } } ?>
								  </div>
							  </div>
								
								<!-- Buttons -->
								<div class="panel-buttons">
									<font onclick="checkAll(document.form1.list)" style="font-weight:bold;color:#C12A67;">全選/不選</font>
									<a class="panel-apply">收回</a>
								</div>

							</div>
						</div>
						<!-- Panel Dropdown / End -->
				</div>

				<button class="button">搜尋</button>
			</div>
		</div>
		<!-- Search Section / End -->
</form>

		<div class="col-md-12 margin-top-50">


			<div class="row">
            
           
             
              <?php if ($totalRows_rs_finshdog > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <!-- Listing Item -->
    <div class="col-lg-4 col-md-6">
      <a href="Introduction.php?Id=<?php echo $row_rs_finshdog['dId']; ?>" class="listing-item-container compact">
        <div class="listing-item">
          <img src="images/dogpoint/<?php echo $row_rs_finshdog['dPicture']; ?>" alt="">
          
          <div class="listing-item-details">
            <ul>
              <li><?php echo $row_rs_finshdog['dName']; ?></li>
              </ul>
            </div>
          
          <?php if($row_rs_finshdog['dType'] == 1000){ ?>
          <div class="listing-badge now-open">物資集貨站</div>
          <?php } ?>
          
          <div class="listing-item-content">
            <h3>負責人：<?php echo $row_rs_finshdog['dManagement']; ?></h3>
            <span>收留約<?php echo $row_rs_finshdog['dHavedog']; ?>隻狗狗</span>
            </div>
          
          </div>
        </a>
    </div>
    <!-- Listing Item / End -->
    <?php } while ($row_rs_finshdog = mysqli_fetch_assoc($rs_finshdog)); ?>
                <?php }else{ ?>
                
                
             <center><img src="images/no_info.png" alt=""/></center>
             
             <?php } ?>
                
            </div>

			
            <div class="pagenate theme-pagenate">
        
             <?php 
//分頁的變數設定以及分頁函式呼叫
$prev_rs_finshdog = "";
$next_rs_finshdog = "";
$separator = " ";
$max_links = 5;
$pages_navigation_rs_finshdog = buildNavigation($pageNum_rs_finshdog,$totalPages_rs_finshdog,$prev_rs_finshdog,$next_rs_finshdog,$separator,$max_links,true); 

print $pages_navigation_rs_finshdog[0]; ?>
 <?php print $pages_navigation_rs_finshdog[2]; ?>
 <ul class="pagenate-body"> 
 <?php print $pages_navigation_rs_finshdog[1]; ?>
 </ul>
             
</div>
        

		</div>

	</div>
</div>


<!-- Footer
<?php 

$query_rs_footer = "SELECT * FROM footer WHERE fId = 1";
$rs_footer = mysqli_query($Wandering, $query_rs_footer) or die(mysqli_error());
$row_rs_footer = mysqli_fetch_assoc($rs_footer);
$totalRows_rs_footer = mysqli_num_rows($rs_footer); ?>
================================================== -->
<div id="footer" class="dark" style="margin-top:180px;">
	<!-- Main -->
	<div class="container">
		<div class="row">
        	<div class="col-md-5 col-sm-6">
            
				<img class="footer-logo" src="images/logo.png" alt="">
                
				<br><br>
				<p><?php echo $row_rs_footer['fAbout']; ?></p>
                             
             </div>

			<div class="col-md-4 col-sm-6 ">
				<h4>連結區</h4>
              <ul class="footer-links">
					<li><a href="index.php">踏浪首頁</a></li>
					<li><a href="blog.php">訊息發布</a></li>
					<li><a href="dogpoint-grid-full-width.php">狗場列表</a></li>
				</ul>

				<ul class="footer-links">
					<li><a href="gallery.php">踏浪相簿</a></li>
					<li><a href="about.php">網站說明</a></li>
                    <li><a <?php if($_SESSION['MM_Username'] == ""){ ?>href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"<?php }else{ ?> href="server/show-dogpoint.php"<?php } ?> >管理登入</a></li>
				</ul>
                <ul class="social-icons">
                <?php if($row_rs_footer['fFb'] != ""){ ?>
					<li><a class="facebook" href="<?php echo $row_rs_footer['fFb']; ?>"><i class="icon-facebook"></i></a></li>
                    <?php } ?>
                    <?php if($row_rs_footer['fIg'] != ""){ ?>
					<li><a class="instagram" href="<?php echo $row_rs_footer['fIg']; ?>"><i class="icon-instagram"></i></a></li>
                    <?php } ?>
				<?php if($row_rs_footer['fYtb'] != ""){ ?>
					<li><a class="youtube" href="<?php echo $row_rs_footer['fYtb']; ?>"><i class="icon-youtube"></i></a></li>
                    <?php } ?>
				</ul><br>
				<div class="clearfix"></div>
                
			</div>		

			<div class="col-md-3  col-sm-12">
				<h4>聯絡我們</h4>
				<div class="text-widget"><?php echo $row_rs_footer['fCall']; ?></div>
			</div>

		</div>
		
		<!-- Copyright -->
		<div class="row">
			<div class="col-md-12">
				<div class="copyrights">© 2017 Wandering Team. All Rights Reserved.</div>
			</div>
		</div>

	</div>

</div>


<?php mysqli_free_result($rs_footer); ?>
<!-- Footer / End -->



<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


</div>
<!-- Wrapper / End -->



<!-- Scripts
================================================== -->
<script type="text/javascript" src="scripts/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="scripts/jpanelmenu.min.js"></script>
<script type="text/javascript" src="scripts/chosen.min.js"></script>
<script type="text/javascript" src="scripts/slick.min.js"></script>
<script type="text/javascript" src="scripts/rangeslider.min.js"></script>
<script type="text/javascript" src="scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="scripts/waypoints.min.js"></script>
<script type="text/javascript" src="scripts/counterup.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/tooltips.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
<script type="text/javascript">
run = 0;
</script>

</body>
</html><?php
mysqli_free_result($rs_allbasic);

mysqli_free_result($rs_dogpoint);

mysqli_free_result($rs_finshdog);
?>
