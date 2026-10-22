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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET firstname=%s, lastname=%s, province=%s, city=%s, website=%s, email=%s, phone=%s, address=%s, password=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['province'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
}

mysql_select_db($database_connect, $connect);
$userID = $userlog;
$query_users = "SELECT * FROM users WHERE user_id='$userID' ORDER BY user_id DESC";
$users = mysql_query($query_users, $connect) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="333" align="right" class="dir">
    <tr valign="baseline">
      <td width="116" align="right" nowrap="nowrap">نام :</td>
      <td width="205"><input type="text" name="firstname" value="<?php echo htmlentities($row_users['firstname'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام خانوادگی :</td>
      <td><input type="text" name="lastname" value="<?php echo htmlentities($row_users['lastname'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">استان :</td>
      <td><input type="text" name="province" value="<?php echo htmlentities($row_users['province'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">شهر :</td>
      <td><input type="text" name="city" value="<?php echo htmlentities($row_users['city'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">وب سایت :</td>
      <td><input name="website" type="text" value="<?php echo htmlentities($row_users['website'], ENT_COMPAT, 'utf-8'); ?>" size="30" dir="ltr" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">پست الکترونیکی :</td>
      <td><input name="email" type="text" value="<?php echo htmlentities($row_users['email'], ENT_COMPAT, 'utf-8'); ?>" size="30" dir="ltr" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">تلفن :</td>
      <td><input type="text" name="phone" value="<?php echo htmlentities($row_users['phone'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">آدرس :</td>
      <td><input name="address" type="text" value="<?php echo htmlentities($row_users['address'], ENT_COMPAT, 'utf-8'); ?>" size="70" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap" class="red">اگر مایل به تغییر رمز عبور هستید این قسمت را کامل کنید . </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">رمز عبور جدید : </td>
      <td><input type="password" name="password" value="<?php echo htmlentities($row_users['password'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ویرایش اطلاعات" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="user_id" value="<?php echo $row_users['user_id']; ?>" />
</form>
<div class="cl"></div>
<?php
mysql_free_result($users);
?>
