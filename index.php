<?php require_once('./Connections/Wandering.php'); ?>

<?php
function __fgetcsv(&$handle, $length = null, $d = ",", $e = '"') {
	$d = preg_quote($d);
	$e = preg_quote($e);
	$_line = "";
	$eof=false;
	while ($eof != true) {
		$_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
		$itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
		if ($itemcnt % 2 == 0){
			$eof = true;
		}
	}
 
	$_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
 
	$_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	$_csv_data = $_csv_matches[1];
 
	for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
		$_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
		$_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
	}
 
	return empty ($_line) ? false : $_csv_data;
}

$file = fopen("https://docs.google.com/spreadsheets/d/e/2PACX-1vSX4URAT94P3drdS4Wqm-KULQqGpxgYE2y_uGwnOI4Hqzh12RX_kUywA6GtisoljmnZRPso0fRPxshT/pub?gid=0&single=true&output=csv","r");

while(! feof($file)){
$lastdata = __fgetcsv($file);
}

?>
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


$query_rs_dogpoint = "SELECT * FROM dogpoint WHERE dType = 1";
$rs_dogpoint = mysqli_query($Wandering, $query_rs_dogpoint) or die(mysqli_error());
$row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint);
$totalRows_rs_dogpoint = mysqli_num_rows($rs_dogpoint);


$query_rs_dogpoint2 = "SELECT * FROM collect WHERE cId = 1";
$rs_dogpoint2 = mysqli_query($Wandering, $query_rs_dogpoint2) or die(mysqli_error());
$row_rs_dogpoint2 = mysqli_fetch_assoc($rs_dogpoint2);
$totalRows_rs_dogpoint2 = mysqli_num_rows($rs_dogpoint2);


$query_rs_mapcenter = "SELECT * FROM mapcenter WHERE mId = 1";
$rs_mapcenter = mysqli_query($Wandering, $query_rs_mapcenter) or die(mysqli_error());
$row_rs_mapcenter = mysqli_fetch_assoc($rs_mapcenter);
$totalRows_rs_mapcenter = mysqli_num_rows($rs_mapcenter);


$query_rs_slide = "SELECT * FROM slider ORDER BY sOrder ASC";
$rs_slide = mysqli_query($Wandering, $query_rs_slide) or die(mysqli_error());
$row_rs_slide = mysqli_fetch_assoc($rs_slide);
$totalRows_rs_slide = mysqli_num_rows($rs_slide);

$maxRows_rs_shownew = 3;
$pageNum_rs_shownew = 0;
if (isset($_GET['pageNum_rs_shownew'])) {
  $pageNum_rs_shownew = $_GET['pageNum_rs_shownew'];
}
$startRow_rs_shownew = $pageNum_rs_shownew * $maxRows_rs_shownew;


$query_rs_shownew = "SELECT * FROM post ORDER BY pStime DESC";
$query_limit_rs_shownew = sprintf("%s LIMIT %d, %d", $query_rs_shownew, $startRow_rs_shownew, $maxRows_rs_shownew);
$rs_shownew = mysqli_query($Wandering, $query_limit_rs_shownew) or die(mysqli_error());
$row_rs_shownew = mysqli_fetch_assoc($rs_shownew);

if (isset($_GET['totalRows_rs_shownew'])) {
  $totalRows_rs_shownew = $_GET['totalRows_rs_shownew'];
} else {
  $all_rs_shownew = mysqli_query($Wandering, $query_rs_shownew);
  $totalRows_rs_shownew = mysqli_num_rows($all_rs_shownew);
}
$totalPages_rs_shownew = ceil($totalRows_rs_shownew/$maxRows_rs_shownew)-1;


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

<!-- Revolution Slider -->
<div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">

<!-- 5.0.7 auto mode -->
	<div id="rev_slider_4_1" class="rev_slider home fullwidthabanner" style="display:none;padding-bottom:45px;" data-version="5.0.7">
		<ul>
