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

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM subcat WHERE sub_id=%s",
                       GetSQLValueString($_GET['delete'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($deleteSQL, $connect) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sub = 10;
$pageNum_sub = 0;
if (isset($_GET['pageNum_sub'])) {
  $pageNum_sub = $_GET['pageNum_sub'];
}
$startRow_sub = $pageNum_sub * $maxRows_sub;

mysql_select_db($database_connect, $connect);
$query_sub = "SELECT * FROM subcat ORDER BY cat_id DESC";
$query_limit_sub = sprintf("%s LIMIT %d, %d", $query_sub, $startRow_sub, $maxRows_sub);
$sub = mysql_query($query_limit_sub, $connect) or die(mysql_error());
$row_sub = mysql_fetch_assoc($sub);

if (isset($_GET['totalRows_sub'])) {
  $totalRows_sub = $_GET['totalRows_sub'];
} else {
  $all_sub = mysql_query($query_sub);
  $totalRows_sub = mysql_num_rows($all_sub);
}
$totalPages_sub = ceil($totalRows_sub/$maxRows_sub)-1;

$queryString_sub = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sub") == false && 
        stristr($param, "totalRows_sub") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sub = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sub = sprintf("&totalRows_sub=%d%s", $totalRows_sub, $queryString_sub);
?>
<table width="607" border="0" align="center" class="table">
  <tr>
    <th width="235">تنظیمات :</th>
    <th width="195">نام دسته :</th>
    <th width="163">نام زیر دسته :</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="index_user.php?page=listsub&delete=<?php echo $row_sub['sub_id']; ?>" onclick="return confirm('آیا مایل به حذف این مورد هستید ؟');"> [ حذف کردن ]</a> - <a href="index_user.php?page=subupdate&sub_id=<?php echo $row_sub['sub_id']; ?>">[ ویرایش کردن ]</a>&nbsp; </td>
      <td><?php $cat_id = $row_sub['cat_id']; 
	  $q1 = mysql_query("SELECT * FROM category WHERE cat_id='$cat_id'");
	  $f1 = mysql_fetch_assoc($q1);
	  echo $f1['catname'];
	  ?>&nbsp; </td>
      <td><?php echo $row_sub['subname']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_sub = mysql_fetch_assoc($sub)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_sub > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_sub=%d%s", $currentPage, 0, $queryString_sub); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_sub > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_sub=%d%s", $currentPage, max(0, $pageNum_sub - 1), $queryString_sub); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_sub < $totalPages_sub) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_sub=%d%s", $currentPage, min($totalPages_sub, $pageNum_sub + 1), $queryString_sub); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_sub < $totalPages_sub) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_sub=%d%s", $currentPage, $totalPages_sub, $queryString_sub); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_sub + 1) ?> to <?php echo min($startRow_sub + $maxRows_sub, $totalRows_sub) ?> of <?php echo $totalRows_sub ?>
<?php
mysql_free_result($sub);
?>
<div class="cl"></div>
