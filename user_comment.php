<?php session_start(); require_once('Connections/connect.php'); ?>
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
  if(!isset($_SESSION['userid'])){
	  $date = @date("Y-m-d H:i:s");
	  $insertSQL = sprintf("INSERT INTO vp (subject, `comment`, user_id,date,name,family,phone,email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['subject'], "text"),
						   GetSQLValueString($_POST['comment'], "text"),
						   GetSQLValueString("0", "int"),
						   GetSQLValueString($date, "text"),
	  					   GetSQLValueString($_POST['name'], "text"),
						   GetSQLValueString($_POST['family'], "text"),
						   GetSQLValueString($_POST['phone'], "int"),
						   GetSQLValueString($_POST['email'], "text"));
  } else {
	  $date = @date("Y-m-d H:i:s");
	  $insertSQL = sprintf("INSERT INTO vp (subject, `comment`, user_id,date) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($_POST['subject'], "text"),
						   GetSQLValueString($_POST['comment'], "text"),
						   GetSQLValueString($userLog, "int"),
						   GetSQLValueString($date, "text"));
  }

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());
	
	echo "<div class='success'>پیغام شما با موفقیت برای مدیر سیستم به ثبت رسید</div>";
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
<div><h1>کاربر محترم لطفا برا ارسال پیغام و ارسال نظرات خود به مدیر سیستم فرم زیر را کامل کنید .</h1></div>
<?php if(!isset($_SESSION['userid'])){ ?>
<form method="post" name="form1" id="form1" onSubmit="MM_validateForm('name','','R','family','','R','phone','','RisNum','email','','RisEmail','subject','','R','comment','','R');return document.MM_returnValue">
<?php } else { ?>
<form method="post" name="form1" id="form1" onSubmit="MM_validateForm('subject','','R','comment','','R');return document.MM_returnValue">
<?php } ?>
  <table align="center" class="dir">
  <?php
  if(!isset($_SESSION['userid'])){
  ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام :</td>
      <td><input type="text" name="name" id="name" title="نام" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام خانوادگی :</td>
      <td><input type="text" name="family" id="family" title="نام خانوادگی" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">تلفن :</td>
      <td><input type="text" name="phone" id="phone" title="تلفن" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">پست الکترونیکی :</td>
      <td><input type="text" name="email" id="email" title="پست الکترونیکی" /></td>
    </tr>
    <?php
  }
  ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">موضوع پیغام :</td>
      <td><input name="subject" type="text" id="subject" value="" size="50" title="موضوع پیغام" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">متن پیغام :</td>
      <td><textarea name="comment" id="comment" cols="70" rows="10" title="متن پیغام"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ثبت پیغام" />
      <input name="Reset" type="reset" value="خالی کردن فرم" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>