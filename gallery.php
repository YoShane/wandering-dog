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



$query_rs_listtop = "SELECT * FROM listgallery WHERE lOrder < 50 ORDER BY lOrder ASC";
$rs_listtop = mysqli_query($Wandering, $query_rs_listtop) or die(mysqli_error());
$row_rs_listtop = mysqli_fetch_assoc($rs_listtop);
$totalRows_rs_listtop = mysqli_num_rows($rs_listtop);


$query_rs_listdown = "SELECT * FROM listgallery WHERE lOrder >= 50 ORDER BY lOrder ASC";
$rs_listdown = mysqli_query($Wandering, $query_rs_listdown) or die(mysqli_error());
$row_rs_listdown = mysqli_fetch_assoc($rs_listdown);
$totalRows_rs_listdown = mysqli_num_rows($rs_listdown);


$query_rs_doggallery = "SELECT dId, dName, dPicture FROM dogpoint ORDER BY dHavedog DESC";
$rs_doggallery = mysqli_query($Wandering, $query_rs_doggallery) or die(mysqli_error());
$row_rs_doggallery = mysqli_fetch_assoc($rs_doggallery);
$totalRows_rs_doggallery = mysqli_num_rows($rs_doggallery);




$query_rs_listtop2 = "SELECT * FROM listgallery WHERE lOrder < 50 ORDER BY lOrder ASC";
$rs_listtop2 = mysqli_query($Wandering, $query_rs_listtop2) or die(mysqli_error());
$row_rs_listtop2 = mysqli_fetch_assoc($rs_listtop2);
$totalRows_rs_listtop2 = mysqli_num_rows($rs_listtop2);


$query_rs_listdown2 = "SELECT * FROM listgallery WHERE lOrder >= 50 ORDER BY lOrder ASC";
$rs_listdown2 = mysqli_query($Wandering, $query_rs_listdown2) or die(mysqli_error());
$row_rs_listdown2 = mysqli_fetch_assoc($rs_listdown2);
$totalRows_rs_listdown2 = mysqli_num_rows($rs_listdown2);


$query_rs_doggallery2 = "SELECT dId, dName, dPicture FROM dogpoint ORDER BY dHavedog DESC";
$rs_doggallery2 = mysqli_query($Wandering, $query_rs_doggallery2) or die(mysqli_error());
$row_rs_doggallery2 = mysqli_fetch_assoc($rs_doggallery2);
$totalRows_rs_doggallery2 = mysqli_num_rows($rs_doggallery2);


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
      
<link rel="stylesheet" href="css/style2.css">



 <!-- Bootstrap Core CSS -->
      <link href="css/plus/2/bootstrap.css" rel="stylesheet" type="text/css">
	  
      <!-- Icon fonts -->
      <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="fonts/flaticons/flaticon.css" rel="stylesheet" type="text/css">

	  
        <!-- Css Animations -->
      <link href="css/plus/2/animate.css" rel="stylesheet" />
	  
      <!-- Theme CSS -->
      <link href="css/plus/2/style.css" rel="stylesheet">
	  

	  
      <!-- Prettyphoto -->

      <link rel="stylesheet" href="css/prettyPhoto.css">
	  
      
       <!-- Color Style CSS -->
      <link rel="stylesheet" href="css/colors/main.css" id="colors">

    
    <script type="text/javascript" src="scripts/lazyload/lazyload.min.js"></script>
<script type="text/javascript" src="scripts/lazyload/lazyload.js"></script>

   </head> 
   

<body>   
	

    
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

						<li><a class="current" href="gallery.php">相簿</a></li>
                        
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

	  <script type="text/javascript" >
 lazyload();
