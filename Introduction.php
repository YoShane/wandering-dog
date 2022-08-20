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

$colname_rs_dogpoint = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_dogpoint = $_GET['Id'];
}

$query_rs_dogpoint = sprintf("SELECT * FROM dogpoint WHERE dId = %s", GetSQLValueString($Wandering,$colname_rs_dogpoint, "int"));
$rs_dogpoint = mysqli_query($Wandering, $query_rs_dogpoint) or die(mysqli_error());
$row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint);
$totalRows_rs_dogpoint = mysqli_num_rows($rs_dogpoint);

 if ($totalRows_rs_dogpoint == 0) {
	  $needGoTo = "dogpoint-grid-full-width.php";
  header(sprintf("Location: %s", $needGoTo));}
  
$colname_rs_need = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_need = $_GET['Id'];
}

$query_rs_need = sprintf("SELECT DISTINCT nLtid, nRemarks FROM dogneed WHERE nLdid = %s AND nLtid>1 ORDER BY nLtid ASC", GetSQLValueString($Wandering,$colname_rs_need, "int"));
$rs_need = mysqli_query($Wandering, $query_rs_need) or die(mysqli_error());
$row_rs_need = mysqli_fetch_assoc($rs_need);
$totalRows_rs_need = mysqli_num_rows($rs_need);

$colname_rs_others = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_others = $_GET['Id'];
}

$query_rs_others = sprintf("SELECT nLdid, nName, nRemarks FROM dogneed WHERE nLdid = %s AND nLtid=1", GetSQLValueString($Wandering,$colname_rs_others, "int"));
$rs_others = mysqli_query($Wandering, $query_rs_others) or die(mysqli_error());
$row_rs_others = mysqli_fetch_assoc($rs_others);
$totalRows_rs_others = mysqli_num_rows($rs_others);

$colname_rs_faq = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_faq = $_GET['Id'];
}

$query_rs_faq = sprintf("SELECT * FROM faq WHERE fLdid = %s", GetSQLValueString($Wandering,$colname_rs_faq, "int"));
$rs_faq = mysqli_query($Wandering, $query_rs_faq) or die(mysqli_error());
$row_rs_faq = mysqli_fetch_assoc($rs_faq);
$totalRows_rs_faq = mysqli_num_rows($rs_faq);

$colname_rs_pointalbum = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_pointalbum = $_GET['Id'];
}

$query_rs_pointalbum = sprintf("SELECT * FROM pointalbum WHERE pLdid = %s ORDER BY pId DESC", GetSQLValueString($Wandering,$colname_rs_pointalbum, "int"));
$rs_pointalbum = mysqli_query($Wandering, $query_rs_pointalbum) or die(mysqli_error());
$row_rs_pointalbum = mysqli_fetch_assoc($rs_pointalbum);
$totalRows_rs_pointalbum = mysqli_num_rows($rs_pointalbum);

$colname_rs_showrepdog = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_showrepdog = $_GET['Id'];
}

$query_rs_showrepdog = sprintf("SELECT rId, rName, rPicture, rGender, rAge FROM repdog WHERE rLdid = %s ORDER BY rOrder ASC", GetSQLValueString($Wandering,$colname_rs_showrepdog, "int"));
$rs_showrepdog = mysqli_query($Wandering, $query_rs_showrepdog) or die(mysqli_error());
$row_rs_showrepdog = mysqli_fetch_assoc($rs_showrepdog);
$totalRows_rs_showrepdog = mysqli_num_rows($rs_showrepdog);


$colname_rs_showrepdog2 = "-1";
if (isset($_GET['Id'])) {
  $colname_rs_showrepdog2 = $_GET['Id'];
}

$query_rs_showrepdog2 = sprintf("SELECT rId, rName, rPicture, rIntroduction FROM repdog WHERE rLdid = %s ORDER BY rOrder ASC", GetSQLValueString($Wandering,$colname_rs_showrepdog2, "int"));
$rs_showrepdog2 = mysqli_query($Wandering, $query_rs_showrepdog2) or die(mysqli_error());
$row_rs_showrepdog2 = mysqli_fetch_assoc($rs_showrepdog2);
$totalRows_rs_showrepdog2 = mysqli_num_rows($rs_showrepdog2);

