<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시글 수정</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        input[type="submit"] {
            padding: 10px;
            color: #fff;
            background-color: #999;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>게시글 수정</h2>
    <?php
    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "root", "apmsetup", "class");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    // 게시글 정보 가져오기
    $id = $_GET['id'];
    $board = $_GET['board'];

    $result = mysqli_query($con, "SELECT * FROM $board WHERE id=$id");
    if (!$result) {
        echo "Failed to fetch post: " . mysqli_error($con);
        exit;
    }

    // 게시글 정보 확인
    $row = mysqli_fetch_assoc($result);
    $writer = $row['writer'];
    $topic = $row['topic'];
    $content = $row['content'];

    // 게시글 수정 폼
    echo "<form method='post' action='update_post.php'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='hidden' name='board' value='$board'>";
    echo "<label for='writer'>작성자:</label>";
    echo "<input type='text' id='writer' name='writer' value='$writer'><br>";
    echo "<label for='topic'>제목:</label>";
    echo "<input type='text' id='topic' name='topic' value='$topic'><br>";
    echo "<label for='content'>내용:</label>";
    echo "<textarea id='content' name='content'>$content</textarea><br>";
    echo "<input type='submit' value='수정'>";
    echo "</form>";

    // 데이터베이스 연결 종료
    mysqli_close($con);
    ?>
</div>
</body>
</html>
