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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM category WHERE cat_id=%s",
                       GetSQLValueString($_GET['delete'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($deleteSQL, $connect) or die(mysql_error());
}

$maxRows_category = 10;
$pageNum_category = 0;
if (isset($_GET['pageNum_category'])) {
  $pageNum_category = $_GET['pageNum_category'];
}
$startRow_category = $pageNum_category * $maxRows_category;

mysql_select_db($database_connect, $connect);
$query_category = "SELECT * FROM category ORDER BY cat_id DESC";
$query_limit_category = sprintf("%s LIMIT %d, %d", $query_category, $startRow_category, $maxRows_category);
$category = mysql_query($query_limit_category, $connect) or die(mysql_error());
$row_category = mysql_fetch_assoc($category);

if (isset($_GET['totalRows_category'])) {
  $totalRows_category = $_GET['totalRows_category'];
} else {
  $all_category = mysql_query($query_category);
  $totalRows_category = mysql_num_rows($all_category);
}
$totalPages_category = ceil($totalRows_category/$maxRows_category)-1;

$queryString_category = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_category") == false && 
        stristr($param, "totalRows_category") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_category = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_category = sprintf("&totalRows_category=%d%s", $totalRows_category, $queryString_category);
?>
<table width="465" border="0" align="center" class="table">
  <tr>
    <th>تنظیمات :</th>
    <th>نام دسته :</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="index_user.php?page=listcat&delete=<?php echo $row_category['cat_id']; ?>" onclick="return confirm('آیا مایل به حذف این مورد هستید ؟');">[ حذف کردن ]</a> - <a href="index_user.php?page=catupdate&cat_id=<?php echo $row_category['cat_id']; ?>">[ ویرایش کردن ]</a></td>
      <td><?php echo $row_category['catname']; ?>&nbsp;</td>
    </tr>
    <?php } while ($row_category = mysql_fetch_assoc($category)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_category > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_category=%d%s", $currentPage, 0, $queryString_category); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_category > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_category=%d%s", $currentPage, max(0, $pageNum_category - 1), $queryString_category); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_category < $totalPages_category) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_category=%d%s", $currentPage, min($totalPages_category, $pageNum_category + 1), $queryString_category); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_category < $totalPages_category) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_category=%d%s", $currentPage, $totalPages_category, $queryString_category); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_category + 1) ?> to <?php echo min($startRow_category + $maxRows_category, $totalRows_category) ?> of <?php echo $totalRows_category ?>
<?php
mysql_free_result($category);
?>
