<?php
if(!isset($_SESSION['admin'])){
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
  $updateSQL = sprintf("UPDATE subcat SET cat_id=%s, subname=%s WHERE sub_id=%s",
                       GetSQLValueString($_POST['cat_id'], "int"),
                       GetSQLValueString($_POST['subname'], "text"),
                       GetSQLValueString($_POST['sub_id'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
}

mysql_select_db($database_connect, $connect);
$subID = $_GET['sub_id'];
$query_sub = "SELECT * FROM subcat WHERE sub_id='$subID' ORDER BY subname DESC";
$sub = mysql_query($query_sub, $connect) or die(mysql_error());
$row_sub = mysql_fetch_assoc($sub);
$totalRows_sub = mysql_num_rows($sub);

mysql_select_db($database_connect, $connect);
$query_cat = "SELECT * FROM category ORDER BY catname DESC";
$cat = mysql_query($query_cat, $connect) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" class="dir">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام دسته :</td>
      <td><select name="cat_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_cat['cat_id']?>" <?php if (!(strcmp($row_cat['cat_id'], htmlentities($row_sub['cat_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_cat['catname']?></option>
        <?php
} while ($row_cat = mysql_fetch_assoc($cat));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام زیر دسته 	:</td>
      <td><input type="text" name="subname" value="<?php echo htmlentities($row_sub['subname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ویرایش کردن" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="sub_id" value="<?php echo $row_sub['sub_id']; ?>" />
</form>
<?php
mysql_free_result($sub);

mysql_free_result($cat);
?>
