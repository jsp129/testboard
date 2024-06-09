<?php

header('Content-Type: text/html; charset=utf-8');

// MySQL 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "apmsetup";
$dbname = "class";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 게시물 ID와 게시판 이름 가져오기
$id = $_GET['id'];
$board = $_GET['board'];
$name = $_GET['name'];

// 게시물 암호 가져오기 (이름을 기준으로)
$sql = "SELECT passwd FROM memojang WHERE name = '$name'";
$result = $conn->query($sql);

// 사용자가 입력한 암호를 가져옵니다.
$pass = $_POST['pass'];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $passwd = $row['passwd'];

    // 사용자가 입력한 암호 확인
    if ($pass === $passwd) {
        // 암호가 일치하는 경우
        $mode = $_GET['mode'];

        if ($mode == '1') {
            // mode가 '1'인 경우 댓글 삭제 쿼리 실행
            $delete_query = "DELETE FROM memojang WHERE name='$name' AND id='$id'";
            if ($conn->query($delete_query) === TRUE) {
                // 삭제 성공 시 메시지 출력
                echo "<script>alert('댓글이 삭제되었습니다.');</script>";
                echo "<script>window.location.href = 'content.php?board=$board&id=$id';</script>";
            } else {
                // 삭제 실패 시 에러 메시지 출력
                echo "<script>alert('댓글 삭제에 실패했습니다.');</script>";
                echo "<script>history.go(-1);</script>";
            }
        } else {
            // mode가 '1'이 아닌 경우 수정 페이지로 이동
            header("Location: modify.php?board=$board&id=$id&name=$name");
            exit();
        }
    } else {
        // 암호가 일치하지 않는 경우
        echo "<script>alert('입력한 암호가 일치하지 않습니다.');</script>";
        echo "<script>history.go(-1);</script>";
        exit();
    }    
} else {
    // 해당하는 게시물을 찾을 수 없는 경우
    echo "<script>alert('해당하는 게시물을 찾을 수 없습니다.');</script>";
    echo "<script>history.go(-1);</script>";
    exit();
}

$conn->close();
?>
