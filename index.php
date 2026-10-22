<?php require_once('Connections/connect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index_user.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connect, $connect);
  
  $LoginRS__query=sprintf("SELECT * FROM users WHERE email=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $f1 = mysql_fetch_assoc($LoginRS);
  if ($loginFoundUser) { 
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	$_SESSION['userid'] = $f1['user_id'];
	if($f1['access'] == 2){
		$_SESSION['admin'] = true;
	}
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: index.php?action=invalid");
  }
}
?>
<?php 
mysql_select_db($database_connect, $connect);
if(isset($_POST['quicksearch'])){
	header("location:".$_POST['quicksearch']);
}
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
    <div class="dir" style="padding-right:30px;">کاربر محترم <span class="red"><?php echo $f['firstname']; ?> <?php echo $f['lastname']; ?></span><br />به <a href="index_user.php">سیستم مدیریتی </a>خود خوش آمدید<br />
    <a href="logout.php">+ خروج از سیستم</a></div>
    <?php
	}
	?>
  </div>
  <div class="cl"></div>
  <div class="content">
  <?php if(isset($_GET['action']) and $_GET['action'] == "invalid"){ ?><div class="error">پست الکترونیکی و رمز عبور اشتباه است ، لطفا دوباره سعی کنید </div><?php } ?>
  	<div class="rightBlock">
    	<div class="search">
          <h1>جستجوی خودرو : </h1>
            <div>
              <form id="form1" name="form1" method="post" action="index.php">
                <table align="right" class="dir">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">مدل :</td>
                    <td><input name="model" type="text" value="" size="4" maxlength="4" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">پسوند :</td>
                    <td><input name="passvand" type="text" value="" size="10" maxlength="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">کارکرد :</td>
                    <td><input name="karkerd" type="text" value="" size="10" maxlength="15" /> 
                    کیلومتر</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">وضعیت :</td>
                    <td><select name="vaziyat">
                      <option value="">[ همه ]</option>
                      <option value="صفر">صفر</option>
                      <option value="دسته دوم">دسته دوم</option>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">حد اکثر قیمت :</td>
                    <td><input name="gheymat" type="text" value="" size="10" maxlength="15" /> 
                    تومان</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">رنگ :</td>
                    <td><input name="rang" type="text" value="" size="10" maxlength="20" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">رنگ تودوزی :</td>
                    <td><input name="rangtodozi" type="text" value="" size="10" maxlength="20" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">سوخت :</td>
                    <td><select name="sokht">
                    <option value="">[ همه ]</option>
                    <option value="بنزین">بنزین</option>
                    <option value="گازسوز">گازسوز</option>
                    <option value="دوگانه سوز">دوگانه سوز</option>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">دنده :</td>
                    <td><select name="dande">
                    <option value="">[ همه ]</option>
                    <option value="دستی">دستی</option>
                    <option value="اتومات">اتومات</option>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">مدل ماشین :</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="2" align="right" nowrap="nowrap" style="padding:2px;"><select name="sub_id">
                    <option value="">[ همه ]</option>
                      <?php 
					$query_subs = mysql_query("SELECT * FROM subcat,category WHERE subcat.cat_id=category.cat_id order by subcat.cat_id");
					while ($row_subs = mysql_fetch_assoc($query_subs)){
					?>
                      <option value="<?php echo $row_subs['sub_id']?>" ><?php echo $row_subs['catname']; ?> - <?php echo $row_subs['subname']?></option>
                      <?php
					} 
					?>
                    </select><input type="hidden" name="search" value="true" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="2" align="right" nowrap="nowrap"><span class="goSearch" style="padding-top:3px;">
                      <input type="image" src="images/gosearch.jpg" name="go2" class="goBtn" />
                    </span></td>
                  </tr>
                </table>
              </form>
            </div>
    	</div>
        <div class="cl">&nbsp;</div>
      <div class="login">
        	<div><h1>ورود کاربران سایت :</h1></div>
            <div>
              <form id="login" name="login" method="POST" action="<?php echo $loginFormAction; ?>">
                <table align="right" class="dir">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ایمیل : </td>
                    <td><input name="username" type="text" id="username" value="" size="15" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">رمز عبور :</td>
                    <td><input name="password" type="password" id="password" value="" size="15" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ورو به سایت :</td>
                    <td><span class="goSearch" style="padding-top:3px;">
                      <input type="image" src="images/gosearch.jpg" name="go3" class="goBtn" />
                    </span></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="2" align="right" nowrap="nowrap"><ul>
                      <li><a href="index_register.php"> ثبت نام در سایت</a></li>
                    </ul></td>
                  </tr>
                </table>
              </form>
            </div>
      </div>
    </div>
    <div class="leftBlock">
    <?php if(!isset($_GET['cat_id'])){ ?>
    <div>
      <h1>آخرین موارد اضافه شده :</h1>
      <?php
			
			if(isset($_POST['search'])){
				$model = $_POST['model'];
				$passvand = $_POST['passvand'];
				$karkerd = $_POST['karkerd'];
				$vaziyat = $_POST['vaziyat'];
				$gheymat = $_POST['gheymat'];
				$rang = $_POST['rang'];
				$rangtodozi = $_POST['rangtodozi'];
				$sokht = $_POST['sokht'];
				$dande = $_POST['dande'];
				$sub_id = $_POST['sub_id'];
				
				$string = "SELECT * FROM ads WHERE 1=1 ";
				if($model !="")
					$string .= "and model='$model'";
				
				if($passvand !="")
					$string .= "and passvand like '%$passvand%'";
				
				if($karkerd !="")
					$string .= "and karkerd between 0 and $karkerd";
				
				if($vaziyat !="")
					$string .= "and vaziyat='$vaziyat'";
				
				if($gheymat !="")
					$string .= "and gheymat between 0 and $gheymat";
				
				if($rang !="")
					$string .= "and rang like '%$rang%'";
				
				if($rangtodozi !="")
					$string .= "and rangtodozi like '%$rangtodozi%'";
				
				if($sokht !="")
					$string .= "and sokht='$sokht'";
				
				if($dande !="")
					$string .= "and dande='$dande'";
				
				if($sub_id !="")
					$string .= "and sub_id='$sub_id'";
					
					//echo $string;
				
				$queryLast = mysql_query($string) or die(mysql_error());
			} else {
				$queryLast = mysql_query("SELECT * FROM ads order by `ads_id` DESC limit 0,4") or die(mysql_error());
			}
			while($row_last = mysql_fetch_assoc($queryLast)){
				
				$sub_id = $row_last['sub_id'];
				$q1 = mysql_query("SELECT * FROM subcat WHERE sub_id='$sub_id'") or die(mysql_error());
				$f1 = mysql_fetch_assoc($q1);
			?>
      <div class="lastcatBox">
        <div class="center"><img src="images/cars/<?php echo $row_last['ads_id']; ?>.jpg" alt="" title="" /></div>
        <div style="padding-top:5px;" class="center"><a href="?cat_id=<?php echo $f1['cat_id']; ?>&amp;sub_id=<?php echo $row_last['sub_id']; ?>&amp;ads_id=<?php echo $row_last['ads_id']; ?>"> <?php echo $row_last['passvand']; ?>
          <?php
					$subid = $row_last['sub_id'];
					$q2 = mysql_query("SELECT * FROM subcat WHERE sub_id='$subid'");
					$f2 = mysql_fetch_assoc($q2);
					echo $f2['subname'];
					?>
        </a></div>
        <div class="center">مدل <?php echo $row_last['model']; ?></div>
        <div class="si1 center"><?php echo $row_last['gheymat']; ?> تومان</div>
      </div>
      <?php
			}
			?>
      <div class="cl"></div>
    </div>
    <div>
    <div>&nbsp;</div>
      <h1>پربازدیدترین موارد اضافه شده :</h1>
      <?php
			$queryLast = mysql_query("SELECT * FROM ads order by `clicks` DESC limit 0,4") or die(mysql_error());
			while($row_last = mysql_fetch_assoc($queryLast)){
				
				$sub_id = $row_last['sub_id'];
				$q1 = mysql_query("SELECT * FROM subcat WHERE sub_id='$sub_id'") or die(mysql_error());
				$f1 = mysql_fetch_assoc($q1);
			?>
      <div class="lastcatBox">
        <div class="center"><img src="images/cars/<?php echo $row_last['ads_id']; ?>.jpg" alt="" title="" /></div>
        <div style="padding-top:5px;" class="center"><a href="?cat_id=<?php echo $f1['cat_id']; ?>&amp;sub_id=<?php echo $row_last['sub_id']; ?>&amp;ads_id=<?php echo $row_last['ads_id']; ?>"> <?php echo $row_last['passvand']; ?>
          <?php
					$subid = $row_last['sub_id'];
					$q2 = mysql_query("SELECT * FROM subcat WHERE sub_id='$subid'");
					$f2 = mysql_fetch_assoc($q2);
					echo $f2['subname'];
					?>
        </a></div>
        <div class="center">مدل <?php echo $row_last['model']; ?></div>
        <div class="si1 center"><?php echo $row_last['gheymat']; ?> تومان</div>
      </div>
      <?php
			}
			?>
      <div class="cl"></div>
    </div>
<div class="cl"></div>
        <div class="category" style="padding-top:20px;">
        <?php } else { ?>
        <div class="category">
        <?php } ?>
        	<h1>لیست نام کارخانه های سازنده ی خودرو : </h1>
            <?php
			if(isset($_GET['cat_id'])){
				$getCat = $_GET['cat_id'];
				$query = mysql_query("SELECT * FROM category WHERE cat_id='$getCat' order by `cat_id` DESC") or die(mysql_error());
			} else {
				$query = mysql_query("SELECT * FROM category order by `cat_id` DESC") or die(mysql_error());
			}
			while($row_cat = mysql_fetch_assoc($query)){
			?>
            <div class="catBox">
              <table width="100%" border="0">
                <tr>
                  <td width="74%" class="dir"><a href="?cat_id=<?php echo $row_cat['cat_id']; ?>"><?php echo $row_cat['catname']; ?></a> (
                  <?php
				  $catIDs = $row_cat['cat_id'];
				  $q = mysql_query("SELECT * FROM subcat WHERE cat_id='$catIDs'");
				  echo mysql_num_rows($q);
				  ?>
                  )</td>
                  <td width="26%"><img src="images/cats/<?php echo $row_cat['cat_id']; ?>.jpg" width="40" height="40" /></td>
                </tr>
              </table>
            </div>
            <?php
			}
			?>
        </div>
        <?php if(isset($_GET['cat_id'])): ?>
        <div class="cl"></div>
        <div class="dir">
        	<ul>
            	<?php
				$getCat = $_GET['cat_id'];
				$qs = mysql_query("SELECT * FROM subcat WHERE cat_id='$getCat'");
				while($row_subs = mysql_fetch_assoc($qs)){
				?>
            	<li><a href="?cat_id=<?php echo $_GET['cat_id']; ?>&amp;sub_id=<?php echo $row_subs['sub_id']; ?>"><?php echo $row_subs['subname']; ?></a></li>
                <?php
				}
				?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="cl"></div>
        <div class="products">
        <?php
		if(isset($_GET['sub_id'])){
		?>
        	<div><h1>لیست خودرو های یافت شده :</h1></div>
            <?php } ?>
            <div class="productList">
            <?php
			$subIDs = $_GET['sub_id'];
			if(!isset($_GET['ads_id'])){
				$qc = mysql_query("SELECT * FROM ads WHERE ads.sub_id='$subIDs' order by `ads_id` DESC");
			} else {
				$adsID = $_GET['ads_id'];
				$qc = mysql_query("SELECT * FROM ads WHERE ads_id='$adsID' and ads.sub_id='$subIDs' order by `ads_id` DESC");
			}
			$count = mysql_num_rows($qc);
			if($count == 0 && isset($_GET['sub_id'])){
			?>
			<div class="error">هیچ محصولی برای نمایش وجود ندازد</div>
			<?php
			}
			while($row_cars = mysql_fetch_assoc($qc)){
			?>
            <div>&nbsp;</div>
                <div>
                	<div align="right"><img src="images/cars/<?php echo $row_cars['ads_id']; ?>.jpg" alt="" title="" /></div>
                    <div class="right">&nbsp;</div>
                    <div style="padding-top:5px;" class="right"><a href="?cat_id=<?php echo $_GET['cat_id']; ?>&amp;sub_id=<?php echo $_GET['sub_id']; ?>&amp;ads_id=<?php echo $row_cars['ads_id']; ?>">
					<?php echo $row_cars['passvand']; ?>
                    <?php
					$subid = $row_cars['sub_id'];
					$q2 = mysql_query("SELECT * FROM subcat WHERE sub_id='$subid'");
					$f2 = mysql_fetch_assoc($q2);
					echo $f2['subname'];
					?>
                    </a></div>
                    <div class="right">مدل <?php echo $row_cars['model']; ?></div>
                    <div class="si1 right"><?php echo $row_cars['gheymat']; ?> تومان</div>
                    <div><img src="images/cars/<?php echo $row_cars['ads_id']; ?>_big.jpg" alt="" title="" /></div>
                </div>
            <?php
			}
			?>
            <?php
			if(isset($_GET['ads_id'])): 
			?>
            <?php
			$adsIDs = $_GET['ads_id'];
			$query_ads = mysql_query("SELECT * FROM ads WHERE ads_id='$adsIDs'") or die(mysql_error());
			$q = mysql_query("UPDATE ads SET clicks=ads.clicks+1 WHERE ads_id='$adsID'") or die(mysql_error());
			$row_ads = mysql_fetch_assoc($query_ads);
			?>
             <div class="cl">&nbsp;</div>
             <div>
             	<h1><img src="images/icon.gif" /> مشخصات کامل خودرو : </h1>
                <div class="cl">
                  <table width="500" align="right" class="dir" cellpadding="1">
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">تعداد نمایش :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['clicks']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">تاریخ اضافه شدن :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['date']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td width="112" align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">مدل :</td>
                      <td width="376" bgcolor="#ffffff"><?php echo $row_ads['model']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">پسوند :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['passvand']; ?></td>
                    </tr>
                    <tr valign="baseline" bgcolor="#eeeeee">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">کارکرد :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['karkerd']; ?> کیلومتر</td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">وضعیت :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['vaziyat']; ?></td>
                    </tr>
                    <tr valign="baseline" bgcolor="#eeeeee">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">قیمت :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['gheymat']; ?> تومان</td>
                    </tr>
                    <tr valign="baseline" bgcolor="#eeeeee">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">قیمت های پیشنهادی :</td>
                      <td bgcolor="#ffffff">
                      	<?php
						$ads_id = $_GET['ads_id'];
						$q = mysql_query("SELECT * FROM haraji,users WHERE haraji.user_id=users.user_id and ads_id='$ads_id' order by `price` DESC limit 0,5");
						echo "<ul>";
						while($row_h = mysql_fetch_assoc($q)){
							echo "<a href='user_detail.php?recordID=".$row_h['user_id']."' target='_blank'><li title='".$row_h['comment']."' style='cursor:pointer;'>".$row_h['firstname']." ".$row_h['lastname']." - ".$row_h['price']." تومان </li></a>";
						}
						echo "</ul>";
						?>
                      </td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">رنگ :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['rang']; ?></td>
                    </tr>
                    <tr valign="baseline" bgcolor="#eeeeee">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">رنگ تودوزی :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['rangtodozi']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">سوخت :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['sokht']; ?></td>
                    </tr>
                    <tr valign="baseline" bgcolor="#eeeeee">
                      <td align="right" nowrap="nowrap" bgcolor="#ffffff" class="blue">دنده :</td>
                      <td bgcolor="#ffffff"><?php echo $row_ads['dande']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap" bgcolor="#ffffff" class="blue">موارد اضافی :</td>
                      <td bgcolor="#ffffff"><?php echo nl2br($row_ads['ezafi']); ?></td>
                    </tr>
                  </table>
                </div>
             </div>
           	<?php
				$userID = $row_ads['user_id'];
				$query_users = mysql_query("SELECT * FROM users WHERE user_id='$userID'") or die(mysql_error());
				$row_users = mysql_fetch_assoc($query_users);
            ?>
          </div>
                <div class="cl">&nbsp;</div>
                <div>
                	<h1><img src="images/icon.gif" /> مشخصات کامل فروشنده : </h1>
                    <div>
                      <table width="333" align="right" class="dir">
                        <tr>
                          <td class="blue">نام :</td>
                          <td><?php echo $row_users['firstname']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">نام خانوادگی :</td>
                          <td><?php echo $row_users['lastname']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">استان محل زندگی :</td>
                          <td><?php echo $row_users['province']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">شهر محل زندگی :</td>
                          <td><?php echo $row_users['city']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">وب سایت شخصی :</td>
                          <td><?php echo $row_users['website']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">پست الکترونیکی :</td>
                          <td><?php echo $row_users['email']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">تلفن :</td>
                          <td><?php echo $row_users['phone']; ?></td>
                        </tr>
                        <tr>
                          <td class="blue">آدرس محل سکونت :</td>
                          <td><?php echo $row_users['address']; ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="cl"></div>
                    <div>
                    <div>&nbsp;</div>
                    <?php if(isset($_SESSION['userid'])){ ?><h1>ثبت نطرات و قیمت پیشنهادی :</h1><?php } ?>
                    <div>
                      <form id="form2" name="form2" method="post" action="">
                      <?php
					  if(isset($_POST['price'])){
						  $ads_id = $_GET['ads_id'];
						  $user_id = $_SESSION['userid'];
						  $price = $_POST['price'];
						  $comment = $_POST['comment'];
						  $query = mysql_query("INSERT INTO haraji (ads_id,user_id,price,comment) VALUES ('$ads_id','$user_id','$price','$comment')") or die(mysql_error());
						  if($query){
						  ?>
                          <div class="success">این نظر با موفقیت برای نیازمندی مورد نظر اضافه شد</div>
                          <div>&nbsp;</div>
						  <?php
						  } 
					  }
					  ?>
                        <table width="351" border="0" align="right"<?php if(!isset($_SESSION['userid'])){ ?> style="display:none;" <?php } ?>>
                          <tr>
                            <td width="257">تومان <input type="text" name="price" id="price" /></td>
                            <td width="121" dir="rtl">قیمت پیشنهادی :</td>
                          </tr>
                          <tr>
                            <td><label>
                              <textarea name="comment" id="comment" cols="45" rows="5" dir="rtl"></textarea>
                            </label></td>
                            <td dir="rtl">نظرات :</td>
                          </tr>
                          <tr>
                            <td><input type="submit" name="button" id="button" value="ثبت قیمت و نظر" /></td>
                            <td dir="rtl">&nbsp;</td>
                          </tr>
                        </table>
                      </form>
                    </div>
                    </div>
      </div>
               <?php endif; ?>
        </div>
    </div>
    <div class="cl"></div>
  </div>
  <div class="cl"></div>
  </div>
</div>
<div class="mainWidth">
<div class="content" style="text-align:center;"><div class="dir" style="padding-top:3px;">قدرت گرفته از : <span class="red"><a href="http://www.netparadis.com/car/" title="سیستم حراجی خودرو"> Persian CAR CMS</a></span><br />
  <div class="dir" style="padding-top:3px;">تمامی حقوق متعلق به این سایت می باشد و هر گونه کپی برداری پیگرد قانونی دارد</div>
</div>
</body>
</html>