<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
// 작성자, 제목, 내용 가져오기
$writer = $_POST['writer'];
$topic = $_POST['topic'];
$content = $_POST['content'];

// 필수 입력 항목이 빈 값인 경우 경고창을 띄우고 이전 페이지로 이동
if (empty($writer) || empty($topic) || empty($content)) {
    echo "<script>alert('이름, 제목 또는 내용이 입력되지 않았습니다. 다시 입력하세요'); history.go(-1);</script>";
    exit;
}

// MySQL 데이터베이스에 연결
$con = mysqli_connect("localhost", "root", "apmsetup", "class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// GET으로 전달된 board와 id 가져오기
$id = $_GET['id'];
$board = $_GET['board'];

// 해당 id에 대한 게시물 데이터 가져오기
$result = mysqli_query($con, "SELECT * FROM $board WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// 기존 필드값을 유지할 항목을 추출
$space = $row['space'];
$hit = $row['hit'];

// 파일 업로드 처리
$userfile = $_FILES['userfile']['tmp_name'];
$userfile_name = $_FILES['userfile']['name'];
$userfile_size = $_FILES['userfile']['size'];

if ($userfile) {    
    $savedir = "./pds";    // 파일이 저장될 폴더 경로
    $temp = $userfile_name;
    copy($userfile, "$savedir/$temp");
    unlink($userfile);
}

$wdate = date("Y-m-d-H:i:s");    // 수정한 날짜 저장

// 변경된 내용을 데이터베이스에 업데이트
mysqli_query($con, "UPDATE $board SET writer='$writer', topic='$topic', content='$content', hit=$hit, wdate='$wdate', space=$space, filename='$userfile_name', filesize='$userfile_size' WHERE id=$id");

// 수정된 게시물을 보여주는 페이지로 리다이렉트
echo "<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>";

// MySQL 연결 종료
mysqli_close($con);
?>
</body>
</html>