<?php $haveslide = 0;
 ?>
			<?php do { $haveslide++;if($row_rs_slide['sPosition'] == 1){$temp = "left";$temp2 = "";$temp3 = "['0','40','40','40']";}
elseif($row_rs_slide['sPosition'] == 2){$temp = "center";$temp2 = "centered";$temp3 = "['0','0','0','0']";}
else{$temp = "right";$temp2 = "righted";$temp3 = "['40','40','40','40']";} ?>
		    <!-- Slide  -->
			  <li data-index="rs-<?php echo $haveslide; ?>" data-transition="fade" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="800" data-fsslotamount="7" data-saveperformance="off">
			    
			    <!-- Background -->
			    <img src="images/<?php echo $row_rs_slide['sPicture']; ?>" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina data-kenburns="on" data-duration="12000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="<?php echo $row_rs_slide['sScale']; ?>" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0">
			    
			    <!-- Caption-->
			    <div class="tp-caption <?php echo $temp2;?> custom-caption-2 tp-shape tp-shapewrapper tp-resizeme rs-parallaxlevel-0" 
					id="slide-<?php echo $haveslide; ?>-layer-2" 
					data-x="['<?php echo $temp;?>','<?php echo $temp;?>','<?php echo $temp;?>','<?php echo $temp;?>']"
                    data-hoffset=<?php echo '"' . $temp3 . '"';?>
                    data-y="['middle','middle','middle','middle']" data-voffset="['0']" 
					data-width="['640','640', 640','420','320']"
					data-height="auto"
					data-whitespace="nowrap"
					data-transform_idle="o:1;"	
					data-transform_in="y:0;opacity:0;s:1000;e:Power2.easeOutExpo;s:400;e:Power2.easeOutExpo" 
					data-transform_out="" 
					data-mask_in="x:0px;y:[20%];s:inherit;e:inherit;" 
					data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
					data-start="1000" 
					data-responsive_offset="on">
			      
			      <!-- Caption Content -->
			      <div class="R_title margin-bottom-15"
					id="slide-2-layer-<?php echo $row_rs_slide['sPosition']; ?>"
                    

					data-x="['<?php echo $temp; ?>','center','center','center']"
                    data-hoffset="['0','0','0','0']"
					data-y="['middle','middle','middle','middle']"
					data-voffset="['-40','-40','-20','-80']"
					data-fontsize="['42','36', '32','36','22']"
					data-lineheight="['70','60','60','45','35']"
					data-width="['640','640', 640','420','320']"
					data-height="none" data-whitespace="normal"
					data-transform_idle="o:1;"
					data-transform_in="y:-50px;sX:2;sY:2;opacity:0;s:1000;e:Power4.easeOut;"
					data-transform_out="opacity:0;s:300;"
					data-start="600"
					data-splitin="none"
					data-splitout="none"
					data-basealign="slide"
					data-responsive_offset="off"
					data-responsive="off"
					style="z-index: 6; color: #fff; letter-spacing: 0px; font-weight: 600; "><br><?php echo $row_rs_slide['sTitle']; ?></div>
			      
			      <div class="caption-text"><?php echo $row_rs_slide['sContent']; ?></div>
                  <?php if($row_rs_slide['sButtonname'] != ""){ ?>
			      <a href="<?php echo $row_rs_slide['sButtonlink']; ?>" class="button medium"><?php echo $row_rs_slide['sButtonname']; ?></a>
                  <?php } ?>
			      </div>
			    
		      </li>
  <!-- SlideEnd  -->
  <?php } while ($row_rs_slide = mysqli_fetch_assoc($rs_slide)); ?>

		</ul>
		<div class="tp-static-layers"></div>

	</div>
</div>
<!-- Revolution Slider / End -->
    
    
   
<!-- Content
================================================== -->


 <!-- Recent Blog Posts -->
