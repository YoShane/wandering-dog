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


$query_rs_about = "SELECT * FROM aboutus WHERE aId = 1";
$rs_about = mysqli_query($Wandering, $query_rs_about) or die(mysqli_error());
$row_rs_about = mysqli_fetch_assoc($rs_about);
$totalRows_rs_about = mysqli_num_rows($rs_about);


$query_rs_operating = "SELECT * FROM operating WHERE oId = 1";
$rs_operating = mysqli_query($Wandering, $query_rs_operating) or die(mysqli_error());
$row_rs_operating = mysqli_fetch_assoc($rs_operating);
$totalRows_rs_operating = mysqli_num_rows($rs_operating);


$query_rs_ourteam = "SELECT * FROM ourteam";
$rs_ourteam = mysqli_query($Wandering, $query_rs_ourteam) or die(mysqli_error());
$row_rs_ourteam = mysqli_fetch_assoc($rs_ourteam);
$totalRows_rs_ourteam = mysqli_num_rows($rs_ourteam);


$query_rs_webfaq = "SELECT * FROM webfaq";
$rs_webfaq = mysqli_query($Wandering, $query_rs_webfaq) or die(mysqli_error());
$row_rs_webfaq = mysqli_fetch_assoc($rs_webfaq);
$totalRows_rs_webfaq = mysqli_num_rows($rs_webfaq);
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
	  

      <!-- old css -->
      
<link rel="stylesheet" href="css/style.css">



 <!-- Bootstrap Core CSS -->
      <link href="css/plus/2/bootstrap.css" rel="stylesheet" type="text/css">
	  
      <!-- Icon fonts -->
      <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="fonts/flaticons/flaticon.css" rel="stylesheet" type="text/css">


      <!-- Css Animations -->
      <link href="css/plus/2/animate.css" rel="stylesheet" />
	  
      <!-- Theme CSS -->
      <link href="css/plus/2/style.css" rel="stylesheet">
	  
      
       <!-- Color Style CSS -->
      <link rel="stylesheet" href="css/colors/main.css" id="colors">
	  
      <!-- Owl Slider & Prettyphoto -->
      <link rel="stylesheet" href="css/plus/2/owl.carousel.css">

     
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


						<li><a href="dogpoint-grid-full-width.php">狗場列表</a></li>


						<li><a href="gallery.php">相簿</a></li>
						<li><a href="https://docs.google.com/spreadsheets/d/1PeD9CopZ9D_x5UciLy9zcL-15LOGdsWkiD9MQCAyXyE/edit?usp=sharing" target="_blank">芳名錄</a></li>
                        
                        <li><a class="current" href="about.php">網站說明</a></li>
						
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
										<input name="username" type="text" required="required" class="input-text" id="username" value="" />
									</label>
								</p>

								<p class="form-row form-row-wide">
									<label for="password">密碼:
										<i class="im im-icon-Lock-2"></i>
										<input name="password" type="password" required="required" class="input-text" pattern="(?=.*\d)(?=.*[a-zA-Z]).{6,}" title="請輸入英數混和，6字元以上的密碼" id="password"/>
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

	  <div class="container margin-bottom-100" >
     
	
