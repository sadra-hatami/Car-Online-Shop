<?php
if(!isset($_SESSION['userid'])){
	exit();
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $date = @date("Y-m-d H:i:s");
  $insertSQL = sprintf("INSERT INTO ads (model, passvand, karkerd, vaziyat, gheymat, rang, rangtodozi, sokht, dande, ezafi, sub_id, user_id,date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['model'], "int"),
                       GetSQLValueString($_POST['passvand'], "text"),
                       GetSQLValueString($_POST['karkerd'], "int"),
                       GetSQLValueString($_POST['vaziyat'], "int"),
                       GetSQLValueString($_POST['gheymat'], "int"),
                       GetSQLValueString($_POST['rang'], "text"),
                       GetSQLValueString($_POST['rangtodozi'], "text"),
                       GetSQLValueString($_POST['sokht'], "int"),
                       GetSQLValueString($_POST['dande'], "text"),
                       GetSQLValueString($_POST['ezafi'], "text"),
                       GetSQLValueString($_POST['sub_id'], "int"),
                       GetSQLValueString($userlog, "int"),
					   GetSQLValueString($date, "date"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());
  
  
	$lastID = mysql_insert_id();
	if($_FILES['image']['name'] !=""){
		$source = $_FILES['image']['tmp_name'];
		$stype = "jpg";
		$dest = "images/cars/".$lastID.".jpg";
		$dest2 = "images/cars/".$lastID."_big.jpg";
		thumb(100, 100, $source, $stype, $dest);
		thumb(500, 500, $source, $stype, $dest2);
	}
	
	echo "<div class='success'>با موفقیت اضافه شد</div>";

}

mysql_select_db($database_connect, $connect);
$query_cars = "SELECT * FROM subcat ORDER BY sub_id DESC";
$cars = mysql_query($query_cars, $connect) or die(mysql_error());
$row_cars = mysql_fetch_assoc($cars);
$totalRows_cars = mysql_num_rows($cars);
?>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.title; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' باید عدد باشد \n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' باید کامل شود \n'; }
  } if (errors) alert('لطفا پیغام های زیر را بررسی کنید \n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="MM_validateForm('model','','RisNum','passvand','','R','karkerd','','RisNum','gheymat','','RisNum','rang','','R','rangtodozi','','R','ezafi','','R');return document.MM_returnValue">
  <table width="596" align="right" class="dir">
    <tr valign="baseline">
      <td width="95" align="right" nowrap="nowrap">مدل :</td>
      <td width="489"><input name="model" type="text" title="مدل" size="4" maxlength="4" /> 
        برای مثال 1388</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">پسوند :</td>
      <td><input name="passvand" type="text" title="پسوند" value="" size="10" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">کارکرد :</td>
      <td><input name="karkerd" type="text" title="کارکرد" value="" size="10" maxlength="11" /> 
        کیلومتر</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">وضعیت :</td>
      <td><select name="vaziyat">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>صفر</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>دسته دوم</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">قیمت :</td>
      <td><input name="gheymat" type="text"  title="قیمت" value="" size="12" maxlength="12"/> 
        تومان</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">رنگ :</td>
      <td><input name="rang" type="text" title="رنگ" value="" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">رنگ تودوزی :</td>
      <td><input name="rangtodozi" type="text" title="تودوزی" value="" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">سوخت :</td>
      <td><select name="sokht">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>بنزین</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>گازسوز</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>دوگانه سوز</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">دنده :</td>
      <td><select name="dande">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>دستی</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>اتومات</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">موارد اضافی :</td>
      <td><textarea name="ezafi" cols="50" rows="5" title="موارد اضافی"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">مدل ماشین :</td>
      <td><span style="padding-top:5px; padding-bottom:3px;">
        <select name="sub_id" id="sub_id">
          <?php 
					$query_subs = mysql_query("SELECT * FROM subcat,category WHERE subcat.cat_id=category.cat_id order by subcat.cat_id");
					while ($row_subs = mysql_fetch_assoc($query_subs)){
					?>
          <option value="<?php echo $row_subs['sub_id']; ?>"><?php echo $row_subs['catname']; ?> - <?php echo $row_subs['subname']?></option>
          <?php
					} 
					?>
        </select>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">تصویر خودرو :</td>
      <td><input type="file" name="image" id="image" /></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ثبت آگهی" /></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<div class="cl"></div>
<?php
mysql_free_result($cars);
?>