<section class="fullwidth padding-top-75 padding-bottom-75" data-background-color="#f9f9f9">
	<div class="container">

		<div class="col-lg-8 col-lg-offset-2">
		   <!-- Section Heading -->	
			<div class="theme-heading">
			<h2>最新消息</h2>
			<div class="hr"></div>
		 </div>
		</div>

		<div class="row">
		  <?php do { ?>
		    <!-- Blog Post Item -->
		    <div class="col-md-4">
		      <a href="pages-blog-post.php?Id=<?php echo $row_rs_shownew['pId']; ?>" class="blog-compact-item-container">
		        <div class="blog-compact-item">
		          <img src="images/post/<?php echo $row_rs_shownew['pPicture']; ?>" alt="">
		          <span class="blog-item-tag"><?php if($row_rs_shownew['pType'] == 0){ echo "消息";}
elseif($row_rs_shownew['pType'] == 1){ echo "募集";}
elseif($row_rs_shownew['pType'] == 2){ echo "活動";}
elseif($row_rs_shownew['pType'] == 3){ echo "系統";}
elseif($row_rs_shownew['pType'] == 4){ echo "綜合";} ?></span>
		          <div class="blog-compact-item-content">
		            <ul class="blog-post-tags">
		              <li><?php echo date('Y 年 m 月 d 日',strtotime($row_rs_shownew['pStime'])); ?></li>
		              </ul>
		            <h3><?php echo $row_rs_shownew['pTitle']; ?></h3>
		            <p><?php if($row_rs_shownew['pOutline'] != ""){ echo $row_rs_shownew['pOutline'];}
					else{ echo TrimByLength2($row_rs_shownew['pContent'], 50, false);} ?></p>
		            </div>
		          </div>
	          </a>
	        </div>
		    <!-- Blog post Item / End -->
		    <?php } while ($row_rs_shownew = mysqli_fetch_assoc($rs_shownew)); ?>

			

			<div class="col-md-12 centered-content">
				<a href="pages-blog.php" class="button border margin-top-10">MORE</a>
			</div>

		</div>

	</div>
</section>
<!-- Recent Blog Posts / End -->

<script> 

          function locationData(locationURL,locationImg,locationTitle, locationAddress, locationManagement, locationHavedog) {
          return(''+
            '<a href="'+ locationURL +'" class="listing-img-container">'+
               '<div class="infoBox-close"><i class="fa fa-times"></i></div>'+
               '<img src="'+locationImg+'" alt="">'+

               '<div class="listing-item-content">'+
                  '<h3>'+locationTitle+'</h3>'+
                  '<span>收留約 '+locationHavedog+' 隻狗狗</span>'+
               '</div>'+

            '</a>'+

            '<div class="listing-content">'+
               '<div class="listing-title">'+
                  '<div class="Management">狗場負責人：'+locationManagement+'</div></div>'+
               '</div>'+
            '</div>')
      }
	  
	  
	  function locationData2(locationURL,locationImg,locationTitle, locationAddress, locationManagement) {
          return(''+
                     
			    '<a href="'+ locationURL +'" class="listing-img-container">'+
'<div class="infoBox-close"><i class="fa fa-times"></i></div>'+
               '<img src="'+locationImg+'" alt="">'+

               '<div class="listing-item-content">'+
                  '<h3>'+locationTitle+'</h3>'+
                  '<span>'+locationAddress+'</span>'+
               '</div>'+

            '</a>'+

            '<div class="listing-content">'+
							
               '<div class="listing-title">'+
                  '<div class="Management">集貨負責人：'+locationManagement+'</div></div>'+
               '</div>'+
            '</div>')
      }
	

      var locations = [   // 位置載入
	  <?php $count = 0; $havedog = 0; ?>
	  <?php if($totalRows_rs_dogpoint != 0){ do { $count++; $havedog = $havedog + $row_rs_dogpoint['dHavedog'];  ?>
        [ locationData('Introduction.php?Id=<?php echo $row_rs_dogpoint['dId']; ?>','images/dogpoint/<?php echo $row_rs_dogpoint['dPicture']; ?>',"<?php echo $row_rs_dogpoint['dName']; ?>",'<?php echo $row_rs_dogpoint['dMap']; ?>', '<?php echo $row_rs_dogpoint['dManagement']; ?>', '<?php echo $row_rs_dogpoint['dHavedog']; ?>'), <?php echo $row_rs_dogpoint['dMappoint']; ?>, Number(<?php echo $count ;?>), '<i class="im im-icon-Dog"></i>'],
      	  <?php } while ($row_rs_dogpoint = mysqli_fetch_assoc($rs_dogpoint)); }?>
		  
        [ locationData2('collectstation.php','images/<?php echo $row_rs_dogpoint2['cPicture']; ?>',"<?php echo $row_rs_dogpoint2['cName']; ?>",'<?php echo $row_rs_dogpoint2['cMap']; ?>', '<?php echo $row_rs_dogpoint2['cManagement']; ?>'), <?php echo $row_rs_dogpoint2['cMaplat']; ?>,<?php echo $row_rs_dogpoint2['cMaplong']; ?>, Number(<?php echo $count+1 ;?>), '<i class="im im-icon-Box-Open"></i>'],
      	 
	  ]; 
