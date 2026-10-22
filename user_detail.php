<?php require_once('Connections/connect.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_connect, $connect);
if(isset($_GET['msgID'])){
	$query_DetailRS1 = sprintf("SELECT * FROM vp WHERE vp_id = %s ORDER BY user_id DESC", GetSQLValueString($_GET['msgID'], "int"));
} elseif(isset($_GET['recordID'])){
	$query_DetailRS1 = sprintf("SELECT * FROM users WHERE user_id = %s ORDER BY user_id DESC", GetSQLValueString($colname_DetailRS1, "int"));
}

$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $connect) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
body {
	font-family:Tahoma, Geneva, sans-serif;
	font-size:11px;
}
.asd {
	color: #900;
}
</style>
</head>

<body>
<h1 align="center">مشخصات کاربر انتخاب شده</h1>
<?php
if(isset($_GET['recordID'])){
?>
<table border="0" align="center" dir="rtl">
  <tr>
    <td>شماره : </td>
    <td><?php echo $row_DetailRS1['user_id']; ?></td>
  </tr>
  <tr class="asd">
    <td>نام : </td>
    <td><?php echo $row_DetailRS1['firstname']; ?></td>
  </tr>
  <tr>
    <td>نام خانوادگی : </td>
    <td><?php echo $row_DetailRS1['lastname']; ?></td>
  </tr>
  <tr class="asd">
    <td>استان : </td>
    <td><?php echo $row_DetailRS1['province']; ?></td>
  </tr>
  <tr>
    <td>شهر : </td>
    <td><?php echo $row_DetailRS1['city']; ?></td>
  </tr>
  <tr class="asd">
    <td>وب سایت : </td>
    <td><?php echo $row_DetailRS1['website']; ?></td>
  </tr>
  <tr>
    <td>پست الکترونیکی : </td>
    <td><?php echo $row_DetailRS1['email']; ?></td>
  </tr>
  <tr class="asd">
    <td>تلفن : </td>
    <td><?php echo $row_DetailRS1['phone']; ?></td>
  </tr>
  <tr>
    <td>آدرس : </td>
    <td><?php echo $row_DetailRS1['address']; ?></td>
  </tr>
</table>
<?php
} else if(isset($_GET['msgID'])){
?>
<table width="303" border="0" align="center" dir="rtl">
  <tr class="asd">
    <td>نام : </td>
    <td><?php echo $row_DetailRS1['name']; ?></td>
  </tr>
  <tr>
    <td>نام خانوادگی : </td>
    <td><?php echo $row_DetailRS1['family']; ?></td>
  </tr>
  <tr class="asd">
    <td>پست الکترونیکی : </td>
    <td><?php echo $row_DetailRS1['email']; ?></td>
  </tr>
  <tr>
    <td>تلفن : </td>
    <td><?php echo $row_DetailRS1['phone']; ?></td>
  </tr>
</table>
<?php
}
?>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>