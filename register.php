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
  $insertSQL = sprintf("INSERT INTO users (firstname, lastname, province, city, website, email, phone, address, password) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['province'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());

	echo "<div class='success'>ثبت نام شما با موفقیت انجام ، هم اکنون میتوانید وارد سایت شوید</div>";
}
?>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.title; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' درست وارد کنید \n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' باید عدد باشد \n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' باید وارد شود\n'; }
    } if (errors) alert('لطفا خطاهای زیر را بررسی کنید \n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
<div>
	<h1>کاربر محترم لطفا برای ثبت نام در سایت فرم زیر را کامل کنید .</h1>
</div>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="MM_validateForm('firstname','','R','lastname','','R','province','','R','city','','R','email','','RisEmail','phone','','RisNum','password','','R','repassword','','R');return document.MM_returnValue">
  <table width="445" align="center" class="dir">
    <tr valign="baseline">
      <td width="116" align="right" nowrap="nowrap">نام :</td>
      <td width="317"><input name="firstname" type="text" id="firstname" title="نام" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام خانوادگی :</td>
      <td><input name="lastname" type="text" id="lastname" title="نام خانوادگی" value=""/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">استان :</td>
      <td><input name="province" type="text" id="province" title="استان" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">شهر :</td>
      <td><input name="city" type="text" id="city" title="شهر" value=""  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">وب سایت :</td>
      <td><input type="text" name="website" value="http://" size="32" dir="ltr" title="وب سایت" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">پست الکترونیکی :</td>
      <td><input name="email" type="text" id="email" title="پست الکترونیکی" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">تلفن :</td>
      <td><input name="phone" type="text" id="phone"  title="تلفن" value=""/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">آدرس :</td>
      <td><textarea name="address" cols="50" rows="5" title="آدرس پستی"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">رمز عبور :</td>
      <td><input name="password" type="password" id="password" title="رمز عبور" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">تکرار رمز عبور :</td>
      <td><input name="repassword" type="password" id="repassword" title="رمز عبور" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ثبت نام در سایت" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
