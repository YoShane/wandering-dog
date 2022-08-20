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

$colname_rs_post = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_post = $_GET['Id'];
}

$query_rs_post = sprintf("SELECT * FROM post WHERE pId = %s", GetSQLValueString($Wandering,$colname_rs_post, "int"));
$rs_post = mysqli_query($Wandering, $query_rs_post) or die(mysqli_error());
$row_rs_post = mysqli_fetch_assoc($rs_post);
$totalRows_rs_post = mysqli_num_rows($rs_post);

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


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.10&appId=848279675320032";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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

				<h2>訊息發布</h2><span>檢視貼文</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">首頁</a></li>
						<li>訊息發布</li>
                        <li>檢視貼文</li>
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


		<!-- Post Content -->
		<div class="col-lg-9 col-md-8 padding-right-30">


			<!-- Blog Post -->
			<div class="blog-post single-post">
				
                <?php if($row_rs_post['pShow'] == 0){ ?>
				<!-- Img -->
				<img class="post-img" src="images/post/<?php echo $row_rs_post['pPicture']; ?>" alt="">
<?php } ?>
				
				<!-- Content -->
				<div class="post-content">

					<h3><?php echo $row_rs_post['pTitle']; ?></h3>

					<ul class="post-meta">
						<li><?php echo date('Y 年 m 月 d 日',strtotime($row_rs_post['pStime'])); ?></li>
						<li><a href="#"><?php if($row_rs_showpost['pType'] == 0){ echo "消息";}
elseif($row_rs_showpost['pType'] == 1){ echo "募集";}
elseif($row_rs_showpost['pType'] == 2){ echo "活動";}
elseif($row_rs_showpost['pType'] == 3){ echo "系統";}
elseif($row_rs_showpost['pType'] == 4){ echo "綜合";} ?></a></li>
					</ul>

					<p><?php echo $row_rs_post['pContent']; ?></p>

					<?php 
	$URL='https://go.sshs.tc.edu.tw' . $_SERVER['REQUEST_URI'];
?>
					<!-- Share Buttons -->
					<ul class="share-buttons margin-top-40 margin-bottom-0">
                    <li><h3>我要分享</h3></li><br>
                    <li><div class="fb-like" data-href="<?php echo $URL;?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div></li>
						<li><a class="fb-share" href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"><i class="fa fa-facebook"></i> Facebook</a></li>
						<li><a class="twitter-share" href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));"><i class="fa fa-twitter"></i> Tweet</a></li>
						<li><a class="gplus-share" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><i class="fa fa-google-plus"></i> Google+</a></li>
						<li><span><script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
<script type="text/javascript">
new media_line_me.LineButton({"pc":true,"lang":"zh-hant","type":"a"});
</script></span></li>
					</ul>
                    
                   
                    
					<div class="clearfix"></div>

				</div>
			</div>
			<!-- Blog Post / End -->

   <?php
   
   $next = false; $prev = false;
	$colname_rs_npost = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_npost = $_GET['Id']+1;
}

$query_rs_npost = sprintf("SELECT pId,pTitle FROM post WHERE pId = %s", GetSQLValueString($Wandering,$colname_rs_npost, "int"));
$rs_npost = mysqli_query($Wandering, $query_rs_npost) or die(mysqli_error());
$row_rs_npost = mysqli_fetch_assoc($rs_npost);
$totalRows_rs_npost = mysqli_num_rows($rs_npost);

	$colname_rs_ppost = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_ppost = $_GET['Id']-1;
}

$query_rs_ppost = sprintf("SELECT pId,pTitle FROM post WHERE pId = %s", GetSQLValueString($Wandering,$colname_rs_ppost, "int"));
$rs_ppost = mysqli_query($Wandering, $query_rs_ppost) or die(mysqli_error());
$row_rs_ppost = mysqli_fetch_assoc($rs_ppost);
$totalRows_rs_ppost = mysqli_num_rows($rs_ppost);

if($row_rs_npost['pTitle'] != ""){ $next = true; };
if($row_rs_ppost['pTitle'] != ""){ $prev = true; };
?>

<?php if($next or $prev){ ?>
			<!-- Post Navigation -->
			<ul id="posts-nav" class="margin-top-0 margin-bottom-45">

					<?php if($next){ ?>
                    <li class="next-post">
					<a href="pages-blog-post.php?Id=<?php echo $row_rs_npost['pId']; ?>"><span>更新的貼文</span>
                     <?php echo $row_rs_npost['pTitle']; ?></a>
				</li>
                <?php } ?>
                
                <?php if($prev){ ?>
				<li class="prev-post">
					<a href="pages-blog-post.php?Id=<?php echo $row_rs_ppost['pId']; ?>"><span>更舊的貼文</span>
					<?php echo $row_rs_ppost['pTitle']; ?></a>
				</li>
                 <?php } ?>
			</ul>
<?php } ?>



			<div class="margin-top-30"></div>

			<!-- Reviews -->
			<section class="comments">
			<h4 class="headline margin-bottom-35">留言板</h4>

				 
    <div class="fb-comments" data-href="<?php echo $URL; ?>" data-numposts="7" data-width="100%"></div>

			</section>
			<div class="clearfix"></div>


	</div>
	<!-- Content / End -->



	<!-- Widgets -->
	<div class="col-lg-3 col-md-4">
		<div class="sidebar right">

			<!-- Widget -->
			<div class="widget">
				<h3 class="margin-top-40 margin-bottom-25">搜尋文章</h3>
				<div class="search-blog-input">
					<div class="input"><input class="search-field" type="text" placeholder="請輸入關鍵字" value=""/></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<!-- Widget / End -->


			<!-- Widget -->
			<div class="widget margin-top-40">
				<h3>您有任何問題嗎?</h3>
				<div class="info-box margin-bottom-10">
					<p>我們提供線上提問，歡迎您給與我們問題或意見，成為我們改善的最大動力。</p>
					<a href="https://goo.gl/forms/svGuOflKFoGzEcrP2" target="_blank" class="button fullwidth margin-top-20"><i class="fa fa-envelope-o"></i> 提問箱</a>
				</div
			<!-- Widget / End -->


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


</body>
</html>
<?php
mysqli_free_result($rs_post);
?>
