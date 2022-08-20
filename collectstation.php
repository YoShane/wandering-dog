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


$query_rs_collect = "SELECT * FROM collect WHERE cId = 1";
$rs_collect = mysqli_query($Wandering, $query_rs_collect) or die(mysqli_error());
$row_rs_collect = mysqli_fetch_assoc($rs_collect);
$totalRows_rs_collect = mysqli_num_rows($rs_collect);


$query_rs_send = "SELECT * FROM send ORDER BY sOrder ASC";
$rs_send = mysqli_query($Wandering, $query_rs_send) or die(mysqli_error());
$row_rs_send = mysqli_fetch_assoc($rs_send);
$totalRows_rs_send = mysqli_num_rows($rs_send);?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================== -->
<title>踏浪-捐贈物資</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<!-- CSS
================================================== -->
     
<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="fonts/flaticons/flaticon.css" type="text/css">
<link rel="stylesheet" href="css/materialize.min.css" type="text/css">
<link rel="stylesheet" href="css/materialize.css" type="text/css">

   <!-- Bootstrap Core CSS -->
      <link href="css/plus/1/bootstrap.css" rel="stylesheet" type="text/css">
	  
      <!-- Icon fonts -->
      <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


 <!-- Theme CSS -->
      <link href="css/plus/2/style.css" rel="stylesheet">
	  
	  <!-- Color Style CSS -->
      <link rel="stylesheet" href="css/colors/main.css" id="colors">
	 
	  
      <!-- Owl Slider & Prettyphoto -->
      <link rel="stylesheet" href="css/plus/1/owl.carousel.css">
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.10&appId=848279675320032";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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


<!-- Slider
================================================== -->
<?php if($totalRows_rs_pointalbum != 0){ ?>
<div class="listing-slider mfp-gallery-container margin-bottom-0">
	<?php do { ?>
	  <a href="./images/uploads/<?php echo $row_rs_pointalbum['pName']; ?>" data-background-image="./images/uploads/<?php echo $row_rs_pointalbum['pName']; ?>" class="item mfp-gallery" title="<?php echo $row_rs_pointalbum['pNote']; ?>"></a>
	  <?php } while ($row_rs_pointalbum = mysqli_fetch_assoc($rs_pointalbum)); ?>
</div>

<?php } ?>
<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
    <div class="col-lg-8 col-md-8 padding-right-30">
	
			<!-- Titlebar -->
            
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $row_rs_collect['cName']; ?><span class="listing-tag">物資集貨站</span></h2>
					<br><?php if($row_rs_collect['cIntroduction'] != ""){ ?><span>
						<p><?php echo $row_rs_collect['cIntroduction']; ?></p>
					</span><?php } ?>
				
				</div>
			</div>

<!-- Listing Nav -->
			<div id="listing-nav" class="listing-nav-container" style="margin-bottom:-100px;">
				<ul class="listing-nav">

					<li><a href="#listing-process"><i class="sl sl-icon-paper-plane"></i> 開始寄件</a></li>
					<li><a href="#listing-info"><i class="sl sl-icon-notebook"></i> 寄件資料</a></li>
                    <li><a href="#listing-traffic">位置資訊</a></li>
					<li><a href="#listing-message">留言版</a></li>
				</ul>
			</div>

    </div>
    <!-- Sidebar<?php 
	$URL='https://go.sshs.tc.edu.tw' . $_SERVER['REQUEST_URI'];