</script>
   	<!-- Section Gallery -->
	<section id="gallery" class="home-section">
	  <div class="col-lg-8 col-lg-offset-2">
	   	<!-- Section Heading -->	
		  <div class="theme-heading">
			 <h2>相簿圖廊</h2>
			 <div class="hr"></div>
		  </div>
	   </div>
       
      
	   <div class="container wow fadeInDown" data-wow-delay="0.2s">
		  <div class="nav-gallery col-md-12">
			 <!-- Navigation -->
				<ul class="list-inline nav type cat">
				   <li class="active"><a href="#" data-filter="*">全部分類</a></li>
				   <?php if($totalRows_rs_listtop != 0){ do { ?>
	              <li><a href="#" data-filter=".<?php echo $row_rs_listtop['lName']; ?>"><?php echo $row_rs_listtop['lName']; ?></a></li>
				     <?php } while ($row_rs_listtop = mysqli_fetch_assoc($rs_listtop)); } ?>
		           <?php if($totalRows_rs_doggallery != 0){ do { ?>
	              <li><a href="#" data-filter=".<?php echo $row_rs_doggallery['dName']; ?>"><?php echo $row_rs_doggallery['dName']; ?></a></li>
				       <?php } while ($row_rs_doggallery = mysqli_fetch_assoc($rs_doggallery)); }?>
                   <?php if($totalRows_rs_listdown != 0){ do { ?>
                  <li><a href="#" data-filter=".<?php echo $row_rs_listdown['lName']; ?>"><?php echo $row_rs_listdown['lName']; ?></a></li>
                         <?php } while ($row_rs_listdown = mysqli_fetch_assoc($rs_listdown)); }?>
                   
				</ul>
		   </div>
		  <!-- Gallery -->
		  <div class="row">
			<div class="col-md-12">
			 <div id="lightbox">			 
			    <!-- Image -->
                

				<?php if($totalRows_rs_listtop2 != 0){  do { 
				
				
$query_rs_photo = sprintf("SELECT * FROM galleryphoto WHERE gLid = %s AND gMode = 1", GetSQLValueString($Wandering,$row_rs_listtop2['lId'], "int"));
$rs_photo = mysqli_query($Wandering, $query_rs_photo) or die(mysqli_error());
$row_rs_photo = mysqli_fetch_assoc($rs_photo);
$totalRows_rs_photo = mysqli_num_rows($rs_photo);  ?>
                                                 
                <?php if($totalRows_rs_photo != 0){  do {  ?>                        
				  <div class="col-sm-6 col-md-6 col-lg-4 <?php echo $row_rs_listtop2['lName']; ?>">
				    <div class="portfolio-item">
				      <div class="gallery-thumb"> <img class="img-responsive lazyload" src="images/gallery/<?php echo $row_rs_photo['gName']; ?>" alt=""> <span class="overlay-mask"></span> <a href="images/gallery/<?php echo $row_rs_photo['gName']; ?>" data-rel="prettyPhoto[gallery]" class="link centered" title="<?php echo $row_rs_photo['gNote']; ?>"> <i class="fa fa-expand"></i></a> </div>
			        </div>
			    </div>
                <?php } while ($row_rs_photo = mysqli_fetch_assoc($rs_photo)); }?>
                
				  <?php mysqli_free_result($rs_photo); } while ($row_rs_listtop2 = mysqli_fetch_assoc($rs_listtop2)); }?>
                
                
                
                

