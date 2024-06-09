<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
    
<?php
// MySQL에 연결
$con = mysqli_connect("localhost", "root", "apmsetup", "class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// GET 요청에서 파라미터 가져오기
$id = $_GET['id'];
$board = $_GET['board'];
$mode = $_GET['mode'];
$wdate = $_GET['wdate'];
$wname = $_GET['wname'];
$wmemo = $_GET['wmemo'];
$pass = $_POST['pass']; // 폼에서 전달된 암호 가져오기

// 쿼리 실행하여 암호 가져오기
$result = mysqli_query($con, "SELECT passwd FROM memojang WHERE id=$id AND wdate='$wdate'");
if (!$result) {
    echo "Failed to fetch password: " . mysqli_error($con);
    exit;
}
$row = mysqli_fetch_assoc($result);
$passwd = $row['passwd'];

// 암호 확인 후 리다이렉트
if ($pass != $passwd) {
    echo "<script>alert('입력 암호가 일치하지 않습니다.'); history.go(-1);</script>";
    exit;
} else {
    switch ($mode) {
        case 0: // 수정 프로그램 호출
            echo "<meta http-equiv='Refresh' content='0; url=cmodify.php?board=$board&id=$id&wdate=$wdate&wname=$wname&wmemo=$wmemo'>";
            break;
        case 1: // 삭제 프로그램 호출
            echo "<meta http-equiv='Refresh' content='0; url=cdelete.php?board=$board&id=$id&wdate=$wdate'>";
            break;
    }
}

// MySQL 연결 종료
mysqli_close($con);
?>