<div class="row">

    <!-- Section About -->	
	<section id="about" class="home-section" style="line-height: 1.42857143;">
    
	   <div class="col-lg-8 col-lg-offset-2">
	
	   </div>
		  <div class="col-md-12 col-sm-12 col-centered"  style="padding-top:50px;">
			 <div class="centered-pills">
				<!-- Navigation -->
				<ul class="nav nav-pills">
				   <li class="active"><a href="#pane1" data-toggle="tab">關於我們</a></li>
				   <li><a href="#pane2" data-toggle="tab">網站操作</a></li>
                   <?php if($totalRows_rs_ourteam > 0){ ?>
				   <li><a href="#pane3" data-toggle="tab">我們的團隊</a></li>
                   <?php } ?>
				</ul>
			 </div>
		  </div>
		 
		  <!-- Panels start -->	
		  <div class="tabbable">
			 <div class="tab-content">
				<!-- Panel  1 -->
				<div id="pane1" class="paneltab tab-pane fade active in">
				   <div class="row">
					  <div class="col-md-12 col-sm-12">
                      
                      <?php if($row_rs_about['aVideo'] != ""){ ?>
						 <div class="col-lg-7 col-md-6 col-sm-12 res-margin wow fadeInRight" data-wow-delay="0.2s">
							<h2><?php echo $row_rs_about['aTitle']; ?></h2>
							<p><?php echo $row_rs_about['aContent']; ?></p>
						 </div>					 
					
                          <div class="col-lg-5 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0.2s">
				   	<!-- Responsive video -->
					  <div class="embed-responsive embed-responsive-16by9">
						 <iframe class="embed-responsive-item" src="<?php echo $row_rs_about['aVideo']; ?>"></iframe>
					  </div>
				   </div>
                   
                   <?php } elseif($row_rs_about['aAboutpicture'] != "") { ?>
                   
                   <div class="col-lg-7 col-md-6 col-sm-12 res-margin wow fadeInRight" data-wow-delay="0.2s">
							<h2><?php echo $row_rs_about['aTitle']; ?></h2>
							<p><?php echo $row_rs_about['aContent']; ?></p>
						 </div>					 
					
                          <div class="col-lg-5 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0.2s">
				   	<!-- Responsive video -->
					  <div class="embed-responsive embed-responsive-16by9">
					    <img src="images/<?php echo $row_rs_about['aAboutpicture'];?>" alt=""/> </div>
				   </div>
                   
                   <?php } else { ?>
                  <div class="wow fadeInRight" data-wow-delay="0.2s">
							<center><h2><?php echo $row_rs_about['aTitle']; ?></h2></center>
							<p><?php echo $row_rs_about['aContent']; ?></p>
</div>	
                   <?php } ?>
					  </div>
					  <!-- icons -->
					  <div class="col-xs-12 col-md-4 col-lg-4">
						 <div class="box">
							<div class="icon">
							   <div class="image"><span class="<?php echo $row_rs_about['aBpicture1']; ?>"></span></div>
							   <h3><?php echo $row_rs_about['aBtitle1']; ?></h3>
							   <p><?php echo $row_rs_about['aBcontent1']; ?></p>
							</div>
						 </div>
					  </div>
					  <div class="col-xs-12 col-md-4 col-lg-4">
						 <div class="box">
							<div class="icon">
							   <div class="image"><span class="<?php echo $row_rs_about['aBpicture2']; ?>"></span></div>
							   <h3><?php echo $row_rs_about['aBtitle2']; ?></h3>
							   <p><?php echo $row_rs_about['aBcontent2']; ?></p>
							</div>
						 </div>
					  </div>
					  <div class="col-xs-12 col-md-4 col-lg-4">
						 <div class="box">
							<div class="icon">
							   <div class="image"><span class="<?php echo $row_rs_about['aBpicture3']; ?>"></span></div>
							   <h3><?php echo $row_rs_about['aBtitle3']; ?></h3>
							   <p><?php echo $row_rs_about['aBcontent3']; ?></p>
							</div>
						 </div>
					  </div>
				   </div>
				 </div> 
				<!-- Panel 1 ends -->
				
				<!-- Panel 2 -->
				<div id="pane2" class="paneltab tab-pane fade">
				  <div class="row">
				   <div class="col-lg-6 col-md-6 col-sm-12 res-margin">
					  <h3><?php echo $row_rs_operating['oTitle']; ?></h3>
					  <p><?php echo $row_rs_operating['oContent']; ?></p>
				   </div>
				   <div class="col-lg-6 col-md-6 col-sm-12">
				   	<!-- Responsive video -->
				     <div class="embed-responsive embed-responsive-16by9">
                      <?php if($row_rs_operating['oVideo'] != ""){ ?>
					   <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/deN3nt3Sdhc"></iframe><?php }else{ ?>
                        <img src="images/<?php echo $row_rs_operating['oUipicture']; ?>" alt=""/>
<?php } ?>
					  </div>
				   </div>
				  </div>
				</div><!-- / Panel 2 ends -->
				
                
                <?php if($totalRows_rs_ourteam > 0){ ?>
				<!-- Panel  3 -->
				<div id="pane3" class="paneltab tab-pane fade text-center">
								 <div class="row">
				   <h3>我們的團隊</h3>
				   <!-- Item 1 -->
				   <div class="team">
                   
                   
					  <?php do { ?>
			          <div class="col-md-3 col-sm-6">
					      <div class="img-wrapper">
					        <img src="images/team/<?php echo $row_rs_ourteam['oPicture']; ?>" alt="" class="img-responsive"/>
				          </div>
					      <!-- Caption -->
					      <div class="caption-team">
					        <h5><?php echo $row_rs_ourteam['oName']; ?></h5>
					        <span><?php echo $row_rs_ourteam['oWork']; ?></span>
					        <p><?php echo $row_rs_ourteam['oWorkcontent']; ?></p><br>
				          </div>
			           </div>
					    <?php } while ($row_rs_ourteam = mysqli_fetch_assoc($rs_ourteam)); ?>
                      
                      

				   </div><!-- /container-->
			   </div><!-- /panel 3 ends -->
			   </div><!-- /panel 3 ends -->
               <?php } ?>
			</div><!-- /.tab-content -->
		  </div><!-- /.tabbable -->
	   </div><!-- /container-->
	</section>
	<!-- Section ends-->
	  
   		<!-- Accordions -->
	 
	<!-- Section Heading -->
   	
	
				<!-- Accordions -->
	 <div class="col-md-12">


		  <div class="theme-heading" >
			 <h2>網站問與答</h2>
			 <div class="hr"></div>
		  </div>
	  
      
		<div class="style-2">
				<div class="accordion">

					<?php do { ?>
				    <h3><span class="ui-accordion-header-icon ui-icon ui-accordion-icon"></span><i class="sl sl-icon-tag"></i> <?php echo $row_rs_webfaq['wQuestion']; ?></h3>
					  <div>
					    <p><?php echo $row_rs_webfaq['wAnswer']; ?></p>
				      </div>
					  <?php } while ($row_rs_webfaq = mysqli_fetch_assoc($rs_webfaq)); ?>

					
				</div>
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


	<!-- Core JavaScript Files -->

	<script src="scripts/plus/2/bootstrap.min.js"></script>

<!-- WOW animations -->
	<script src="scripts/plus/2/wow.min.js"></script>
    


	  
      <!-- Style Switcher -->
   </body>
</html>
<?php
mysqli_free_result($rs_about);

mysqli_free_result($rs_ourteam);

mysqli_free_result($rs_webfaq);
?>