<?php if($totalRows_rs_doggallery2 != 0){  do {  
				
				
							
$query_rs_photo = sprintf("SELECT * FROM pointalbum WHERE pLdid = %s", GetSQLValueString($Wandering,$row_rs_doggallery2['dId'], "int"));
$rs_photo = mysqli_query($Wandering, $query_rs_photo) or die(mysqli_error());
$row_rs_photo = mysqli_fetch_assoc($rs_photo);
$totalRows_rs_photo = mysqli_num_rows($rs_photo);  	 ?>
                                                 
                <?php if($totalRows_rs_photo != 0){  do {  ?>                        
				  <div class="col-sm-6 col-md-6 col-lg-4 <?php echo $row_rs_doggallery2['dName']; ?>">
				    <div class="portfolio-item">
				      <div class="gallery-thumb"> <img class="img-responsive lazyload" src="images/uploads/<?php echo $row_rs_photo['pName']; ?>" alt=""> <span class="overlay-mask"></span> <a href="images/uploads/<?php echo $row_rs_photo['pName']; ?>" data-rel="prettyPhoto[gallery]" class="link centered" title="<?php echo $row_rs_photo['pNote']; ?>"> <i class="fa fa-expand"></i></a> </div>
			        </div>
			    </div>
                <?php } while ($row_rs_photo = mysqli_fetch_assoc($rs_photo)); } ?>
                
                
				<?php    
				mysqli_free_result($rs_photo);
				
$query_rs_photo = sprintf("SELECT * FROM galleryphoto WHERE gLid = %s AND gMode = 0", GetSQLValueString($Wandering,$row_rs_doggallery2['dId'], "int"));
$rs_photo = mysqli_query($Wandering, $query_rs_photo) or die(mysqli_error());
$row_rs_photo = mysqli_fetch_assoc($rs_photo);
$totalRows_rs_photo = mysqli_num_rows($rs_photo);  ?>
                                                 
                <?php if($totalRows_rs_photo != 0){  do {  ?>                        
				  <div class="col-sm-6 col-md-6 col-lg-4 <?php echo $row_rs_doggallery2['dName']; ?>">
				    <div class="portfolio-item">
				      <div class="gallery-thumb"> <img class="img-responsive lazyload" src="images/gallery/<?php echo $row_rs_photo['gName']; ?>" alt=""> <span class="overlay-mask"></span> <a href="images/gallery/<?php echo $row_rs_photo['gName']; ?>" data-rel="prettyPhoto[gallery]" class="link centered" title="<?php echo $row_rs_photo['gNote']; ?>"> <i class="fa fa-expand"></i></a> </div>
			        </div>
			    </div>
                <?php } while ($row_rs_photo = mysqli_fetch_assoc($rs_photo)); }?>
                
				  <?php mysqli_free_result($rs_photo);   } while ($row_rs_doggallery2 = mysqli_fetch_assoc($rs_doggallery2)); } ?>
                  
                  



<?php if($totalRows_rs_listdown2 != 0){  do { 
				
				
$query_rs_photo = sprintf("SELECT * FROM galleryphoto WHERE gLid = %s AND gMode = 1", GetSQLValueString($Wandering,$row_rs_listdown2['lId'], "int"));
$rs_photo = mysqli_query($Wandering, $query_rs_photo) or die(mysqli_error());
$row_rs_photo = mysqli_fetch_assoc($rs_photo);
$totalRows_rs_photo = mysqli_num_rows($rs_photo);  ?>
                                                 
                <?php if($totalRows_rs_photo != 0){  do {  ?>                        
				  <div class="col-sm-6 col-md-6 col-lg-4 <?php echo $row_rs_listdown2['lName']; ?>">
				    <div class="portfolio-item">
				      <div class="gallery-thumb"> <img class="img-responsive lazyload" src="images/gallery/<?php echo $row_rs_photo['gName']; ?>" alt=""> <span class="overlay-mask"></span> <a href="images/gallery/<?php echo $row_rs_photo['gName']; ?>" data-rel="prettyPhoto[gallery]" class="link centered" title="<?php echo $row_rs_photo['gNote']; ?>"> <i class="fa fa-expand"></i></a> </div>
			        </div>
			    </div>
                <?php } while ($row_rs_photo = mysqli_fetch_assoc($rs_photo)); }?>
                
				  <?php mysqli_free_result($rs_photo); } while ($row_rs_listdown2 = mysqli_fetch_assoc($rs_listdown2)); }?>

			 </div><!-- /lightbox-->
		   </div><!-- /col-md-12-->
		 </div><!-- /row -->
	   </div><!-- /container -->
	</section>
	<!-- Section ends --> 



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


<script src="scripts/switcher.js"></script>

	<script src="scripts/plus/3/main.js"></script>


	<!-- WOW animations -->
	<script src="scripts/plus/3/wow.min.js"></script>

	<!-- Prettyphoto Lightbox -->
	<script src="scripts/jquery.prettyPhoto.js"></script>



	<!-- Isotope -->	  
	<script src="scripts/plus/3/jquery.isotope.js"></script>
	
	  
      <!-- Style Switcher
================================================== -->



<!-- Style Switcher / End -->

   </body>
</html>
<?php
mysqli_free_result($rs_listtop);

mysqli_free_result($rs_doggallery);

mysqli_free_result($rs_listdown);

mysqli_free_result($rs_listtop2);

mysqli_free_result($rs_doggallery2);

mysqli_free_result($rs_listdown2);
?>
