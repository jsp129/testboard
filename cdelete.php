<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$con = mysqli_connect("localhost", "root", "apmsetup", "class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

$wdate = $_GET['wdate'];
$id = $_GET['id'];
$board = $_GET['board'];

mysqli_query($con, "DELETE FROM memojang WHERE wdate='$wdate' AND id=$id");
echo "<script>alert('댓글이 삭제되었습니다.');</script>";
echo "<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>";

mysqli_close($con);
?>
</body>
</html>