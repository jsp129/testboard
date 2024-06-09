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

$id = $_GET['id'];
$board = $_GET['board'];

$result = mysqli_query($con, "SELECT * FROM $board WHERE id=$id");
$filename = '';

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $filename = $row['filename'];
}

mysqli_query($con, "DELETE FROM $board WHERE id=$id");
mysqli_query($con, "DELETE FROM memojang WHERE id=$id");
if (!empty($filename)) {
    unlink("./pds/$filename");
}

echo("
    <script>
    window.alert('글이 삭제 되었습니다.');
    </script>
");

// 삭제된 글보다 글 번호가 큰 게시물은 글 번호를 1씩 감소
$tmp = mysqli_query($con, "SELECT id FROM $board ORDER BY id DESC");
$last_row = mysqli_fetch_assoc($tmp);
$last = $last_row['id']; // 가장 마지막 글 번호 추출

$i = $id + 1; // 삭제된 글의 번호보다 1이 큰 글 번호부터 변경
while ($i <= $last) {
    mysqli_query($con, "UPDATE $board SET id=id-1 WHERE id=$i");
    $i++;
}

// 글 삭제 결과를 보여주기 위한 글 목록 보기 프로그램 호출
echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

mysqli_close($con);
?>
</body>
</html>
