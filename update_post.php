<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시글 수정 완료</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #999;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "root", "apmsetup", "class");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    // POST로 전달된 데이터 가져오기
    $id = $_POST['id'];
    $board = $_POST['board'];
    $writer = mysqli_real_escape_string($con, $_POST['writer']);
    $topic = mysqli_real_escape_string($con, $_POST['topic']);
    $content = mysqli_real_escape_string($con, $_POST['content']);

    // 게시글 업데이트 쿼리
    $sql = "UPDATE $board SET writer='$writer', topic='$topic', content='$content' WHERE id=$id";
    if (mysqli_query($con, $sql)) {
        echo "<h2>게시글이 성공적으로 수정되었습니다.</h2>";
        echo "<a href='content.php?board=$board&id=$id'>게시글로 돌아가기</a>";
    } else {
        echo "<h2>게시글 수정에 실패했습니다: " . mysqli_error($con) . "</h2>";
    }

    // 데이터베이스 연결 종료
    mysqli_close($con);
    ?>
</div>
</body>
</html>
