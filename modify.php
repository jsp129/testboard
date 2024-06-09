<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>댓글 수정</title>
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
    <h1>댓글 수정</h1>
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
    $id = $_GET['id'];
    $board = $_GET['board'];
    $name = $_GET['name'];

    // 댓글 정보 가져오기
    $query = "SELECT * FROM memojang WHERE name = '$name'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "댓글을 불러오는데 실패했습니다.";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $message = $row['message'];

    // 댓글 정보를 수정할 수 있는 폼 생성
    ?>
    <form method="post" action="update_comment.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="board" value="<?php echo $board; ?>">
        <label for="wname">이름:</label>
        <input type="text" id="wname" name="wname" value="<?php echo $name; ?>" readonly><br>
        <label for="wmemo">댓글 내용:</label>
        <textarea id="wmemo" name="wmemo"><?php echo $message; ?></textarea><br>
        <input type="submit" value="수정">
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
