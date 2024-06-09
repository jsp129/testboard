<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
function check($message) {
    echo "<script>alert(\"$message\"); history.go(-1);</script>";
    exit;
}

$wname = $_POST['wname'];
$wmemo = $_POST['wmemo'];
$wpasswd = $_POST['wpasswd'];

if (!$wname) check("이름을 입력하세요");
if (!$wmemo) check("내용을 입력하세요");

$con = mysqli_connect("localhost", "root", "apmsetup", "class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

$wdate = date("Y-m-d-H:i:s");

$id = $_GET['id'];
$board = $_GET['board'];

$query = "INSERT INTO memojang (name, wdate, message, id, passwd) VALUES ('$wname', '$wdate', '$wmemo', $id, '$wpasswd')";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "댓글을 등록하는데 실패했습니다.";
    exit;
}

mysqli_close($con);

echo "<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>";
?>
</body>
</html>