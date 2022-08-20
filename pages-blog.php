<?php require_once('./Connections/Wandering.php'); ?>


<?php

function TrimByLength2($str, $len, $word) { 
  $end = "";
  if (mb_strlen($str,"utf-8") > $len) $end = "...";
  $str = mb_substr($str, 0, $len,"UTF-8");
  if ($word) $str = substr($str,0,strrpos($str," ")+1);
  return $str.$end;
}

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

$maxRows_rs_newpost = 3;
$pageNum_rs_newpost = 0;
if (isset($_GET['pageNum_rs_newpost'])) {
  $pageNum_rs_newpost = $_GET['pageNum_rs_newpost'];
}
$startRow_rs_newpost = $pageNum_rs_newpost * $maxRows_rs_newpost;


$query_rs_newpost = "SELECT * FROM post ORDER BY pStime DESC";
$query_limit_rs_newpost = sprintf("%s LIMIT %d, %d", $query_rs_newpost, $startRow_rs_newpost, $maxRows_rs_newpost);
$rs_newpost = mysqli_query($Wandering, $query_limit_rs_newpost) or die(mysqli_error());
$row_rs_newpost = mysqli_fetch_assoc($rs_newpost);

if (isset($_GET['totalRows_rs_newpost'])) {
  $totalRows_rs_newpost = $_GET['totalRows_rs_newpost'];
} else {
  $all_rs_newpost = mysqli_query($Wandering, $query_rs_newpost);
  $totalRows_rs_newpost = mysqli_num_rows($all_rs_newpost);
}
$totalPages_rs_newpost = ceil($totalRows_rs_newpost/$maxRows_rs_newpost)-1;

$maxRows_rs_showpost = 5;
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

//資料集分頁Function
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_rs_dogpoint,$totalRows_rs_dogpoint;
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
					if ($_get_name != "pageNum_rs_dogpoint") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_dogpoint=$precedente$_get_vars\" class='pagenate-prev fa fa-angle-left' rel='prev'></a>" :  "$prev_Recordset1";
			//頁碼
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_rs_dogpoint) + 1;
					$max_l = ($a*$maxRows_rs_dogpoint >= $totalRows_rs_dogpoint) ? $totalRows_rs_dogpoint : ($a*$maxRows_rs_dogpoint);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_rs_dogpoint=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a></li>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "<li><a href='#' class='current'>";
					$pagesArray .= "$textLink</a></li>"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_rs_dogpoint=$successivo$_get_vars\" class='pagenate-next fa fa-angle-right' rel='next'></a>" : "$next_Recordset1";
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
<title>踏浪</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/main.css" id="colors">

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

						<li><a class="current" href="pages-blog.php">訊息發布</a></li>


						<li><a href="dogpoint-grid-full-width.php">狗場列表</a></li>

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

				<h2>訊息發布</h2><span>最新貼文</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">首頁</a></li>
						<li>訊息發布</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">

	<!-- Blog Posts -->
	<div class="blog-page">
	<div class="row">
		<div class="col-lg-9 col-md-8 padding-right-30">
        
		  <?php do { ?>
		    
		    <!-- Blog Post -->
		    <div class="blog-post">
		      
		      <!-- Img -->
		      <a href="pages-blog-post.php?Id=<?php echo $row_rs_showpost['pId']; ?>" class="post-img">
		        <img src="images/post/<?php echo $row_rs_showpost['pPicture']; ?>" alt="">
	          </a>
		      
		      <!-- Content -->
		      <div class="post-content">
		        <h2><a href="pages-blog-post.php?Id=<?php echo $row_rs_showpost['pId']; ?>"><?php echo $row_rs_showpost['pTitle']; ?></a></h2>
		        
		        <ul class="post-meta">
		          <li><?php echo date('Y 年 m 月 d 日',strtotime($row_rs_showpost['pStime'])); ?></li>
		          <li><a href="#"><?php if($row_rs_showpost['pType'] == 0){ echo "消息";}
elseif($row_rs_showpost['pType'] == 1){ echo "募集";}
elseif($row_rs_showpost['pType'] == 2){ echo "活動";}
elseif($row_rs_showpost['pType'] == 3){ echo "系統";}
elseif($row_rs_showpost['pType'] == 4){ echo "綜合";} ?></a></li>
		          
		          </ul>
		        
		        <p><?php if($row_rs_showpost['pOutline'] != ""){ echo $row_rs_showpost['pOutline'];}
					else{ echo TrimByLength2($row_rs_showpost['pContent'], 50, false);} ?></p>
		        
		        <a href="pages-blog-post.php?Id=<?php echo $row_rs_showpost['pId']; ?>" class="read-more">詳細內容<i class="fa fa-angle-right"></i></a>
		        </div>
		      
		      </div>
		    <!-- Blog Post / End -->
		    <?php } while ($row_rs_showpost = mysqli_fetch_assoc($rs_showpost)); ?>
            
            
<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="pagenate theme-pagenate">
        
             <?php 
//分頁的變數設定以及分頁函式呼叫
$prev_rs_dogpoint = "";
$next_rs_dogpoint = "";
$separator = " ";
$max_links = 5;
$pages_navigation_rs_dogpoint = buildNavigation($pageNum_rs_dogpoint,$totalPages_rs_dogpoint,$prev_rs_dogpoint,$next_rs_dogpoint,$separator,$max_links,true); 

print $pages_navigation_rs_dogpoint[0]; ?>
 <?php print $pages_navigation_rs_dogpoint[2]; ?>
 <ul class="pagenate-body"> 
 <?php print $pages_navigation_rs_dogpoint[1]; ?>
 </ul>
             
