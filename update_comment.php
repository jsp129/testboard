<?php
// MySQL 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "apmsetup";
$dbname = "class";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 댓글 ID와 게시판 이름 가져오기
$id = $_POST['id'];
$board = $_POST['board'];

// POST로 전송된 수정된 댓글 내용 가져오기
$name = $_POST['wname'];
$message = $_POST['wmemo'];

// 댓글 업데이트 쿼리 준비 및 실행
$sql = "UPDATE memojang SET name=?, message=? WHERE name=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $message, $name);

if ($stmt->execute()) {
    // 댓글 업데이트 성공 시 이전 페이지로 리다이렉트
    header("Location: content.php?board=$board&id=$id");
    exit();
} else {
    echo "댓글을 업데이트하는 동안 오류가 발생했습니다: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
