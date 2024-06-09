<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시글 작성</title>
</head>
<body>
<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "apmsetup";
$dbname = "class";

// 게시글 폼에서 전송된 데이터 가져오기
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $board = $_POST['board'];
    $topic = $_POST['topic'];
    $content = $_POST['content'];
    $writer = $_POST['writer'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    // 데이터 유효성 검사
    if (empty($writer) || empty($topic) || empty($content)) {
        echo "<script>alert('모든 필드를 입력하세요.'); history.go(-1);</script>";
        exit;
    }

    // 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 게시글 추가 쿼리 실행 (id 컬럼을 명시하지 않음)
    $sql = "INSERT INTO $board (writer, email, passwd, topic, content, hit, wdate, space)
            VALUES ('$writer', '$email', '$passwd', '$topic', '$content', 0, NOW(), 0)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('게시글이 성공적으로 작성되었습니다.');</script>";
		echo "<script>window.location.href = 'show.php?board=$board';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 데이터베이스 연결 종료
    $conn->close();
}
?>
</body>
</html>