</div>
			<!-- Pagination / End -->

		</div>

	<!-- Blog Posts / End -->

	<!-- Widgets -->
	<div class="col-lg-3 col-md-4">
		<div class="sidebar right">


<script type="text/javascript">
function checkAll(field){

run2 = run2 + 1;
var a = run2 % 2;

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

			<form action="pages-findblog.php" method="get" name="form1" id="form1">
            
            <!-- Widget -->
			<div class="widget">
				<h3 class="margin-top-0 margin-bottom-25">搜尋文章</h3>
				<div class="search-boxs">
  <label for="search" class="off-left"></label>
  <input type="text" name="keyword" id="search" placeholder="請輸入關鍵字">
  <button type="submit">
    <i class="fa fa-search"></i>
  </button>
</div>
                
                <!-- Panel Dropdown -->
						<div class="panel-dropdown wide float-left">
							<a href="#">貼文類型篩選</a>
							<div class="panel-dropdown-content checkboxes">                           



								<!-- Checkboxes -->
								<div class="row">
								    <div class="col-md-3">
									    <input name="list" type="checkbox" id="check-0" value="0" checked="checked">
									    <label for="check-0">消息</label>

								      </div>

									<div class="col-md-3">
									    <input name="list" type="checkbox" id="check-1" value="1" checked="checked">
									    <label for="check-1">募集</label>
									   
								  </div>
                                  
                                  <div class="col-md-3">

								  </div>

							  </div>
                              
                              		<div class="row">
								    <div class="col-md-3">
									    <input name="list" type="checkbox" id="check-2" value="2" checked="checked">
									    <label for="check-2">活動</label>

								      </div>

									<div class="col-md-3">
									    <input name="list" type="checkbox" id="check-3" value="3" checked="checked">
									    <label for="check-3">系統</label>
									   
								  </div>
                                  
                                  <div class="col-md-3">

								  </div>

							  </div>
                              
                              		<div class="row">
								    <div class="col-md-3">
									    <input name="list" type="checkbox" id="check-4" value="4" checked="checked">
									    <label for="check-4">綜合</label>

								      </div>

									<div class="col-md-3">
 
								  </div>
                                  
                                  <div class="col-md-3">

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
                
				<div class="clearfix"></div>
			</div>
			<!-- Widget / End --></form>


			<!-- Widget --><div class="widget margin-top-40">
				<h3>您有任何問題嗎?</h3>
				<div class="info-box margin-bottom-10">
					<p>我們提供線上提問，歡迎您給與我們問題或意見，成為我們改善的最大動力。</p>
					<a href="https://goo.gl/forms/svGuOflKFoGzEcrP2" target="_blank" class="button fullwidth margin-top-20"><i class="fa fa-envelope-o"></i> 提問箱</a>
				</div
			><!-- Widget / End -->


			<!-- Widget -->
			<div class="widget margin-top-40">

				<h3>最新消息</h3>
				<ul class="widget-tabs">

					
					<?php do { ?>
				    <li>
					    <div class="widget-content">
					      <div class="widget-thumb">
					        <a href="pages-blog-post.php?Id=<?php echo $row_rs_newpost['pId']; ?>"><img src="images/post/<?php echo $row_rs_newpost['pPicture']; ?>" alt=""></a>
					        </div>
					      
					      <div class="widget-text">
					        <h5><a href="pages-blog-post.php?Id=<?php echo $row_rs_newpost['pId']; ?>"><?php echo $row_rs_newpost['pTitle']; ?></a></h5>
					        <span><?php echo date('Y年m月d日',strtotime($row_rs_newpost['pStime'])); ?></span>
					        </div>
					      <div class="clearfix"></div>
					      </div>
				      </li>
					  <?php } while ($row_rs_newpost = mysqli_fetch_assoc($rs_newpost)); ?>
					
					

				</ul>

			</div>
			<!-- Widget / End-->

<?php 

$query_rs_footer = "SELECT * FROM footer WHERE fId = 1";
$rs_footer = mysqli_query($Wandering, $query_rs_footer) or die(mysqli_error());
$row_rs_footer = mysqli_fetch_assoc($rs_footer);
$totalRows_rs_footer = mysqli_num_rows($rs_footer); ?>

<?php if($row_rs_footer['fFb'] != "" or $row_rs_footer['fIg'] != "" or $row_rs_footer['fYtb'] != ""){ ?>
			<!-- Widget -->
			<div class="widget margin-top-40">
				<h3 class="margin-bottom-25">社群網站</h3>
				<ul class="social-icons rounded">
                <?php if($row_rs_footer['fFb'] != ""){ ?>
					<li><a class="facebook" href="<?php echo $row_rs_footer['fFb']; ?>"><i class="icon-facebook"></i></a></li> <?php } ?>
                    <?php if($row_rs_footer['fIg'] != ""){ ?>
					<li><a class="instagram" href="<?php echo $row_rs_footer['fIg']; ?>"><i class="icon-instagram"></i></a></li> <?php } ?>
                    <?php if($row_rs_footer['fYtb'] != ""){ ?>
					<li><a class="youtube" href="<?php echo $row_rs_footer['fYtb']; ?>"><i class="icon-youtube"></i></a></li> <?php } ?>
				</ul>

			</div>
			<!-- Widget / End--><?php } ?>

			<div class="clearfix"></div>
			<div class="margin-bottom-40"></div>
		</div>
	</div>
	</div>
	<!-- Sidebar / End -->


</div>
</div>



<!-- Footer

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
					<li><a href="pages-blog.php">訊息發布</a></li>
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
run2 = 0;
</script>

</body>
</html>
<?php
mysqli_free_result($rs_newpost);

mysqli_free_result($rs_showpost);
?>
