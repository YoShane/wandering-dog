-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-05-21: 17:04:07
-- 伺服器版本: 5.6.17
-- PHP 版本： 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `wandering`
--

-- --------------------------------------------------------

--
-- 資料表結構 `aboutus`
--

CREATE TABLE IF NOT EXISTS `aboutus` (
  `aId` int(11) NOT NULL AUTO_INCREMENT,
  `aTitle` varchar(50) NOT NULL,
  `aContent` text NOT NULL,
  `aAboutpicture` varchar(50) DEFAULT NULL,
  `aVideo` text,
  `aBtitle1` varchar(50) NOT NULL,
  `aBtitle2` varchar(50) NOT NULL,
  `aBtitle3` varchar(50) NOT NULL,
  `aBpicture1` varchar(50) NOT NULL,
  `aBpicture2` varchar(50) NOT NULL,
  `aBpicture3` varchar(50) NOT NULL,
  `aBcontent1` text,
  `aBcontent2` text,
  `aBcontent3` text,
  PRIMARY KEY (`aId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `aboutus`
--

INSERT INTO `aboutus` (`aId`, `aTitle`, `aContent`, `aAboutpicture`, `aVideo`, `aBtitle1`, `aBtitle2`, `aBtitle3`, `aBpicture1`, `aBpicture2`, `aBpicture3`, `aBcontent1`, `aBcontent2`, `aBcontent3`) VALUES
(1, '踏浪-關懷流浪動物', '印度聖雄甘地曾說：「一個國家的道德水準，看它對動物的態度便可以知道。」本計畫所募集的寵物用品有三大項', NULL, NULL, '飼料物資', '醫療物資', '生活物資', 'flaticon-dog39', 'flaticon-veterinarian', 'flaticon-pets8', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `collect`
--

CREATE TABLE IF NOT EXISTS `collect` (
  `cId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) NOT NULL,
  `cPicture` varchar(50) DEFAULT NULL,
  `cIntroduction` text NOT NULL,
  `cManagement` varchar(10) NOT NULL,
  `cHphone` varchar(20) DEFAULT NULL,
  `cCphone` varchar(15) DEFAULT NULL,
  `cEmail` varchar(50) DEFAULT NULL,
  `cMap` text NOT NULL,
  `cMaplat` varchar(100) NOT NULL,
  `cMaplong` varchar(50) NOT NULL,
  `cContent` text,
  `cInfo` text NOT NULL,
  `cSdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cCdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `collect`
--

INSERT INTO `collect` (`cId`, `cName`, `cPicture`, `cIntroduction`, `cManagement`, `cHphone`, `cCphone`, `cEmail`, `cMap`, `cMaplat`, `cMaplong`, `cContent`, `cInfo`, `cSdate`, `cCdate`) VALUES
(1, '愛心集貨地', '20171115204157.png', '<p><span style="font-size:16px;">本集貨站是楊阿姨提供我們使用的物資集散地，您可透過物流託運貨或親自送到這裡，來自各地區的愛心物資先來到此處後，會再均勻分配至各個狗場。有物資相關任何問題，歡迎與我們聯絡!</span></p>\r\n', '楊阿姨', '0931-585-422', NULL, NULL, '台中市東勢區第五橫街中和巷2號', '24.2577629', '120.8289057', '(已刪除此欄位)', '1.為保護狗場的安全隱私，本網站不提供狗場的確切位置，僅有其所在地區。<br />\r\n2.寄件物資若未附註指定狗場，會由集貨站自行分配。<br />\r\n3.若您已將物資寄送出，可至網站中的芳名錄查詢您所捐出的物資是否送到，如果不清楚的地方或是建議都可以在下面的留言喔! 再次謝謝您的愛心。', '2017-08-18 09:17:30', '2018-05-17 16:52:44');

-- --------------------------------------------------------

--
-- 資料表結構 `collectalbum`
--

CREATE TABLE IF NOT EXISTS `collectalbum` (
  `cId` int(11) NOT NULL AUTO_INCREMENT,
  `cLcid` int(11) NOT NULL,
  `cName` int(11) NOT NULL,
  `cNote` int(11) NOT NULL,
  `cStime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='collectalbum' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `dogneed`
--

CREATE TABLE IF NOT EXISTS `dogneed` (
  `nId` int(11) NOT NULL AUTO_INCREMENT,
  `nLdid` int(11) NOT NULL,
  `nLtid` int(11) NOT NULL,
  `nName` text NOT NULL,
  `nRemarks` text,
  PRIMARY KEY (`nId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=380 ;

--
-- 資料表的匯出資料 `dogneed`
--

INSERT INTO `dogneed` (`nId`, `nLdid`, `nLtid`, `nName`, `nRemarks`) VALUES
(367, 4, 41, '跳蚤藥', NULL),
(379, 6, 41, '跳蚤藥', NULL),
(378, 6, 38, '狗罐頭', NULL),
(375, 5, 41, '跳蚤藥', NULL),
(374, 5, 38, '狗罐頭', NULL),
(366, 4, 38, '狗罐頭', NULL),
(349, 8, 37, '狗飼料(袋裝)', NULL),
(357, 2, 41, '跳蚤藥', NULL),
(361, 1, 41, '跳蚤藥', NULL),
(360, 1, 38, '狗罐頭', NULL),
(363, 3, 43, '貓砂', NULL),
(362, 3, 42, '貓飼料', NULL),
(356, 2, 38, '狗罐頭', NULL),
(359, 1, 39, '棉被', NULL),
(354, 2, 37, '狗飼料(袋裝)', NULL),
(365, 4, 39, '棉被', NULL),
(373, 5, 39, '棉被', NULL),
(377, 6, 39, '棉被', NULL),
(358, 1, 37, '狗飼料(袋裝)', NULL),
(355, 2, 39, '棉被', NULL),
(364, 4, 37, '狗飼料(袋裝)', NULL),
(372, 5, 37, '狗飼料(袋裝)', NULL),
(376, 6, 37, '狗飼料(袋裝)', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `dogpoint`
--

CREATE TABLE IF NOT EXISTS `dogpoint` (
  `dId` int(11) NOT NULL AUTO_INCREMENT,
  `dType` int(11) NOT NULL,
  `dName` varchar(50) NOT NULL,
  `dHavedog` int(11) NOT NULL,
  `dIntroduction` text NOT NULL,
  `dPicture` varchar(50) DEFAULT NULL,
  `dManagement` varchar(10) NOT NULL,
  `dHphone` varchar(30) DEFAULT NULL,
  `dCphone` varchar(30) DEFAULT NULL,
  `dMap` text,
  `dMappoint` text NOT NULL,
  `dYoutube` text,
  `dFb` text,
  `dSdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dCdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 資料表的匯出資料 `dogpoint`
--

INSERT INTO `dogpoint` (`dId`, `dType`, `dName`, `dHavedog`, `dIntroduction`, `dPicture`, `dManagement`, `dHphone`, `dCphone`, `dMap`, `dMappoint`, `dYoutube`, `dFb`, `dSdate`, `dCdate`) VALUES
(1, 1, '黃阿姨狗場', 182, '<p><span style="font-size:20px;"><span style="font-family:標楷體;"><img alt="" class="col-md-4 col-sm-12 res-margin2" src="/uploads/images/img-15117942857.jpg" />　　</span></span><span style="font-size:24px;"><span style="font-family:微軟正黑體;">黃阿姨狗場目前總共收容182隻狗狗，因為黃阿姨一人要照顧這麼多的狗狗，所以她就直接住在狗場裡面。目前光是狗場的建設就花費了兩百五十萬，更不要說每個月的水電費、飼料費、醫療費等。救援流浪狗長達十年，為了支撐起經營狗場的龐大負擔，黃阿姨選擇賣掉自己九百萬的房子，黃阿姨說：「做這個（動保）純粹就是一個善念，我們人能開口求救，說自己肚子餓，但狗不會說話。我只是在做一個最卑微的救援。」</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　因為狗場是位在偏僻的山區中，垃圾車不會經過附近，沒有辦法，所以只好在狗場中就地焚燒垃圾。狗場中有擺放貨櫃屋，狗狗可以自由選擇喜歡的區域居住。而其中，有一個貨櫃屋以網子做為跟外界的區隔，用來讓新進來的幼犬跟狗場中其他的成犬互相熟悉，這是考慮到狗狗是以味道來認識世界的本性，也是黃阿姨站在狗狗的立場專門為牠們所想出的設計。</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　最後，我們聊起狗狗們的故事，她清楚記得182個毛孩子的名字，她說：「不一定每一隻都有悲慘故事，但每一隻都是我的小寶貝。」</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/OLB_XqNi1pk?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20170908131544.jpg', '黃阿姨', '不提供', '不提供', '台中市和平區', '24.264392,120.902211', 'https://youtu.be/OLB_XqNi1pk', NULL, '2017-09-08 05:15:44', '2018-05-16 18:04:19'),
(2, 1, '方大哥狗場', 75, '<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;"><img alt="" class="col-md-4 col-sm-12 res-margin2" src="/uploads/images/img-15117948834.jpg" />　　</span></span><span style="font-family:微軟正黑體;"><span style="font-size:24px;">方爸爸(父)收容了將近70隻狗狗，都是來自救援，</span></span><span style="font-family:微軟正黑體;"><span style="font-size:24px;">ㄧ家人一起照顧著這些狗狗。方爸爸與他的兒子從事的是營建裝潢的工作，狗場中的棚架、小屋是父子倆親手打造的。開始是方爸爸的兒子養了一隻狗，ㄧ家人才開始流浪狗的救援，從一隻、兩隻，到現在的七十多隻。被帶回來得狗狗多來自山區，因為捕獸夾所已變成剩下三隻腳的、ㄧ整窩小狗裝箱被丟棄的，有些是別人通報，有些是自己撿的，每ㄧ隻都有自己的經歷，在方爸爸一家人眼中每一隻都是獨一無二，而且珍貴的家人。</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　過程中遇到的困難不少，像是山區氣候不佳，炎熱與大雨對狗狗和方爸爸一家人來說，都是一大考驗，但最可怕的不是氣候，而是人心，曾經有從方爸爸這裡送養出去的狗狗，因為收養人的個人因素，又私底下把狗狗轉送，責任歸屬不清，但可知的是，狗狗，再也找不回來了。</span></span></p>\r\n\r\n<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　而方大哥(子)覺得很幸運的是因為他的家人願意支持他，與他一起走過了整整六年的歲月。因為他知道養這麼多狗狗的開銷，而當時的他還只是一個大學生，根本無法負擔，但他大概沒有想到他的父母會把他帶回來的那隻狗狗當成自己的家人，後來更是與他一起照顧這群毛孩。</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/9zhCFKZOwqo" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20170918201521.jpg', '方懋光', '04-25******', '0933-******', '台中市和平區', '24.2216899,120.8457722', 'https://www.youtube.com/watch?v=9zhCFKZOwqo', NULL, '2017-09-08 07:59:25', '2018-05-16 17:57:50'),
(3, 1, '裴媽媽貓屋', 25, '<p style="text-align: justify;"><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　裴阿姨從921地震那年開始到收容所領養流浪貓，一直到現在，裴媽媽的家總共有三十隻貓咪，而且每一隻貓咪都有名字代表牠是家中重要的一分子。採訪時裴媽媽打趣地說:「是有克制才會只有三十隻，要是沒有克制可能要百隻了呢!」。說到貓咪的來源，一開始有幾隻是到收容所去領養的，後來也有不少是別人直接棄養在裴媽媽家附近，或是受傷救援的，對裴媽媽來說給這些貓咪們一個溫暖的家，是一種對生命的尊重跟疼惜。<img alt="" src="col-md-4 col-sm-12 res-margin2" /><img alt="" src="col-md-4 col-sm-12 res-margin2" /></span></span></p>\r\n\r\n<p style="text-align: justify;"><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　裴媽媽說：「在我家的貓真的很幸福，我受苦，牠們享福。我去打工賺的零用錢都花在牠們身上，有時候不夠還要掏私房錢出來貼」，因為貓咪的飼料比狗狗的貴，還要再加上貓砂的費用，所以裴媽媽工作賺的錢幾乎都是奉獻給貓咪，但是只要一回家後看見貓兒們安穩地在家中舒適的打呼、親密的對她撒嬌，一切的辛苦都不算什麼。令人驚訝的是，裴媽媽的貓咪做結紮手術的錢並不是配合團體，而是自己給付，在台灣的平均價格一隻公貓至少一千，母貓則是因為腹部傷口較大，所以費用會更高，這真的是一筆不預期而且龐大的開銷。但是裴媽媽不想申請補助的名額，因為她覺得自己還負擔得起，想要將名額留給無法負擔可是又有意做TNvR愛爸愛媽，這是裴媽媽的堅持，即使自己過得不算富裕，但卻能夠體諒到更需要資源的人，這樣的體諒與設想，大概就像貓咪一樣柔軟了。</span></span></p>\r\n\r\n<p style="text-align: justify;">&nbsp;</p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/NPqUU75CuII" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20170918232823.jpg', '裴媽媽', '不提供', '不提供', '台中市后里區', '24.341032,120.697220', 'https://youtu.be/NPqUU75CuII', NULL, '2017-09-18 15:28:24', '2018-05-16 18:05:48'),
(4, 1, '蕭媽媽狗場', 21, '<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　蕭媽媽在二十一年前從外面帶回一隻流浪狗回家養，一開始不知道絕育，所以那隻狗狗就生了一窩小狗，蕭媽媽把狗兒們都養在家中，後來因為鄰居的投訴，所以蕭媽媽便把狗都移到附近一塊屬於糖廠的地上。因為蕭阿姨每天都非常用心的這群毛小孩，時不時就掃大便，加上地處偏僻，沒有被民眾檢舉，因此台糖也默許了，只是默許歸默許，蕭阿姨沒有權利在土地架設圍籬來限制狗狗的行動，所以只好鍊著。</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　將狗狗移到糖廠的這塊地後，路過民眾看見此處有收容狗，於是也偷偷將狗丟來這裡，就這樣，一丟一養之間，蕭阿姨的狗場越來越多隻。全盛時期最多一次養了四十多隻。狗場一個月開銷八、九千只是最最基本的飼料，大部分的費用都是自己賺的，以及子女給的，「民眾的捐款實在太少太少。」蕭阿姨無奈說。</span></span></p>\r\n\r\n<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　二十一年來，開朗的蕭媽媽說：「不會覺得辛苦。我有多少，我就給牠們吃多少，我只是擔心以後如果我離開了，這些狗怎麼辦，不知道別人能不能像我們依樣疼惜。」</span></span><span style="font-family:微軟正黑體;"><span style="font-size:24px;">，她將狗兒們當作是自己的家人般的照顧，蕭媽媽說大概是在上輩子就結下的緣，才會這輩子無法放著牠們不管。捨不得這群狗狗交給別人照顧，只希望外界能夠提供多一點的飼料和罐頭，來減輕負擔，但也不能說是負擔，大概就如詩人吳晟所說的：甜蜜的負荷。</span></span></p>\r\n\r\n<p><span style="font-family:微軟正黑體;"><span style="font-size:18px;"><img alt="" src="col-md-4 col-sm-12 res-margin2" /></span></span></p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/0Jm1XjH6X1M" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20170920220900.jpg', '蕭媽媽', '不提供', '不提供', '台中市后里區', '24.296589,120.701927', NULL, '無', '2017-09-20 14:09:00', '2018-05-16 18:12:31'),
(5, 1, '楊阿姨狗場', 71, '<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;"><img alt="" class="col-md-4 col-sm-12 res-margin2" src="/uploads/images/img-15117951021.jpg" />　　楊阿姨考慮到每隻狗狗不同的個性，很細心的將狗場分成好幾區域，將狗狗們分區管理，有幼幼班、小班、中班、較安靜的狗狗一區、較會吠叫的狗狗一區，最後還有一區是當初最早來的狗狗，牠們都已經彼此認識，所以待在一起會會比跟陌生的狗住在一起還要融洽。因為蕭媽媽覺得，養狗不是將牠們關在一個小地方，將牠們分區是為了讓每一隻狗狗都能在自己的區域內安心地活動，這樣的細心是因為將狗兒們當作是與自己一樣的生命在尊重。說起狗狗的名字，楊阿姨說：「這裡的每隻狗都有名字。現在的數量還可以記得每一隻的名字。」</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　管理比較會吵架的狗狗，楊阿姨使用了一招超酷的辦法，將狗狗的牽繩，固定在一條繩索上，讓狗狗被繩索限制行動範圍，卻仍保有一定的活動空間。</span></span></p>\r\n\r\n<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　楊阿姨說，曾經有人請她接收自己要棄養的狗狗，然後會給她一筆小錢，大約3、4千塊，楊阿姨覺得這很弔詭，因為這一筆錢根本不夠一隻狗的花費，可能連醫療費都不夠。但是有很多人卻會這麼做，只是為了讓自己心裡好受一點，但是生命可以用金錢來衡量嗎?至少對楊阿姨來說，不能。</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/qxWLVmgQ51I" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20171002225156.jpg', '楊阿姨', '不提供', '不提供', '台中市后里區', '24.311536,120.769279', 'https://www.youtube.com/watch?v=qxWLVmgQ51I ', '無', '2017-10-02 14:51:56', '2018-05-16 18:22:29'),
(6, 1, '好汪角', 100, '<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　林阿姨與她的爸爸一起照顧著狗場中一百多隻狗狗，一年365天，一天24小時，時間幾乎都是投注在狗狗身上，她覺得這是最好的時間運用，即使疲累，只要狗兒們能過得安穩溫飽，甚至找到一個更好的家，沒有什麼比這個還要更溫暖、讓她有動力了。</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　林阿姨的狗場總共有一百多隻狗，由於狗狗數量眾多，沒有這麼多籠子，阿姨乾脆用木箱當做狗狗們擋風避雨的小窩，每隻狗狗都有習慣待的地方，晚上都會乖乖回自己的位置睡覺，阿姨還額外用鐵皮架一個小屋，依狗狗們的個性安排隔離。</span></span></p>\r\n\r\n<p><span style="font-size:24px;"><span style="font-family:微軟正黑體;">　　訪問到狗場的經費，林阿姨說，建立狗場經費，一部份來自募款，另一部分是她賣房子的。每個月的飼料及醫療支出大概都要兩、三萬。這樣的金額，幾乎等於一個年輕人的月薪了。阿姨說：「有些貓狗是人家棄養的，妳知道妳不給牠們一口飯吃，人的溫暖都不見了。」</span></span></p>\r\n\r\n<p><span style="font-family:微軟正黑體;"><span style="font-size:24px;">　　林阿姨經營狗場的同時也著力於流浪狗的TNvR，她計畫以後如果有資源的話，組織一個醫療團隊，專門做流浪貓狗的節育，透過高密度的結紮，來有效的達到減少流浪動物的效果。但是她希望的還是落實生命教育，因為只有極少部分的人參與動保，即使再怎麼努力成效也不大，只有透過教育了解尊重生命的意義，人跟動物才能和諧共處。</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/x6PncM3whro" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n', '20171002225745.jpg', '林阿姨', '不提供', '不提供', '台中市太平區', '24.164981,120.799221', 'https://www.youtube.com/watch?v=x6PncM3whro', 'https://www.facebook.com/shuqing.lin3?hc_ref=ARQtjKf-HiVeAd0DBhm6moEeYG7yaxJMJp6pKI9XUpLWoD4gBUsDyXLoqwZZj2-HLqM&fref=nf', '2017-10-02 14:57:45', '2018-05-16 18:23:22'),
(8, 1, '林阿姨狗場', 120, '<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">8</span><span style="margin: 0px;">月<span lang="EN-US" style="margin: 0px;">12</span>號早上，我們深入太平區，經過林立的住宅區，經過墓園，還有坑坑疤疤的石頭路，我們到了林阿姨的狗場。</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">林阿姨的狗場總共有一百多隻狗，由於狗狗數量眾多，沒有這麼多籠子，阿姨乾脆用木箱當做狗狗們擋風避雨的小窩，每隻狗狗都有習慣待的地方，晚上都會乖乖回自己的位置睡覺，阿姨還額外用鐵皮架一個小屋，依狗狗們的個性安排隔離。</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">訪問到狗場的經費，林阿姨說，建立狗場經費，一部份來自募款，另一部分是她賣房子的。每個月的飼料及醫療支出大概都要兩、三萬。這樣的金額，幾乎等於一個年輕人的月薪了，我們能夠為了自己所堅持的事物，付出到甚麼程度呢？</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">林阿姨提起皮皮的故事，一隻可愛親人的小黑狗，卻瞎了一邊的眼睛。因為前任飼主喝醉砍傷了牠，讓牠瞎了右眼，後來可惡的飼主還擔心被動保處發現，想私下「處理」牠，所幸被房客發現通報，林阿姨將牠接了回來。</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">看牠笑的裂開的嘴跟閃亮的左眼，曾經因為人類受了重傷的牠現在還是這麼相信人，有一種執著跟信心吧，覺得我很愛妳，妳也很愛我吧。牠們對我們的付出是毫不計較的給予，可是收到的回應卻往往不平等。</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">阿姨說：「有些貓狗是人家棄養的，妳知道妳不給牠們一口飯吃，人的溫暖都不見了。」</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span lang="EN-US" style="margin: 0px;">&nbsp;</span></span></span></p>\r\n\r\n<p style="margin: 0px; text-indent: 24pt;"><span style="font-size:24px;"><span style="font-family:微軟正黑體;"><span style="margin: 0px;">我們在太平，走訪了林阿姨的狗場，認識了在都市邊緣，默默散發溫暖的ㄧ群人。</span></span></span></p>\r\n', '20180226221855.jpg', '林淑卿', '04-25******', '0933-******', '台中市太平區', '24.245827,120.876698', NULL, NULL, '2018-02-26 14:18:56', '2018-05-16 17:54:59');

-- --------------------------------------------------------

--
-- 資料表結構 `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `fId` int(11) NOT NULL AUTO_INCREMENT,
  `fLdid` int(11) NOT NULL,
  `fQuestion` text NOT NULL,
  `fAnswer` text NOT NULL,
  PRIMARY KEY (`fId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 資料表結構 `footer`
--

CREATE TABLE IF NOT EXISTS `footer` (
  `fId` int(11) NOT NULL AUTO_INCREMENT,
  `fAbout` text NOT NULL,
  `fCall` text NOT NULL,
  `fFb` text,
  `fYtb` text,
  `fIg` text,
  PRIMARY KEY (`fId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `footer`
--

INSERT INTO `footer` (`fId`, `fAbout`, `fCall`, `fFb`, `fYtb`, `fIg`) VALUES
(1, '高二時，我們創立高中校內懷生社，高三暑假成立「踏浪」團隊，意旨「踏尋流浪的土地」，成立了這個網站。\r\n與其說，我們在尋找的是隱蔽在山林中的狗場，我們認為，我們比較像在尋找，家的樣子。', '<span>台中市東勢區第五橫街中和巷2號</span>\r\n<br>TeL: <span>0931-585-422<br>(計畫指導：游美芸護理師)\r\n</span>', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `galleryphoto`
--

CREATE TABLE IF NOT EXISTS `galleryphoto` (
  `gId` int(11) NOT NULL AUTO_INCREMENT,
  `gMode` int(1) NOT NULL,
  `gLid` int(11) NOT NULL,
  `gName` varchar(50) NOT NULL,
  `gNote` text NOT NULL,
  `gStime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=250 ;

--
-- 資料表的匯出資料 `galleryphoto`
--

INSERT INTO `galleryphoto` (`gId`, `gMode`, `gLid`, `gName`, `gNote`, `gStime`) VALUES
(249, 0, 1, 'img-15268084579.jpg', '謝謝黃阿姨', '2018-05-20 09:27:37'),
(110, 0, 1, 'img-15117942501.jpg', '下不去了', '2017-11-27 14:50:50'),
(109, 0, 1, 'img-15117942472.jpg', '垃圾處理', '2017-11-27 14:50:47'),
(131, 0, 6, 'img-15117946774.jpg', '哈囉', '2017-11-27 14:57:57'),
(129, 0, 6, 'img-15117946666.jpg', '高狗一等', '2017-11-27 14:57:46'),
(128, 0, 6, 'img-15117946632.jpg', '探頭', '2017-11-27 14:57:43'),
(127, 0, 6, 'img-15117946541.jpg', '給我一個吻', '2017-11-27 14:57:34'),
(125, 0, 6, 'img-151179464410.jpg', '禁止毒貓狗', '2017-11-27 14:57:24'),
(123, 0, 6, 'img-15117946341.jpg', '優雅的美麗小姐', '2017-11-27 14:57:14'),
(122, 0, 6, 'img-15117946311.jpg', '龐大身軀擋鏡頭', '2017-11-27 14:57:11'),
(121, 0, 6, 'img-15117946215.jpg', '不要走啦', '2017-11-27 14:57:01'),
(120, 0, 6, 'img-15117946215.jpg', '大狗園', '2017-11-27 14:57:01'),
(147, 0, 2, 'img-15117949182.jpg', '夏日游泳池', '2017-11-27 15:01:59'),
(146, 0, 2, 'img-15117948986.jpg', '黑黑的小可愛', '2017-11-27 15:01:38'),
(143, 0, 2, 'img-15117948493.jpg', '躲貓貓', '2017-11-27 15:00:49'),
(142, 0, 2, 'img-15117948375.jpg', '懶洋洋曬太陽', '2017-11-27 15:00:38'),
(141, 0, 2, 'img-15117948201.jpg', '大大的擁抱', '2017-11-27 15:00:20'),
(139, 0, 2, 'img-15117947982.jpg', '大家都很黑', '2017-11-27 14:59:58'),
(161, 0, 5, 'img-15117951021.jpg', '疼惜', '2017-11-27 15:05:02'),
(160, 0, 5, 'img-15117950920.jpg', '貓咪治療屋', '2017-11-27 15:04:52'),
(157, 0, 5, 'img-15117950725.jpg', '默默照顧', '2017-11-27 15:04:32'),
(156, 0, 5, 'img-15117950689.jpg', '謝謝楊阿姨', '2017-11-27 15:04:28'),
(155, 0, 5, 'img-15117950636.jpg', '上門迎接', '2017-11-27 15:04:23'),
(154, 0, 5, 'img-15117950487.jpg', '小套房', '2017-11-27 15:04:08'),
(152, 0, 5, 'img-15117950339.jpg', '幼幼區', '2017-11-27 15:03:53'),
(174, 0, 3, 'img-15117952915.jpg', '裴家貓的狂犬病名牌', '2017-11-27 15:08:12'),
(172, 0, 3, 'img-15117952798.jpg', '貓掌萌暈你', '2017-11-27 15:08:00'),
(171, 0, 3, 'img-15117952670.jpg', '貓墻', '2017-11-27 15:07:48'),
(170, 0, 3, 'img-15117952591.jpg', '霸佔飼料及罐罐', '2017-11-27 15:07:39'),
(169, 0, 3, 'img-15117952528.jpg', '一個吊牌代表一隻貓咪', '2017-11-27 15:07:32'),
(167, 0, 3, 'img-15117952306.jpg', '凶神惡煞', '2017-11-27 15:07:10'),
(192, 0, 4, 'img-15117955208.jpg', '謝謝蕭媽媽', '2017-11-27 15:12:00'),
(191, 0, 4, 'img-15117955113.jpg', '鐵鏽斑駁的家', '2017-11-27 15:11:52'),
(190, 0, 4, 'img-151179549510.jpg', '觀察 警戒 好奇', '2017-11-27 15:11:35'),
(188, 0, 4, 'img-15117954835.jpg', '老舊的狗籠', '2017-11-27 15:11:24'),
(187, 0, 4, 'img-15117954693.jpg', '自己搭建起來的家', '2017-11-27 15:11:09'),
(185, 0, 4, 'img-15117954415.jpg', '特別瘦的牠', '2017-11-27 15:10:42'),
(114, 0, 1, 'img-151179432710.jpg', '剪耳右邊是女生喔', '2017-11-27 14:52:08'),
(115, 0, 1, 'img-15117943541.jpg', '哥倆感情好', '2017-11-27 14:52:34'),
(132, 0, 6, 'img-15117946839.jpg', '狗狗的伴手禮', '2017-11-27 14:58:03'),
(119, 0, 1, 'img-15117944829.jpg', '看!有飛碟', '2017-11-27 14:54:42'),
(134, 0, 6, 'img-15117946942.jpg', '姐姐葛葛來家庭訪問', '2017-11-27 14:58:14'),
(135, 0, 6, 'img-15117946994.jpg', '來一個大大的抱抱', '2017-11-27 14:58:19'),
(136, 0, 6, 'img-151179470410.jpg', '私人套房', '2017-11-27 14:58:24'),
(137, 0, 6, 'img-15117947067.jpg', '吃飯囉!', '2017-11-27 14:58:26'),
(138, 0, 6, 'img-15117947101.jpg', '伊莉莎白王子', '2017-11-27 14:58:30'),
(150, 0, 2, 'img-15117949522.jpg', '狂犬病標示牌', '2017-11-27 15:02:33'),
(162, 0, 5, 'img-15117951124.jpg', '看著我的你', '2017-11-27 15:05:12'),
(163, 0, 5, 'img-15117951175.jpg', '特殊設計', '2017-11-27 15:05:17'),
(164, 0, 5, 'img-15117951368.jpg', '挖寶喔', '2017-11-27 15:05:36'),
(165, 0, 5, 'img-15117951408.jpg', '前人種樹狗來乘涼', '2017-11-27 15:05:41'),
(166, 0, 5, 'img-15117951485.jpg', '初吻', '2017-11-27 15:05:49'),
(176, 0, 3, 'img-15117953094.jpg', '貴妃椅上斜臥', '2017-11-27 15:08:29'),
(177, 0, 3, 'img-15117953095.jpg', '媽媽幫我剃毛了', '2017-11-27 15:08:30'),
(178, 0, 3, 'img-15117953173.jpg', '最喜歡媽媽了', '2017-11-27 15:08:38'),
(179, 0, 3, 'img-15117953282.jpg', '看我一個華麗轉身', '2017-11-27 15:08:49'),
(180, 0, 3, 'img-15117953314.jpg', '眼睛大大蕊', '2017-11-27 15:08:52'),
(181, 0, 3, 'img-15117953384.jpg', '完美劈腿!', '2017-11-27 15:08:58'),
(183, 0, 3, 'img-15117953531.jpg', '有點想睡', '2017-11-27 15:09:13'),
(195, 0, 4, 'img-15117955508.jpg', '喝水的桶子', '2017-11-27 15:12:30'),
(196, 0, 4, 'img-151179556010.jpg', '跟台糖借的地', '2017-11-27 15:12:40'),
(197, 0, 4, 'img-15117955699.jpg', '被關在籠中', '2017-11-27 15:12:50'),
(198, 0, 4, 'img-15117955727.jpg', '喜悅與悲傷', '2017-11-27 15:12:52'),
(199, 1, 4, 'img-15118281657.jpg', '5天下來的成果9850元', '2017-11-28 00:16:05'),
(200, 1, 4, 'img-15118281651.jpg', '請注意右下角的黑色物體', '2017-11-28 00:16:05'),
(201, 1, 4, 'img-15118281667.jpg', 'Day1一中街在摩托車上擺攤', '2017-11-28 00:16:06'),
(202, 1, 4, 'img-15118281660.jpg', 'Day2.一早就在一中街擺攤了喔', '2017-11-28 00:16:06'),
(203, 1, 4, 'img-15118281677.jpg', 'Day2一日店長睡著啦', '2017-11-28 00:16:07'),
(204, 1, 4, 'img-15118281675.jpg', 'Day3攤位被風吹得亂七八糟', '2017-11-28 00:16:07'),
(205, 1, 4, 'img-15118281683.jpg', 'Day3兩白一黑的擺攤組合', '2017-11-28 00:16:08'),
(206, 1, 4, 'img-15118281681.jpg', 'Day4團服紅吱吱', '2017-11-28 00:16:08'),
(207, 1, 4, 'img-15118281699.jpg', '山城印刷店拿明信片', '2017-11-28 00:16:09'),
(208, 1, 4, 'img-15118281694.jpg', 'Day5義賣圓滿結束', '2017-11-28 00:16:09'),
(209, 1, 4, 'img-15118281698.jpg', '包裝明信片', '2017-11-28 00:16:09'),
(210, 1, 4, 'img-15118281700.jpg', '義賣Day1 台中文創園區', '2017-11-28 00:16:10'),
(211, 1, 4, 'img-151182817010.jpg', '明信片包裝趕工', '2017-11-28 00:16:10'),
(212, 1, 4, 'img-15118281709.jpg', '義賣第一天加碼一中街', '2017-11-28 00:16:10'),
(213, 1, 5, 'img-15118283181.jpg', '與SSPCA(沙磱越防止虐待動物協會)主席合影', '2017-11-28 00:18:38'),
(214, 1, 5, 'img-15118283186.jpg', '貓狗共生共榮的和諧景象', '2017-11-28 00:18:38'),
(215, 1, 5, 'img-15118283186.jpg', '抵達馬來西亞野生動物復育中心', '2017-11-28 00:18:38'),
(216, 1, 5, 'img-15118283189.jpg', '宴席上分享交流感受', '2017-11-28 00:18:39'),
(217, 1, 5, 'img-15118283197.jpg', '國際野生生物保護協會', '2017-11-28 00:18:39'),
(218, 1, 5, 'img-15118283202.jpg', '珮慈與協會待送養的狗狗握手', '2017-11-28 00:18:40'),
(219, 1, 5, 'img-15118283208.jpg', '華人動保，讓愛走出校園', '2017-11-28 00:18:40'),
(247, 0, 1, 'img-15197159985.jpg', '2018-02-11 15.28.00', '2018-02-27 07:19:58'),
(248, 0, 1, 'img-15197160714.jpg', '2018-02-11 15.27.34', '2018-02-27 07:21:11');

-- --------------------------------------------------------

--
-- 資料表結構 `listgallery`
--

CREATE TABLE IF NOT EXISTS `listgallery` (
  `lId` int(11) NOT NULL AUTO_INCREMENT,
  `lName` varchar(50) NOT NULL,
  `lOrder` int(11) NOT NULL DEFAULT '100',
  `lPicture` varchar(50) NOT NULL,
  PRIMARY KEY (`lId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 資料表的匯出資料 `listgallery`
--

INSERT INTO `listgallery` (`lId`, `lName`, `lOrder`, `lPicture`) VALUES
(4, '圓夢中的點點滴滴', 100, '20171128081543.jpg'),
(5, '番外篇—馬來西亞動保交流', 100, '20171128081822.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `mapcenter`
--

CREATE TABLE IF NOT EXISTS `mapcenter` (
  `mId` int(11) NOT NULL AUTO_INCREMENT,
  `mLat` text NOT NULL,
  `mLng` text NOT NULL,
  `mZoom` int(11) NOT NULL,
  PRIMARY KEY (`mId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `mapcenter`
--

INSERT INTO `mapcenter` (`mId`, `mLat`, `mLng`, `mZoom`) VALUES
(1, '24.255864', '120.812908', 12);

-- --------------------------------------------------------

--
-- 資料表結構 `operating`
--

CREATE TABLE IF NOT EXISTS `operating` (
  `oId` int(11) NOT NULL AUTO_INCREMENT,
  `oTitle` varchar(50) NOT NULL,
  `oContent` text NOT NULL,
  `oVideo` varchar(50) DEFAULT NULL,
  `oUipicture` varchar(50) NOT NULL,
  PRIMARY KEY (`oId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `operating`
--

INSERT INTO `operating` (`oId`, `oTitle`, `oContent`, `oVideo`, `oUipicture`) VALUES
(1, '網站如何運作的呢?', '您可以在網站上看見各個狗場的介紹，以及我們的實地採訪狗場主人的影片。<br />\r\n也可以案右上角(我要捐贈物資) 捐贈物資給狗場，以幫助他們照顧流浪貓狗。', NULL, '20170816074253.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `ourteam`
--

CREATE TABLE IF NOT EXISTS `ourteam` (
  `oId` int(11) NOT NULL AUTO_INCREMENT,
  `oName` varchar(10) NOT NULL,
  `oWork` varchar(50) NOT NULL,
  `oWorkcontent` text,
  `oPicture` varchar(50) NOT NULL,
  PRIMARY KEY (`oId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `ourteam`
--

INSERT INTO `ourteam` (`oId`, `oName`, `oWork`, `oWorkcontent`, `oPicture`) VALUES
(1, '游美芸', '指導老師', '帶領我們前往狗場，活動接洽', '123.jpg'),
(2, '黃怡卿', '攝影及照相、美工', '狗場採訪的攝影及照相、影片剪輯、布展設計及美工', '20171014145040.jpg'),
(3, '陳心潔', '企劃規劃及採訪、美工', '進行企劃規劃進行，並採訪狗場主人，整理資料與設計文創商品', '20180513132014.jpg'),
(4, '陳佑昇', '網頁設計、系統維護', '進行本網站的設計，設計後台管理並協助團隊影像美工技術', '20180513132138.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `pointalbum`
--

CREATE TABLE IF NOT EXISTS `pointalbum` (
  `pId` int(11) NOT NULL AUTO_INCREMENT,
  `pLdid` int(11) NOT NULL,
  `pName` varchar(50) NOT NULL,
  `pNote` text,
  `pStime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 資料表的匯出資料 `pointalbum`
--

INSERT INTO `pointalbum` (`pId`, `pLdid`, `pName`, `pNote`, `pStime`) VALUES
(25, 1, 'img-15264927034.jpg', '狗場中的小角落', '2018-05-16 17:45:03'),
(23, 1, 'img-152649262310.jpg', '我有182位家人喔!', '2018-05-16 17:43:43'),
(26, 1, 'img-152649270810.jpg', '夏日白雪胖狗', '2018-05-16 17:45:08'),
(22, 1, 'img-15264926237.jpg', '媽咪好辛苦', '2018-05-16 17:43:43'),
(27, 2, 'img-15264935887.jpg', '狗山狗海', '2018-05-16 17:59:48'),
(28, 2, 'img-15264935882.jpg', '跟緊緊', '2018-05-16 17:59:48'),
(29, 2, 'img-15264935880.jpg', '狗場', '2018-05-16 17:59:48'),
(30, 2, 'img-15264935888.jpg', '方拔拔魅力無限', '2018-05-16 17:59:48'),
(31, 3, 'img-15264942184.jpg', '再過來就呼你一巴掌喔', '2018-05-16 18:10:18'),
(32, 3, 'img-15264942199.jpg', '台中市狂犬病注射證明牌', '2018-05-16 18:10:19'),
(33, 3, 'img-15264942275.jpg', '裴阿姨跟長長的貓', '2018-05-16 18:10:27'),
(34, 3, 'img-152649422710.jpg', '媽媽我上電視了!', '2018-05-16 18:10:27'),
(35, 3, 'img-15264942325.jpg', '互相認識', '2018-05-16 18:10:32'),
(36, 4, 'img-15264945222.jpg', '蕭阿姨分享點點滴滴', '2018-05-16 18:15:22'),
(37, 4, 'img-15264945239.jpg', '蕭阿姨跟毛孩', '2018-05-16 18:15:23'),
(41, 4, 'img-15264945751.jpg', '沒有圍欄，狗狗只能被綁著', '2018-05-16 18:16:15'),
(40, 4, 'img-15264945699.jpg', '好久不見', '2018-05-16 18:16:09'),
(42, 5, 'img-15264948741.jpg', '回眸一笑', '2018-05-16 18:21:14'),
(43, 5, 'img-15264948750.jpg', '跟隨', '2018-05-16 18:21:15'),
(44, 5, 'img-15264948809.jpg', '小木屋', '2018-05-16 18:21:20'),
(45, 5, 'img-152649488110.jpg', '眾狗包圍', '2018-05-16 18:21:21'),
(46, 6, 'img-15264952540.jpg', '跟我玩嘛!', '2018-05-16 18:27:34'),
(47, 6, 'img-15264952554.jpg', '飛撲', '2018-05-16 18:27:35'),
(48, 6, 'img-15264952650.jpg', '牽牽手', '2018-05-16 18:27:45'),
(49, 6, 'img-15264952668.jpg', '林阿姨故事分享', '2018-05-16 18:27:46');

-- --------------------------------------------------------

--
-- 資料表結構 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `pId` int(11) NOT NULL AUTO_INCREMENT,
  `pTitle` text NOT NULL,
  `pPicture` varchar(50) NOT NULL,
  `pContent` text NOT NULL,
  `pType` int(11) NOT NULL,
  `pShow` int(11) NOT NULL,
  `pOutline` text,
  `pStime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pEtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `post`
--

INSERT INTO `post` (`pId`, `pTitle`, `pPicture`, `pContent`, `pType`, `pShow`, `pOutline`, `pStime`, `pEtime`) VALUES
(3, '踏浪團隊獲得台中女兒圓夢計畫優選唷！', '20180226222532.jpg', '<p><span style="font-size:18px;">「踏浪」我們得獎了～～～～</span></p>\r\n\r\n<p>為浪浪發聲、為默默守護著浪浪的愛媽發聲～～～<br />\r\n3個即將結束高中生涯的小女生，在大家都嚮往著自由高飛，妝點自己的身上的胭脂花容，她們竟然去寫了一個走訪狗場拜訪浪浪的計畫，請我擔任指導老師，與我一起討論在偏遠山區許多浪浪的桃花源。計畫總共在三個月將近12個假日完成，我們的足跡踏遍了「和平區」「東勢區」「太平區」「霧峰區」「后里區」，感謝動保處<a data-hovercard="/ajax/hovercard/user.php?id=100000170680732&amp;extragetparams=%7B%22fref%22%3A%22mentions%22%7D" data-hovercard-prefer-more-content-show="1" href="https://www.facebook.com/profile.php?id=100000170680732&amp;fref=mentions">洪惠雅</a>的資訊與經驗分享，感謝所有默默付出的愛爸、愛媽與支持他們的家人朋友，更感謝<a data-hovercard="/ajax/hovercard/user.php?id=100006667878590&amp;extragetparams=%7B%22fref%22%3A%22mentions%22%7D" data-hovercard-prefer-more-content-show="1" href="https://www.facebook.com/profile.php?id=100006667878590&amp;fref=mentions">陳心潔</a><a data-hovercard="/ajax/hovercard/user.php?id=100000558692752&amp;extragetparams=%7B%22fref%22%3A%22mentions%22%7D" data-hovercard-prefer-more-content-show="1" href="https://www.facebook.com/profile.php?id=100000558692752&amp;fref=mentions">黃珮慈</a><a data-hovercard="/ajax/hovercard/user.php?id=100000533111607&amp;extragetparams=%7B%22fref%22%3A%22mentions%22%7D" data-hovercard-prefer-more-content-show="1" href="https://www.facebook.com/profile.php?id=100000533111607&amp;fref=mentions">黃怡卿</a>非常認真努力的參與計畫義賣與默默協助我們製作網頁的高材生<a data-hovercard="/ajax/hovercard/user.php?id=100003176241792&amp;extragetparams=%7B%22fref%22%3A%22mentions%22%7D" data-hovercard-prefer-more-content-show="1" href="https://www.facebook.com/shane871112?fref=mentions">陳佑昇</a>，老師在你們身上看到太多的執著與不放棄的精神，你們讓我更有動力繼續為「動保教育紮根」，這是開始我們繼續播出種子期待在台灣這片土地上開花結果！關懷生命就從愛護動物開始！</p>\r\n\r\n<p style="text-align: right;">文：游美芸老師</p>\r\n\r\n<p style="text-align: right;">&nbsp;</p>\r\n\r\n<p><img alt="" src="/uploads/images/22489738_1507875982626235_7114758776445514338_n.jpg" />&nbsp; &nbsp; &nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp;<img alt="" src="/uploads/images/22365610_1507876015959565_196116738950162104_n.jpg" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/uploads/images/22406515_1507876459292854_583469621287194852_n.jpg" />&nbsp; &nbsp; &nbsp;&nbsp;</p>\r\n', 2, 0, '「踏浪」我們得獎了～～～<br />\r\n為浪浪發聲、為默默守護著浪浪的愛媽發聲', '2018-02-26 14:24:07', '2018-05-13 13:28:15'),
(4, '市長的話', '20180513214200.jpg', '<p>文:　台中市長／林佳龍</p>\r\n\r\n<p><meta charset="utf-8" /></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">今天是「台灣女孩日」,二年前,台中市政府設立了亞 洲第一座女孩專屬場所「台中女兒館」,也舉行「台中 女孩圓夢計畫」活動,讓女孩不但有自己的學習成長空 間,還有追夢的平台。</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">恭喜今年脫穎而出的10組女孩圓夢計畫。其中,優等獎 「踏浪」由黃珮慈、陳心潔、黃怡卿三位大一學生組 成,她們從高中時期就努力幫流浪動物捍衛權益。透過 圓夢計畫,她們分地區、分階段彙整全台中流浪動物的 收容需求,並建立網路平台招募資源,還自製精巧的明 信片義賣,甚至舉行巡迴分享會,希望喚起更多人的愛</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">年輕人有夢就去追!除了「踏浪」,還有其他圓夢計畫 也令人敬佩與感動。期待未來有更多夢想在台中實現, 讓這座城市更繽紛、更溫暖。</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">歡迎大家踴躍參觀圓夢成果特展,給這群認真的女孩們 加油打氣!</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">#圓夢成果特展:即日起至明年2月底於臺中女兒館(北 區太平路70號)展出。 http://臺中女兒館.tw/</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b id="docs-internal-guid-fd9084de-59b4-74cf-781c-33ebf78e8812">#FreedomForGirls</b></span></p>\r\n\r\n<p dir="ltr"><span style="font-family:微軟正黑體;"><b><img alt="" src="/uploads/images/22405903_1507874829293017_6858745870800919285_n(2).jpg" /></b></span></p>\r\n', 0, 1, '今天是「台灣女孩日」,二年前,台中市政府設立了亞洲第一座女孩專屬場所「台中女兒館」。', '2017-10-11 13:37:37', '2018-05-13 13:44:41');

-- --------------------------------------------------------

--
-- 資料表結構 `repdog`
--

CREATE TABLE IF NOT EXISTS `repdog` (
  `rId` int(11) NOT NULL AUTO_INCREMENT,
  `rLdid` int(11) NOT NULL,
  `rOrder` int(11) NOT NULL,
  `rName` varchar(30) NOT NULL,
  `rPicture` varchar(50) NOT NULL,
  `rGender` int(11) NOT NULL,
  `rAge` varchar(20) NOT NULL,
  `rIntroduction` text NOT NULL,
  `rStime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rEtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 資料表的匯出資料 `repdog`
--

INSERT INTO `repdog` (`rId`, `rLdid`, `rOrder`, `rName`, `rPicture`, `rGender`, `rAge`, `rIntroduction`, `rStime`, `rEtime`) VALUES
(5, 1, 3, '姐姐、黑寶', '20180514022027.jpg', 0, '7', '姊姊是從路邊的箱子撿到 ， 另外在他旁邊的是黑寶，是自己跑過來的，黃阿姨把黑寶當作姊姊的妹妹(他們除了很像，更常常黏在一起)', '2018-05-13 18:20:27', '2018-05-13 18:20:27'),
(3, 1, 1, '豬哥', '20180514013937.jpg', 1, '5', '很活潑的狗狗，因為鼻子很大所以叫豬哥，當初在東勢林場那附近被黃阿姨撿到，似乎是棄犬(只有看到他一隻)，因為那邊車多，擔心這隻狗狗危險就帶走了。', '2018-05-13 17:39:37', '2018-05-13 18:29:49'),
(4, 1, 2, '小寶貝', '20180514021604.jpg', 0, '6.5', '有一位好心的阿姨在大坑中山路撿到，但是他們家已經有一隻大狼狗了，麻煩黃阿姨照顧他，陪伴阿姨5年半的時間，至今似乎被丟包(無法聯繫主人)。', '2018-05-13 18:16:04', '2018-05-13 18:28:21');

-- --------------------------------------------------------

--
-- 資料表結構 `send`
--

CREATE TABLE IF NOT EXISTS `send` (
  `sId` int(11) NOT NULL AUTO_INCREMENT,
  `sOrder` int(11) NOT NULL DEFAULT '0',
  `sName` varchar(10) NOT NULL,
  `sContent` text NOT NULL,
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `send`
--

INSERT INTO `send` (`sId`, `sOrder`, `sName`, `sContent`) VALUES
(1, 1, '①  包裝物資', '<center>\r\n<h3 style="text-align: left;">為避免託運過程，包裝受損。</h3>\r\n\r\n<h3 style="text-align: left;">麻煩您檢查包裝是否完整、正常<span style="color:#800080;"><strong>(建議使用箱子包裝)</strong></span>。</h3>\r\n</center>\r\n'),
(2, 2, '②查詢運費', '<p><span style="font-size:18px;">可至以下網站查詢寄送運費</span></p>\r\n\r\n<p><span style="font-size:18px;">郵局包裹：<a href="https://www.post.gov.tw/post/internet/Postal/index.jsp?ID=2030103" target="_blank">https://www.post.gov.tw/post/internet/Postal/index.jsp?ID=2030103</a></span></p>\r\n\r\n<p><span style="font-size:18px;">大榮貨運：<a href="https://www.kerrytj.com/ZH/search/search_cost.aspx" target="_blank">https://www.kerrytj.com/ZH/search/search_cost.aspx</a></span></p>\r\n\r\n<p><span style="font-size:18px;">新竹貨運：<a href="https://www.hct.com.tw/Allocation/allocation_market.aspx" target="_blank">https://www.hct.com.tw/Allocation/allocation_market.aspx</a></span></p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(3, 3, '③準備寄送', '<p><span style="font-size:18px;">以下貨運提供線上託運（到府收件）的服務，郵局可自行與客服中心聯絡。</span></p>\r\n\r\n<p><span style="font-size:18px;">新竹貨運：<a href="http://webipick.hct.com.tw:8080/" target="_blank">http://webipick.hct.com.tw:8080/</a></span></p>\r\n\r\n<p><span style="font-size:18px;">大榮貨運：<a href="https://www.kerrytj.com/ZH/search/search_online.aspx" target="_blank">https://www.kerrytj.com/ZH/search/search_online.aspx</a></span></p>\r\n\r\n<p><span style="font-size:20px;"><strong>下方有寄件資料，方便您進行複製貼上。</strong></span></p>\r\n'),
(4, 4, '④寄送完成', '<p>&nbsp;</p>\r\n\r\n<p><span style="color:#000000;"><span style="font-size:26px;">我們在收到您的愛心物資後，會與您電話聯絡確認，並登錄資料至本網站的芳名錄中。</span></span></p>\r\n\r\n<p><span style="color:#000000;"><span style="font-size:26px;">再次謝謝您的愛心<img alt="laugh" height="23" src="http://go.sshs.tc.edu.tw/ck/ckeditor/plugins/smiley/images/teeth_smile.png" title="laugh" width="23" /></span></span></p>\r\n');

-- --------------------------------------------------------

--
-- 資料表結構 `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `sId` int(11) NOT NULL AUTO_INCREMENT,
  `sOrder` int(11) NOT NULL DEFAULT '1',
  `sPicture` varchar(50) NOT NULL,
  `sPosition` int(11) NOT NULL,
  `sTitle` text NOT NULL,
  `sContent` text NOT NULL,
  `sScale` int(11) NOT NULL,
  `sButtonname` varchar(30) DEFAULT NULL,
  `sButtonlink` text,
  `sSdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sCdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `sId` (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `slider`
--

INSERT INTO `slider` (`sId`, `sOrder`, `sPicture`, `sPosition`, `sTitle`, `sContent`, `sScale`, `sButtonname`, `sButtonlink`, `sSdate`, `sCdate`) VALUES
(4, 1, '20170825234426.jpg', 1, '<br>串起一句山-踏浪', '我們將台中山區的私人狗場蒐集整理成一幅愛心狗場地圖<br />\r\n目的是為了讓更多人知道狗場愛爸愛媽的處境', 104, '了解更多', 'dogpoint-grid-full-width.php', '2017-08-25 15:44:27', '2017-11-15 13:38:25'),
(2, 2, 'slider-bg-02.JPG', 2, '我們需要您的愛心', '狗場中有許多流浪狗正等待著你的愛心捐助，牠們需要你的愛心', 108, '開始捐贈', 'collectstation.php', '2017-06-28 07:14:30', '2017-11-15 13:38:03'),
(3, 3, 'slider-bg-03.JPG', 3, '來看看我們的最新消息', '最新消息區全新開幕!來看看喔~~~', 100, '點我查看', 'pages-blog.php', '2017-06-28 07:23:55', '2017-11-15 13:39:00');

-- --------------------------------------------------------

--
-- 資料表結構 `thingstable`
--

CREATE TABLE IF NOT EXISTS `thingstable` (
  `tId` int(11) NOT NULL AUTO_INCREMENT,
  `tName` varchar(50) NOT NULL,
  PRIMARY KEY (`tId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 資料表的匯出資料 `thingstable`
--

INSERT INTO `thingstable` (`tId`, `tName`) VALUES
(41, '跳蚤藥'),
(40, '狗籠子'),
(39, '棉被'),
(1, '其它'),
(38, '狗罐頭'),
(37, '狗飼料(袋裝)'),
(42, '貓飼料'),
(43, '貓砂');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uId` int(11) NOT NULL AUTO_INCREMENT,
  `uAccount` varchar(50) NOT NULL,
  `uPassword` varchar(50) NOT NULL,
  `uLevel` varchar(10) NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`uId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`uId`, `uAccount`, `uPassword`, `uLevel`) VALUES
(1, 'admin', 'Server12323', 'admin');

-- --------------------------------------------------------

--
-- 資料表結構 `webfaq`
--

CREATE TABLE IF NOT EXISTS `webfaq` (
  `wId` int(11) NOT NULL AUTO_INCREMENT,
  `wQuestion` text NOT NULL,
  `wAnswer` text NOT NULL,
  PRIMARY KEY (`wId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `webfaq`
--

INSERT INTO `webfaq` (`wId`, `wQuestion`, `wAnswer`) VALUES
(1, '這些狗場地址聯絡方式為何不能公布?', '我們為了保障狗場主人的隱私不公該狗場聯絡方式，有必要情況可請集貨站代為聯絡。'),
(3, '你們設計網站花了多少時間?是用現成的嗎?', '以下是我們的網站開發史，網站介面有取得廉價的付費模板加以修改，其餘全部手工(想起來可超辛苦的..)<br>\r\n開發史：https://bit.ly/2GcGVUv'),
(4, '如何進行相關的問題提問呢?', '狗場相關問題可至「我要捐贈物資」，進入集貨站的主頁，透過留言或連絡電話方式進行聯絡。若是對我們網站有任何問題，可以到「訊息發布」的右側找到問題箱，匿名與我們發問喔~\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
