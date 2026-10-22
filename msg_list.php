<?php
if(!isset($_SESSION['admin'])){
	exit();
}
?>
<?php require_once('Connections/connect.php'); ?>
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
  $deleteSQL = sprintf("DELETE FROM vp WHERE vp_id=%s",
                       GetSQLValueString($_GET['delete'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($deleteSQL, $connect) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_msg = 10;
$pageNum_msg = 0;
if (isset($_GET['pageNum_msg'])) {
  $pageNum_msg = $_GET['pageNum_msg'];
}
$startRow_msg = $pageNum_msg * $maxRows_msg;

mysql_select_db($database_connect, $connect);
$query_msg = "SELECT * FROM vp ORDER BY user_id DESC";
$query_limit_msg = sprintf("%s LIMIT %d, %d", $query_msg, $startRow_msg, $maxRows_msg);
$msg = mysql_query($query_limit_msg, $connect) or die(mysql_error());
$row_msg = mysql_fetch_assoc($msg);

if (isset($_GET['totalRows_msg'])) {
  $totalRows_msg = $_GET['totalRows_msg'];
} else {
  $all_msg = mysql_query($query_msg);
  $totalRows_msg = mysql_num_rows($all_msg);
}
$totalPages_msg = ceil($totalRows_msg/$maxRows_msg)-1;

$queryString_msg = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_msg") == false && 
        stristr($param, "totalRows_msg") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_msg = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_msg = sprintf("&totalRows_msg=%d%s", $totalRows_msg, $queryString_msg);
?>
<table width="681" border="0" align="center" class="table" dir="rtl">
  <tr>
    <th>تنظیمات :</th>
    <th>نمایش مشخصات کاربر :</th>
    <th>موضوع پیغام :</th>
    <th>تاریخ ارسال :</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="index_user.php?page=msg&delete=<?php echo $row_msg['vp_id']; ?>" onclick="return confirm('آیا مایل به حذف این مورد هستید ؟');">[ حذف کردن ]</a></td>
      <td>
        <?php 
	  if($row_msg['user_id'] == 0){ 
	  ?>
        <a href="user_detail.php?msgID=<?php echo $row_msg['vp_id']; ?>" target="_blank"> [ نمایش مشخصات فرستده ]&nbsp; </a>
        <?php
	  } else {
	  ?>
        <a href="user_detail.php?recordID=<?php echo $row_msg['user_id']; ?>" target="_blank"> [ نمایش مشخصات فرستده ]&nbsp; </a>
        <?php
	  }
	  ?>
      </td>
      <td><a href="msg_detail.php?recordID=<?php echo $row_msg['vp_id']; ?>" target="_blank"><?php echo $row_msg['subject']; ?></a></td>
      <td><?php echo $row_msg['date']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_msg = mysql_fetch_assoc($msg)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_msg > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_msg=%d%s", $currentPage, 0, $queryString_msg); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_msg > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_msg=%d%s", $currentPage, max(0, $pageNum_msg - 1), $queryString_msg); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_msg < $totalPages_msg) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_msg=%d%s", $currentPage, min($totalPages_msg, $pageNum_msg + 1), $queryString_msg); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_msg < $totalPages_msg) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_msg=%d%s", $currentPage, $totalPages_msg, $queryString_msg); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<div class="cl"></div>
Records <?php echo ($startRow_msg + 1) ?> to <?php echo min($startRow_msg + $maxRows_msg, $totalRows_msg) ?> of <?php echo $totalRows_msg ?>
<?php
mysql_free_result($msg);
?>