</script>

<!-- Section Stats -->	
    <section id="stats">
      
			      
		<div class="col-lg-8 col-lg-offset-2">
		   <!-- Section Heading -->	
			<div class="theme-heading">
			<h2 style="color:#ffffff;">愛心統計</h2>
			<div class="hr"></div>
		 </div>
		</div>
         <div class="container padding-bottom-50">
            <div class="row">
               <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                  <div class="col-md-3 col-sm-6 res-margin">
                     <!-- Number 1 -->
                     <div class="numscroller" data-slno='1' data-min='0' data-max='<?php echo $count; ?>' data-delay='0' data-increment="<?php echo $count; ?>">0</div>
                     <hr>
					 <h5>狗場數量</h5>
                  </div>
                  <div class="col-md-3 col-sm-6 res-margin">
                     <!-- Number 2 -->
                     <div class="numscroller" data-slno='1' data-min='0' data-max='<?php echo $havedog; ?>' data-delay='0' data-increment="5">0</div>
                     <hr>
					 <h5>收養數量</h5>
                  </div>
                  <div class="col-md-3 col-sm-6 res-margin">
                     <!-- Number 3 -->
                     <div class="numscroller" data-slno='1' data-min='0' data-max='<?php echo $lastdata[4]; ?>' data-delay='0' data-increment="9">0</div>
                     <hr>
                     <h5>累積飼料Kg</h5>

                  </div>
                  <div class="col-md-3 col-sm-6">
                     <!-- Number 4 -->
                     <div class="numscroller" data-slno='1' data-min='0' data-max='<?php echo $lastdata[7]; ?>' data-delay='0' data-increment="3">0</div>
                     <hr>
					 <h5>其他物資件數</h5>
                  </div>
               </div>
            </div>
         </div>
         
           
    </section>
	<!-- Section Ends-->
<!-- Map
================================================== -->



<div id="map-container" class="fullwidth-home-map">
	<div class="col-lg-8 col-lg-offset-2">
		   <!-- Section Heading -->	
			<div class="theme-heading">
			<h2>狗場地圖</h2>
			<div class="hr"></div>
		 </div>
		</div>

    
    <div id="map" data-map-zoom="<?php echo $row_rs_mapcenter['mZoom']; ?>">
      <!-- map goes here -->
      </div>
   
    <!-- Scroll Enabling Button -->
	<a href="#" id="scrollEnabling" title="按下後，滾動會鎖定在地圖縮放中" style="margin-top:200px;">開啟地圖滾動</a>
    
   

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
<script type="text/javascript" src="scripts/numscroller.js"></script>

