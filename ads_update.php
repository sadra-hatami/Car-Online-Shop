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
  $updateSQL = sprintf("UPDATE ads SET model=%s, passvand=%s, karkerd=%s, vaziyat=%s, gheymat=%s, rang=%s, rangtodozi=%s, sokht=%s, dande=%s, ezafi=%s, sub_id=%s, user_id=%s WHERE ads_id=%s",
                       GetSQLValueString($_POST['model'], "int"),
                       GetSQLValueString($_POST['passvand'], "text"),
                       GetSQLValueString($_POST['karkerd'], "int"),
                       GetSQLValueString($_POST['vaziyat'], "int"),
                       GetSQLValueString($_POST['gheymat'], "int"),
                       GetSQLValueString($_POST['rang'], "text"),
                       GetSQLValueString($_POST['rangtodozi'], "text"),
                       GetSQLValueString($_POST['sokht'], "text"),
                       GetSQLValueString($_POST['dande'], "text"),
                       GetSQLValueString($_POST['ezafi'], "text"),
                       GetSQLValueString($_POST['sub_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['ads_id'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
}

mysql_select_db($database_connect, $connect);
$adsID = (int)$_GET['ads_id'];
$query_ads = "SELECT * FROM ads WHERE ads_id='$adsID' ORDER BY user_id DESC";
$ads = mysql_query($query_ads, $connect) or die(mysql_error());
$row_ads = mysql_fetch_assoc($ads);
$totalRows_ads = mysql_num_rows($ads);

mysql_select_db($database_connect, $connect);
$query_sub = "SELECT * FROM subcat ORDER BY subname DESC";
$sub = mysql_query($query_sub, $connect) or die(mysql_error());
$row_sub = mysql_fetch_assoc($sub);
$totalRows_sub = mysql_num_rows($sub);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="right" class="dir">
    <tr valign="baseline">
      <td width="95" align="right" nowrap="nowrap">مدل :</td>
      <td><input type="text" name="model" value="<?php echo htmlentities($row_ads['model'], ENT_COMPAT, 'utf-8'); ?>" size="4" />
      برای مثال 1388</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">پسوند :</td>
      <td><input type="text" name="passvand" value="<?php echo htmlentities($row_ads['passvand'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">کارکرد :</td>
      <td><input type="text" name="karkerd" value="<?php echo htmlentities($row_ads['karkerd'], ENT_COMPAT, 'utf-8'); ?>" /> 
        کیلومتر</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">وضعیت :</td>
      <td><select name="vaziyat">
        <option value="1" <?php if (!(strcmp('صفر', htmlentities($row_ads['vaziyat'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>صفر</option>
        <option value="2" <?php if (!(strcmp('دسته دوم', htmlentities($row_ads['vaziyat'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>کارکرده</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">قیمت :</td>
      <td><input type="text" name="gheymat" value="<?php echo htmlentities($row_ads['gheymat'], ENT_COMPAT, 'utf-8'); ?>" /> 
      تومان</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">رنگ :</td>
      <td><input type="text" name="rang" value="<?php echo htmlentities($row_ads['rang'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">رنگ تودوزی :</td>
      <td><input type="text" name="rangtodozi" value="<?php echo htmlentities($row_ads['rangtodozi'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">سوخت :</td>
      <td><select name="sokht">
        <option value="1" <?php if (!(strcmp('بنزین', htmlentities($row_ads['sokht'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>بنزین</option>
        <option value="2" <?php if (!(strcmp('گازسوز', htmlentities($row_ads['sokht'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>گازسوز</option>
        <option value="3" <?php if (!(strcmp('دوگانه سوز', htmlentities($row_ads['sokht'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>دوگانه سوز</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">دنده :</td>
      <td><select name="dande">
        <option value="1" <?php if (!(strcmp('دستی', htmlentities($row_ads['dande'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>دستی</option>
        <option value="2" <?php if (!(strcmp('اتومات', htmlentities($row_ads['dande'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>اتومات</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">موارد اضافی :</td>
      <td><textarea name="ezafi" cols="50" rows="5"><?php echo $row_ads['ezafi']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">مدل ماشین :</td>
      <td><select name="sub_id">
        <?php
do {  
?>
        <option value="<?php echo $row_sub['sub_id']?>"<?php if (!(strcmp($row_sub['sub_id'], htmlentities($row_ads['sub_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_sub['subname']?></option>
        <?php
} while ($row_sub = mysql_fetch_assoc($sub));
  $rows = mysql_num_rows($sub);
  if($rows > 0) {
      mysql_data_seek($sub, 0);
	  $row_sub = mysql_fetch_assoc($sub);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ویرایش کردن" /></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo htmlentities($row_ads['user_id'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ads_id" value="<?php echo $row_ads['ads_id']; ?>" />
</form>
<div class="cl"></div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ads);

mysql_free_result($sub);
?>
