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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ads WHERE ads_id=%s",
                       GetSQLValueString($_GET['delete'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($deleteSQL, $connect) or die(mysql_error());
}

$maxRows_ads = 10;
$pageNum_ads = 0;
if (isset($_GET['pageNum_ads'])) {
  $pageNum_ads = $_GET['pageNum_ads'];
}
$startRow_ads = $pageNum_ads * $maxRows_ads;

mysql_select_db($database_connect, $connect);
if(!isset($_SESSION['admin'])){
$query_ads = "SELECT * FROM ads WHERE user_id='$userlog' ORDER BY ads_id DESC";
} else {
$query_ads = "SELECT * FROM ads ORDER BY ads_id DESC";
}
$query_limit_ads = sprintf("%s LIMIT %d, %d", $query_ads, $startRow_ads, $maxRows_ads);
$ads = mysql_query($query_limit_ads, $connect) or die(mysql_error());
$row_ads = mysql_fetch_assoc($ads);

if (isset($_GET['totalRows_ads'])) {
  $totalRows_ads = $_GET['totalRows_ads'];
} else {
  $all_ads = mysql_query($query_ads);
  $totalRows_ads = mysql_num_rows($all_ads);
}
$totalPages_ads = ceil($totalRows_ads/$maxRows_ads)-1;

$queryString_ads = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ads") == false && 
        stristr($param, "totalRows_ads") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ads = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ads = sprintf("&totalRows_ads=%d%s", $totalRows_ads, $queryString_ads);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="668" border="0" align="center" class="table">
  <tr>
    <th>تنظیمات : </th>
    <th>مدل :</th>
    <th>پسوند :</th>
    <th>رنگ :</th>
    <th>سوخت :</th>
    <th>دنده :</th>
    <th>نام زیر دسته :</th>	
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="index_user.php?page=listads&delete=<?php echo $row_ads['ads_id']; ?>" onclick="return confirm('آیا مایل به حذف این مورد هستید ؟');">[ حذف کردن ]</a> - 
      <a href="index_user.php?page=updateads&ads_id=<?php echo $row_ads['ads_id']; ?>">[ ویرایش کردن ]</a></td>
      <td><?php echo $row_ads['model']; ?>&nbsp; </td>
      <td><?php echo $row_ads['passvand']; ?>&nbsp; </td>
      <td><?php echo $row_ads['rang']; ?>&nbsp; </td>
      <td><?php echo $row_ads['sokht']; ?>&nbsp; </td>
      <td><?php echo $row_ads['dande']; ?>&nbsp; </td>
      <td>
	  <?php 
	  $s = $row_ads['sub_id']; 
	  $q = mysql_query("SELECT * FROM subcat WHERE sub_id='$s'");
	  $f = mysql_fetch_assoc($q);
	  echo $f['subname'];
	  ?>      </td>
    </tr>
    <?php } while ($row_ads = mysql_fetch_assoc($ads)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_ads > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ads=%d%s", $currentPage, 0, $queryString_ads); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ads > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ads=%d%s", $currentPage, max(0, $pageNum_ads - 1), $queryString_ads); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ads < $totalPages_ads) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ads=%d%s", $currentPage, min($totalPages_ads, $pageNum_ads + 1), $queryString_ads); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_ads < $totalPages_ads) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ads=%d%s", $currentPage, $totalPages_ads, $queryString_ads); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_ads + 1) ?> to <?php echo min($startRow_ads + $maxRows_ads, $totalRows_ads) ?> of <?php echo $totalRows_ads ?>
</body>
</html>
<?php
mysql_free_result($ads);
?>