<!-- Maps -->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA2wXCdtQOx7tzeBDSea5K7zOQiccpzH8Q"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=zh-TW"></script>
<script type="text/javascript" src="scripts/infobox.min.js"></script>
<script type="text/javascript" src="scripts/markerclusterer.js"></script>
<script type="text/javascript">
mapcenter1=Number("<?php echo $row_rs_mapcenter['mLat']; ?>");/*緯*/
mapcenter2=Number("<?php echo $row_rs_mapcenter['mLng']; ?>");
</script>
<script type="text/javascript" src="scripts/maps.js"></script>

<script type="text/javascript" src="scripts/numscroller.js"></script>


<!-- REVOLUTION SLIDER SCRIPT -->
<script type="text/javascript" src="scripts/themepunch.tools.min.js"></script>
<script type="text/javascript" src="scripts/themepunch.revolution.min.js"></script>

<script type="text/javascript">
	var tpj=jQuery;			
	var revapi4;
	tpj(document).ready(function() {
		if(tpj("#rev_slider_4_1").revolution == undefined){
			revslider_showDoubleJqueryError("#rev_slider_4_1");
		}else{
			revapi4 = tpj("#rev_slider_4_1").show().revolution({
				sliderType:"standard",
				jsFileLocation:"scripts/",
				sliderLayout:"auto",
				dottedOverlay:"none",
				delay:9000,
				navigation: {
					keyboardNavigation:"off",
					keyboard_direction: "horizontal",
					mouseScrollNavigation:"off",
					onHoverStop:"on",
					touch:{
						touchenabled:"on",
						swipe_threshold: 75,
						swipe_min_touches: 1,
						swipe_direction: "horizontal",
						drag_block_vertical: false
					}
					,
					arrows: {
						style:"zeus",
						enable:true,
						hide_onmobile:true,
						hide_under:600,
						hide_onleave:true,
						hide_delay:200,
						hide_delay_mobile:1200,
						tmp:'<div class="tp-title-wrap"></div>',
						left: {
							h_align:"left",
							v_align:"center",
							h_offset:40,
							v_offset:0
						},
						right: {
							h_align:"right",
							v_align:"center",
							h_offset:40,
							v_offset:0
						}
					}
					,
					bullets: {
				enable:false,
				hide_onmobile:true,
				hide_under:600,
				style:"hermes",
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1200,
				direction:"horizontal",
				h_align:"center",
				v_align:"bottom",
				h_offset:0,
				v_offset:32,
				space:5,
				tmp:''
					}
				},
				viewPort: {
					enable:true,
					outof:"pause",
					visible_area:"80%"
			},
			responsiveLevels:[1200,992,768,480],
			visibilityLevels:[1200,992,768,480],
			gridwidth:[1180,1024,778,480],
			gridheight:[640,500,400,300],
			lazyType:"none",
			parallax: {
				type:"mouse",
				origo:"slidercenter",
				speed:2000,
				levels:[2,3,4,5,6,7,12,16,10,25,47,48,49,50,51,55],
				type:"mouse",
			},
			shadow:0,
			spinner:"off",
			stopLoop:"off",
			stopAfterLoops:-1,
			stopAtSlide:-1,
			shuffle:"off",
			autoHeight:"off",
			hideThumbsOnMobile:"off",
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			debugMode:false,
			fallbacks: {
				simplifyAll:"off",
				nextSlideOnWindowFocus:"off",
				disableFocusListener:false,
			}
		});
		}
	});	/*ready*/
</script>	


<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
	(Load Extensions only on Local File Systems ! 
	The following part can be removed on Server for On Demand Loading) -->	
<script type="text/javascript" src="scripts/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.video.min.js"></script>




<!-- Style Switcher -->

</body>
</html><?php
mysqli_free_result($rs_dogpoint);

mysqli_free_result($rs_dogpoint2);

mysqli_free_result($rs_mapcenter);

mysqli_free_result($rs_slide);

mysqli_free_result($rs_shownew);

?>
