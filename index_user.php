<?php
session_start();
?>
<?php require_once('Connections/connect.php'); ?>
<?php

mysql_select_db($database_connect, $connect);
if(isset($_POST['quicksearch'])){
	header("location:".$_POST['quicksearch']);
}
$userlog = $_SESSION['userid'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>نیازمندی های خودرو</title>
<link rel="stylesheet" href="styles/main.css"  />
</head>
<body>
<div class="main mainWidth">
  <div class="header">
    <div class="miniSearch">
    <form action="" method="post">
      <div class="pad">
        <div style="color:#900; padding-bottom:10px;">جستجوی سریع</div>
        <div>نام خودرو :
          <div style="padding-top:5px; padding-bottom:3px;">
          <select name="quicksearch">
            <?php 
					$query_subs = mysql_query("SELECT * FROM subcat,category WHERE subcat.cat_id=category.cat_id order by subcat.cat_id");
					while ($row_subs = mysql_fetch_assoc($query_subs)){
					?>
            <option value="index.php?cat_id=<?php echo $row_subs['cat_id']; ?>&sub_id=<?php echo $row_subs['sub_id']; ?>" ><?php echo $row_subs['catname']; ?> - <?php echo $row_subs['subname']?></option>
            <?php
					} 
					?>
          </select>
        </div>
        </div>
        <div class="goSearch" style="padding-top:3px;">
          <input type="image" src="images/gosearch.jpg" name="go" class="goBtn" />
        </div>
      </div>
    </form>
    </div>
    <div class="mainMenu">
      <ul>
        <li><a href="index.php">صفحه اصلی</a></li>
        <li><a href="index_register.php">ثبت نام در سایت</a></li>
        <?php if(isset($_SESSION['userid'])){ ?><li><a href="index_user.php?page=addads">ثبت آگهی فروش</a></li><?php } ?>
        <li><a href="index_msg.php">نظرات</a></li>
      </ul>
    </div>
    <?php
	if(isset($_SESSION['userid'])){
		$uid = $_SESSION['userid'];
		$q = mysql_query("SELECT * FROM users WHERE user_id='$uid'");
		$f = mysql_fetch_assoc($q);
	?>
    <div class="dir" style="padding-right:30px;">کاربر محترم <span class="red"><?php echo $f['firstname']; ?> <?php echo $f['lastname']; ?></span><br />به <a href="index_user.php">سیستم مدیریتی</a> خود خوش آمدید<br />
    <a href="logout.php">+ خروج از سیستم</a></div>
    <?php
	}
	?>  </div>
  <div class="cl"></div>
  <div class="content">
    <div class="cl ps1">
    <?php if(isset($_SESSION['admin'])): ?><a href="index_user.php?page=addcat">وارد کردن دسته جدید</a> | 
    <a href="index_user.php?page=listcat">مدیریت دسته ها</a> | 
    <a href="index_user.php?page=addsub">وارد کردن زیر دسته جدید</a> | 
    <a href="index_user.php?page=listsub">مدیریت زیر دسته ها</a> | <?php endif; ?>
    <a href="index_user.php?page=addads">وارد کردن خودرو</a> | 
    <a href="index_user.php?page=listads">لیست خودرو های وارد شده</a> | 
    <a href="index_user.php?page=useraccount">تغییر مشخصات</a> |
    <?php if(isset($_SESSION['admin'])): ?><a href="index_user.php?page=users">لیست کاربران</a> | 
    <a href="index_user.php?page=msg">مدیریت نظرات</a> |<?php endif; ?> 
    </div>
    
    <div class="contents" style="padding-top:20px;">
   	<?php
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		switch($page){
			case "addcat":
				require_once("cat.php");
				break;
				
			case "listcat":
				require_once("cat_list.php");
				break;
				
			case "catupdate":
				require_once("cat_update.php");
				break;
				
			case "subupdate":
				require_once("sub_update.php");
				break;
				
			case "updateads":
				require_once("ads_update.php");
				break;		
				
			case "addsub":
				require_once("subcat.php");
				break;
				
			case "listsub":
				require_once("sub_list.php");
				break;
				
			case "addads":
				require_once("ads.php");
				break;
				
			case "listads":
				require_once("ads_list.php");
				break;
				
			case "useraccount":
				require_once("user_update.php");
				break;
				
			case "users":
				require_once("user_list.php");
				break;
				
			case "msg":
				require_once("msg_list.php");
				break;
		}
	}
	?>
    </div>
  </div>
</div>
<div class="mainWidth">
<div class="content" style="text-align:center;"><div class="dir" style="padding-top:3px;">قدرت گرفته از : <span class="red"><a href="http://www.netparadis.com/car/" title="سیستم حراجی خودرو"> Persian CAR CMS</a></span><br />
  <div class="dir" style="padding-top:3px;">تمامی حقوق متعلق به این سایت می باشد و هر گونه کپی برداری پیگرد قانونی دارد</div>
</div>
</div>
<div>&nbsp;</div>
</body>
</html>