?>
		================================================== -->
		<div class="col-lg-4 col-md-4 margin-top-20 sticky">
			
			<!-- Contact -->
			<div class="boxed-widget">
				<h3><i class="sl sl-icon-pin"></i> 聯絡我們</h3>
				<ul class="listing-details-sidebar">
                <li><i class="fa fa-user"></i> <?php echo $row_rs_collect['cName'];?> <br>(負責人：<?= $row_rs_collect['cManagement'];?>)<li>
                    <li><i class="fa fa-map-marker"></i> <?php echo $row_rs_collect['cMap']; ?><li>
					<li><i class="fa fa-phone"></i> <?php if($row_rs_collect['cHphone'] != ""){ echo $row_rs_collect['cHphone']; } else { echo $row_rs_collect['cCphone']; } ?></li>
					<?php if($row_rs_collect['cEmail'] != ""){ ?><li><i class="fa fa-envelope-o"></i> <a href="#"><?php echo $row_rs_collect['cEmail']; ?></a></li><?php } ?>
				</ul>

				

				<!-- Reply to review popup -->
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div class="small-dialog-header">
						<h3>留言給我們</h3>
					</div>
					<div class="message-reply margin-top-0">
						 <div class="fb-comments" data-href="<?php echo $URL; ?>" data-numposts="7" data-width="100%"></div>
					</div>
				</div>

				<a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="fa fa-comments"></i>線上公開留言</a>
			</div>
			


		</div>
		<!-- Sidebar / End -->


            <!-- Section Adoption -->

    
    
   	<div id="listing-process" class="listing-section" style="margin-bottom:-40px;">

	  <div class="app-pages app-section">
		  <!-- Section Heading -->
          
		  <div class="theme-heading">
			<h2>開始寄件</h2>
			<div class="hr"></div>
		 </div>
	   
       
       	</div>
</div>


       	</div>
</div>
	<!-- Section Call to Action -->
	<section id="call-to-action" class="small-section" >
	   <div class="container text-center">
		  <div class="col-md-offset-5 col-md-7 col-sm-12">
			 <h2><font color="#FFFFFF">寄送前注意事項，請詳細閱讀</font></h2>
			 <p align="left"><?php echo $row_rs_collect['cInfo']; ?></p>
			
		  </div>
	   </div><!-- /container- -->
	</section>
	<!-- Section ends -->
    
  <div class="container">
	<div class="row sticky-wrapper">
    
    	<div id="listing-process" class="listing-section" >

	  <div class="app-pages app-section">
      
      
    <center><h3 class="headline margin-bottom-20">以下為寄貨流程</h3></center>
			<div class="style-1">

				<!-- Tabs Navigation -->
             
				<?php do { $countsend++;
				$sname[$countsend] = $row_rs_send['sName'];
				$scontent[$countsend] = $row_rs_send['sContent'];
				 } while ($row_rs_send = mysqli_fetch_assoc($rs_send)); ?>
                
			    <ul class="tabs-nav">
				    <li class="active"><a href="#tab1b"><h4><?php echo $sname[1];?></h4></a></li>
                    <?php for ($i=2 ; $i<=$countsend ; $i++) { ?>
						<li><a href="#tab<?php echo $i; ?>b"><h4><?php echo $sname[$i];?></h4></a></li>
						<?php } ?>
				 </ul>
				  
