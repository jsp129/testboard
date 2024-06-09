<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$wname = $_POST['wname'] ?? '';
$wmemo = $_POST['wmemo'] ?? '';

if (!$wname){
    echo("<script>window.alert('이름이 없습니다. 다시 입력하세요')</script>");
    echo("<script>history.go(-1)</script>");
    exit;
}
if (!$wmemo){
    echo("<script>window.alert('댓글내용이 없습니다. 다시 입력하세요')</script>");
    echo("<script>history.go(-1)</script>");
    exit;
}

$con = mysqli_connect("localhost","root","apmsetup","class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

$id = $_GET['id'] ?? '';
$wdate = $_GET['wdate'] ?? '';
$board = $_GET['board'] ?? '';

$mwdate = date("Y-m-d-H:i:s"); //글 수정한 날짜 저장

mysqli_query($con, "UPDATE memojang SET name='$wname', message='$wmemo', wdate='$mwdate' WHERE id=$id AND wdate='$wdate'");
echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>");

mysqli_close($con);
?>
</body>
</html>