?>
<!DOCTYPE html> 
<html  lang="zh-TW">
<head>

<!-- Basic Page Needs
================================================= -->
<title>踏浪-<?php echo $row_rs_dogpoint['dName']; ?></title>
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
      <link href="css/plus/1/style.css" rel="stylesheet">
	  
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

						<li><a class="current" href="index.php">首頁</a></li>

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
	
			<!-- Titlebar -->
            
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $row_rs_dogpoint['dName']; ?><span class="listing-tag">愛心狗場</span></h2>
					<span>
						<a href="<?php if($row_rs_dogpoint['dMap'] != ""){ echo "https://www.google.com.tw/maps?q=" . $row_rs_dogpoint['dMap']; }else{	echo "#";} ?>">
							<i class="fa fa-map-marker"></i>
							<?php if($row_rs_dogpoint['dMap'] != ""){ echo $row_rs_dogpoint['dMap']; }else{
								echo "地點不公開";} ?>
						</a>
					</span>
				
				</div>
			</div>

			<!-- Listing Nav -->
			<div id="listing-nav" class="listing-nav-container" style="margin-bottom:-100px;">
				<ul class="listing-nav">
					<li><a href="#listing-overview" class="active">狗場簡介</a></li>
					<li><a href="#listing-need">狗場需求</a></li>
                    <?php if($totalRows_rs_faq != 0){ ?>
					<li><a href="#listing-qa">狗場問與答</a></li>
                    <?php } ?>
                    <?php if($totalRows_rs_showrepdog != 0){ ?>
                    <li><a href="#listing-delegate">代表狗狗</a></li>
                    <?php } ?>
					<li><a href="#listing-message">留言版</a></li>
				</ul>
			</div>
			
            
            <!-- Section Adoption -->
	<div id="listing-overview" class="listing-section" style="margin-bottom:-100px;">
	  
	  <div class="app-pages app-section">
		  <!-- Section Heading -->
          
		  <div class="theme-heading">
			<h2>狗場簡介</h2>
			<div class="hr"></div>
		 </div>
	   

		  <div class="row wow fadeInDown" data-wow-delay="0.2s">
		  <?php echo $row_rs_dogpoint['dIntroduction']; ?>
		 </div><!--/row-->
			 
        </div>

	</div>
    
    
    
    <div id="listing-need" class="listing-section" style="margin-bottom:-100px;">
        <div class="app-pages app-section">
				<!-- Amenities -->
		  <div class="theme-heading">
			<h2>狗場需求</h2>
			<div class="hr"></div>
		 </div>
				
				  <ul class="listing-features checkboxes margin-top-0">
                  
                 
                  
                  <?php do { 
                 
                  $colname_rs_needname = $row_rs_need['nLtid'];


$query_rs_needname = sprintf("SELECT tId,tName FROM thingstable WHERE tId = %s", GetSQLValueString($Wandering,$colname_rs_needname, "int"));
$rs_needname = mysqli_query($Wandering, $query_rs_needname) or die(mysqli_error());
$row_rs_needname = mysqli_fetch_assoc($rs_needname);
$totalRows_rs_needname = mysqli_num_rows($rs_needname); 

if ($totalRows_rs_needname == 0) {
	break;}

?>
				    <li><?php echo $row_rs_needname['tName']; ?>
                    <?php if($row_rs_need['nRemarks']!=""){ ?>
                    (<?php echo $row_rs_need['nRemarks'];?>)
                    <?php } ?></li>
                   
                     
				    <?php mysqli_free_result($rs_needname);/*輸出基本*/ } while ($row_rs_need = mysqli_fetch_assoc($rs_need)); ?>
