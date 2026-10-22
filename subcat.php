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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO subcat (cat_id, subname) VALUES (%s, %s)",
                       GetSQLValueString($_POST['cat_id'], "int"),
                       GetSQLValueString($_POST['subname'], "text"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());
  
  echo "<div class='success'>با موفقیت اضافه شد</div>";

}

mysql_select_db($database_connect, $connect);
$query_cars = "SELECT * FROM category ORDER BY cat_id DESC";
$cars = mysql_query($query_cars, $connect) or die(mysql_error());
$row_cars = mysql_fetch_assoc($cars);
$totalRows_cars = mysql_num_rows($cars);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" dir="rtl">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام دسته :</td>
      <td><select name="cat_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_cars['cat_id']?>" ><?php echo $row_cars['catname']?></option>
        <?php
} while ($row_cars = mysql_fetch_assoc($cars));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام زیر شاخه :</td>
      <td><input type="text" name="subname" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ذخیره کردن" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<?php
mysql_free_result($cars);
?>
