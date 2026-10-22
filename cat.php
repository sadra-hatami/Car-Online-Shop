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


  $insertSQL = sprintf("INSERT INTO category (catname) VALUES (%s)",
                       GetSQLValueString($_POST['catname'], "text"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());
	$lastID = mysql_insert_id();
	if($_FILES['image']['name'] !=""){
		$source = $_FILES['image']['tmp_name'];
		if($_FILES['image']['type'] == "image/pjpeg"){
			$stype = "jpg";
		} elseif($_FILES['image']['type'] == "image/gif") {
			$stype = "gif";
		}
		$dest = "images/cats/".$lastID.".jpg";
		thumb(40, 40, $source, $stype, $dest);
	}

  echo "<div class='success'>با موفقیت اضافه شد</div>";
  
}
?>
<h1>کاربر محترم لطفا برای اضافه کردن دسته جدید فرم زیر را کامل کنید </h1>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table class="dir" align="right">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">نام دسته : </td>
      <td><input type="text" name="catname" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="file" name="image" id="image" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ثبت دسته" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<div class="cl"></div>