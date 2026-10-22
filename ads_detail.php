<?php
session_start();
if(!isset($_SESSION['userid'])){
	exit();
}
?>
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
$query_DetailRS1 = sprintf("SELECT * FROM ads WHERE ads_id = %s ORDER BY ads_id DESC", GetSQLValueString($colname_DetailRS1, "int"));
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
</head>

<body>

<table width="310" border="1" align="center" dir="rtl">
  <tr>
    <td width="98">شماره :</td>
    <td width="196"><?php echo $row_DetailRS1['ads_id']; ?></td>
  </tr>
  <tr>
    <td>مدل :</td>
    <td><?php echo $row_DetailRS1['model']; ?></td>
  </tr>
  <tr>
    <td>پسوند :</td>
    <td><?php echo $row_DetailRS1['passvand']; ?></td>
  </tr>
  <tr>
    <td>کارکرد :</td>
    <td><?php echo $row_DetailRS1['karkerd']; ?></td>
  </tr>
  <tr>
    <td>وضعیت :</td>
    <td><?php echo $row_DetailRS1['vaziyat']; ?></td>
  </tr>
  <tr>
    <td>قیمت :</td>
    <td><?php echo $row_DetailRS1['gheymat']; ?></td>
  </tr>
  <tr>
    <td>رنگ :</td>
    <td><?php echo $row_DetailRS1['rang']; ?></td>
  </tr>
  <tr>
    <td>رنگ تودوزی :</td>
    <td><?php echo $row_DetailRS1['rangtodozi']; ?></td>
  </tr>
  <tr>
    <td>سوخت :</td>
    <td><?php echo $row_DetailRS1['sokht']; ?></td>
  </tr>
  <tr>
    <td>دنده :</td>
    <td><?php echo $row_DetailRS1['dande']; ?></td>
  </tr>
  <tr>
    <td>لوازم اضافی :</td>
    <td><?php echo $row_DetailRS1['ezafi']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>