<?php do { ?>
                    
                     <?php if($totalRows_rs_others != 0){ ?>
                     
                     <li><?php echo $row_rs_others['nName']; ?>
                    <?php if($row_rs_others['nRemarks']!=""){ ?>
                    (<?php echo $row_rs_others['nRemarks'];?>)
                    <?php } ?></li>
                           
                   <?php } ?>
                   
                      <?php } while ($row_rs_others = mysqli_fetch_assoc($rs_others)); ?>
                  
                   

                     </ul>
				  
        </div>
	 </div>
	
    
    <?php if($totalRows_rs_faq != 0){ ?>
  <div id="listing-qa" class="listing-section" style="margin-bottom:-100px;">


	<!-- 內容區塊 -->
	<div class="faq app-pages app-section">
	
			 <div class="theme-heading">
			<h2>狗場問與答</h2>
			<div class="hr"></div>
		 </div>
			<div class="entry">
            
            
            			<!-- Toggles Container -->
			<div class="style-2">
				<div class="accordion">

<?php if($totalRows_rs_faq != 0){ ?>
					<?php do { ?>
					<h3><span class="ui-accordion-header-icon ui-icon ui-accordion-icon"></span><i class="sl sl-icon-tag"></i><?php echo $row_rs_faq['fQuestion']; ?></h3>
					<div>
						<p><?php echo $row_rs_faq['fAnswer']; ?></p>
					</div>

					<?php } while ($row_rs_faq = mysqli_fetch_assoc($rs_faq)); ?>
                    
                    <?php }else{ ?>
                    
                    <h3><span class="ui-accordion-header-icon ui-icon ui-accordion-icon"></span><i class="sl sl-icon-plus"></i>尚未新增任何問答</h3>
					<div>
						<p>本狗場尚未更新問答，敬請期待!</p>
					</div>
                    
                     <?php } ?>

				</div>
			</div>

			<!-- Toggles Container / End -->
            

			</div>
  
	</div>	
		 
	 </div>
	<!-- ends -->
    <?php } ?>
    
    <?php if($totalRows_rs_showrepdog != 0){ ?>
     <div id="listing-delegate" class="listing-section" style="margin-bottom:-200px;">
	
			   
   <!-- Section Adoption -->
	<section id="adoption" class="home-section" style="line-height: 1.42857143;">
	   
        <div class="theme-heading">
			<h2>代表狗狗</h2>
			<div class="hr"></div>
		 </div>
    
       
       
	   <div class="container">

			 
			 <div class="row">
		<!-- Adopt a pet -->

			  				 				   
				   <div id="owl-adopt" class="owl-carousel owl-theme">
					  
                      <?php do { ?>
                      <!-- Animal -->
                       <div>
                          <div class="col-md-12">
                            <div class="thumbnail text-center">
                              <!-- Image -->
                             <img src="images/repdog/<?php echo $row_rs_showrepdog['rPicture']; ?>" class="img-circle img-responsive" alt="">
                              <!-- Name -->
                              <div class="caption-adoption">
                                <h3><?php echo $row_rs_showrepdog['rName']; ?></h3>
                                <!-- List -->
                                <ul class="list-unstyled">
                                  <li><strong>性別:</strong> <?php if($row_rs_showrepdog['rGender'] == 0){ echo "♀Female";}elseif($row_rs_showrepdog['rGender'] == 1){ echo "♂Male";}else { echo "Intersex";}?></li>
                                  <li><strong>年齡:</strong> <?php echo $row_rs_showrepdog['rAge']; ?></li>
                                </ul>	
                                <!-- Buttons -->								  
                                <div class="toggle-btn page-scroll text-center">
                                  <a href="#<?php echo $row_rs_showrepdog['rId']; ?>" class=" btn btn-default">認識更多</a>
                                </div>
                              </div>
                            </div><!-- /thumbnail -->
                          </div><!-- /col-md-12 -->
                       </div><!-- /div -->
                       <!-- /Animal -->
                        <?php } while ($row_rs_showrepdog = mysqli_fetch_assoc($rs_showrepdog)); ?>
	  
					 				 					  
		         </div><!-- /owl-adopt -->
                 
                 
		         <?php do { ?>
		           <!-- Slide In Panel Animal  -->
		           <div class="cd-panel from-right" id="<?php echo $row_rs_showrepdog2['rId']; ?>">
		             <div class="cd-panel-container">
		               <div class="cd-panel-content">
		                 <div class="col-md-7 col-centered">
		                   <img src="images/repdog/<?php echo $row_rs_showrepdog2['rPicture']; ?>" class="img-responsive" alt="">
	                      </div>
		                 <h3 class="text-center"><?php echo $row_rs_showrepdog2['rName']; ?></h3>
		                 <p><?php echo $row_rs_showrepdog2['rIntroduction']; ?></p>
		                 <div class="page-scroll text-center">
		                   <a class="cd-close btn btn-danger m-left"><i class="fa fa-times"></i>關閉</a>
	                      </div>
	                    </div><!-- /cd-panel-content -->
	                  </div><!-- /cd-panel-container -->
		             </div><!-- /cd-panel -->
		           <?php } while ($row_rs_showrepdog2 = mysqli_fetch_assoc($rs_showrepdog2)); ?>
				   
				

				 

	        </div><!-- /row -->		  
	     </div><!-- /container -->
	 </section>
	<!-- Section ends -->
    
 
    
    </div>
<?php } ?>
    
    
    <?php 
	if (isset($_GET['Id'])) {
	 $next = false; $prev = false;
$run = 0;
	 $colname_rs_ndogpoint = "-1";
	 $colname_rs_pdogpoint = "-1";
	 $colname_rs_ndogpoint = $_GET['Id'];
	 $colname_rs_pdogpoint = $_GET['Id'];
	 
	 do{

  $colname_rs_ndogpoint++;
  $run ++;


$query_rs_ndogpoint = sprintf("SELECT dId,dName FROM dogpoint WHERE dId = %s", GetSQLValueString($Wandering,$colname_rs_ndogpoint, "int"));
$rs_ndogpoint = mysqli_query($Wandering, $query_rs_ndogpoint) or die(mysqli_error());
$row_rs_ndogpoint = mysqli_fetch_assoc($rs_ndogpoint);
$totalRows_rs_ndogpoint = mysqli_num_rows($rs_ndogpoint);
if($row_rs_ndogpoint['dName'] != ""){ $next = true; }
}while(!$next && $run<=5);

 $run = 0;
 
	 do{

  $colname_rs_pdogpoint--;
   $run ++;
  

$query_rs_pdogpoint = sprintf("SELECT dId,dName FROM dogpoint WHERE dId = %s", GetSQLValueString($Wandering,$colname_rs_pdogpoint, "int"));
$rs_pdogpoint = mysqli_query($Wandering, $query_rs_pdogpoint) or die(mysqli_error());
$row_rs_pdogpoint = mysqli_fetch_assoc($rs_pdogpoint);
$totalRows_rs_pdogpoint = mysqli_num_rows($rs_pdogpoint);
if($row_rs_pdogpoint['dName'] != ""){ $prev = true; }
	 }while(!$prev && $run<=5);



}
?>
    
    <?php if($next or $prev){ ?>
			<!-- Post Navigation -->
			<ul id="posts-nav"  class="margin-top-50" style="margin-bottom:-85px;">

					<?php if($next){ ?>
                    <li class="next-post">
					<a href="Introduction.php?Id=<?php echo $row_rs_ndogpoint['dId']; ?>"><span>下一個狗場</span>
                     <?php echo $row_rs_ndogpoint['dName']; ?></a>
				</li>
                <?php } ?>
                
                <?php if($prev){ ?>
				<li class="prev-post">
					<a href="Introduction.php?Id=<?php echo $row_rs_pdogpoint['dId']; ?>"><span>上一個狗場</span>
					<?php echo $row_rs_pdogpoint['dName']; ?></a>
				</li>
                 <?php } ?>
			</ul>
<?php } ?>



    <div id="listing-message" class="listing-section" style="margin-bottom:-100px;">
	<div class="app-pages app-section">
			 <div class="theme-heading">
			<h2>留言板</h2>
			<div class="hr"></div>
		 </div>
    <?php 
	$URL='https://go.sshs.tc.edu.tw' . $_SERVER['REQUEST_URI'];
?>
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


<!-- WOW animations -->
	<script src="scripts/plus/1/wow.min.js"></script>

	<!-- Owl Carousel -->
	<script src="scripts/plus/1/owl.carousel.min.js"></script>


<script src="scripts/plus/1/main.js"></script>


<!-- Style Switcher -->

</body>
</html>
<?php
mysqli_free_result($rs_dogpoint);

mysqli_free_result($rs_need);

mysqli_free_result($rs_others);

mysqli_free_result($rs_faq);

mysqli_free_result($rs_pointalbum);

mysqli_free_result($rs_showrepdog);

mysqli_free_result($rs_showrepdog2);
?>
