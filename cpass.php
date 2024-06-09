<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>비밀번호 확인</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f2f2f2; /* 변경: 배경색을 흰색으로 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        input[type="password"], input[type="submit"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #f2f2f2;
            color: #333; /* 변경: 글자색을 어두운 회색으로 */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s; /* 변경: 전환 효과 추가 */
        }
        input[type="submit"]:hover {
            background-color: #777;
            color: #fff; /* 변경: 마우스 오버시 글자색을 흰색으로 */
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // 변수 값 설정
    $board = $_GET['board'];
    $id = $_GET['id'];
    $mode = $_GET['mode'];
    $wdate = $_GET['wdate'];
    $wname = $_GET['wname'];
    $wmemo = $_GET['wmemo'];

    // HTML 폼 생성
    echo "<form method='post' action='cpass2.php?board=$board&id=$id&mode=$mode&wdate=$wdate&wname=$wname&wmemo=$wmemo'>";
    echo "<table border='0' width='100%' align='center'>";
    echo "<tr><td colspan='2' align='center'><h2>암호를 입력하세요</h2></td></tr>";
    echo "<tr><td colspan='2' align='center'><input type='password' size='30' name='pass'></td></tr>";
    echo "<tr><td colspan='2' align='center'><input type='submit' value='입력'></td></tr>";
    echo "</table>";
    echo "</form>";
    ?>
</div>
</body>
</html>