<!-- Tabs Content -->
				<div class="tabs-container">
                
                <?php for ($i=1 ; $i<=$countsend ; $i++) { ?>
					<div class="tab-content" id="tab<?php echo $i; ?>b">
						<?php echo $scontent[$i];?>
					</div>
              <?php } ?>
			
				</div>

			</div>

			 
        </div>

	</div>
    
    
    <script type="text/javascript">  

	function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

	</script> 


       	<div id="listing-info" class="listing-section" style="margin-bottom:-100px;">

	  <div class="app-pages app-section">
		  <!-- Section Heading -->
          
		  <div class="theme-heading">
			<h2>寄件資料</h2>
			<div class="hr"></div>
		 </div>
	   
       

				<div class="show-more">
					<div class="pricing-list-container">
						
						<!-- Food List -->
						<h4>收件人基本資料</h4>
						<ul>
							<li>
								<h5>收件人</h5>
								<h3 id="p1"><?php echo $row_rs_collect['cName']; ?></h3>
								<span><a href="###" class="button medium border" onclick="copyToClipboard('#p1')"><i class="sl sl-icon-docs"></i>Copy</a></span>
							</li>
                            
                         
                            <li style="background-color:#DFDFDF;">
								<h5>收件地址 <a href="###" class="button medium border" onclick="copyToClipboard('#p2')" id="contect" style="display:none;"><i class="sl sl-icon-docs"></i>Copy</a></h5>
								<h3 id="p2"><?php echo $row_rs_collect['cMap']; ?></h3>
                                
                <span  id="content2" style="display:none;"> <a href="###" class="button medium border" onclick="copyToClipboard('#p2')"><i class="sl sl-icon-docs"></i>Copy</a></span>                
								
							</li>
                            
                               <script type="text/javascript">
							if(document.body.clientWidth < 500)
						{	 document.getElementById('contect').style.display=""; } else {
						 document.getElementById('content2').style.display="";	
						}
									</script>
                                    
							<li>
								<h5>收件人電話(宅)</h5>
								<h3 id="p3"><?php echo $row_rs_collect['cHphone']; ?></h3>
								<span><a href="###" class="button medium border" onclick="copyToClipboard('#p3')"><i class="sl sl-icon-docs"></i>Copy</a></span>
							</li>
                            <?php if($row_rs_collect['cCphone']!=""){?>
							<li style="background-color:#DFDFDF;">
								<h5>收件人電話(行動)</h5>
								<h3 id="p4"><?php echo $row_rs_collect['cCphone']; ?></h3>
								<span><a href="###" class="button medium border" onclick="copyToClipboard('#p4')"><i class="sl sl-icon-docs"></i>Copy</a></span>
							</li><?php } ?>
                            <li>
								<h5>方便取貨時段</h5>
								<h3>不限制</h3>
								
							</li>
							
						</ul>



					</div>
				</div>
				<a href="#" class="show-more-button" data-more-title="按我展開列表" data-less-title="按我縮回列表"><i class="fa fa-angle-down"></i></a>

			 
        </div>

	</div>
  
    <!-- Location -->
			<div id="listing-traffic" class="listing-section" style="margin-bottom:-100px;">
            <div class="app-pages app-section">
				 <div class="theme-heading">
			<h2>位置資訊</h2>
			<div class="hr"></div>
		 </div>

				<div id="singleListingMap-container">
					<div id="singleListingMap" data-latitude="<?php echo $row_rs_collect['cMaplat']; ?>" data-longitude="<?php echo $row_rs_collect['cMaplong']; ?>" data-map-icon="im im-icon-Box-Open"></div>
					<a href="#" id="streetView">街景服務</a>
				</div>
                <br>
                 <p align="center"><a href="https://maps.google.com/maps?q=<?php echo $row_rs_collect['cMaplat']; ?>,<?php echo $row_rs_collect['cMaplong']; ?>" target="_blank" class="button medium border" style="text-decoration: none;"><i class="sl sl-icon-map"></i>啟動地圖/應用程式</a></p>
                 
			</div>
            </div>
            
    
    <div id="listing-message" class="listing-section" style="margin-bottom:-100px;">
	<div class="app-pages app-section">
			 <div class="theme-heading">
			<h2>留言板</h2>
			<div class="hr"></div>
		 </div>
    
    <div class="fb-comments" data-href="<?php echo $URL; ?>" data-numposts="7" data-width="100%"></div>
    
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
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA2wXCdtQOx7tzeBDSea5K7zOQiccpzH8Q"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=zh-TW"></script>
<script type="text/javascript" src="scripts/maps.js"></script>



	<!-- Owl Carousel -->
	<script src="scripts/plus/1/owl.carousel.min.js"></script>


<script src="scripts/plus/1/main.js"></script>


<!-- Style Switcher -->

</body>
</html>
<?php
mysqli_free_result($rs_collect);

mysqli_free_result($rs_send);

mysqli_free_result($rs_dogpoint);

mysqli_free_result($rs_need);

mysqli_free_result($rs_others);

mysqli_free_result($rs_faq);

mysqli_free_result($rs_pointalbum);

mysqli_free_result($rs_showrepdog);

mysqli_free_result($rs_showrepdog2);
?>
