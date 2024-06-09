<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>비밀번호 확인</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f2f2f2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
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
            color: fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>암호를 입력하세요</h2>
    <form method="post" action="pass2.php?board=<?php echo $_GET['board']; ?>&id=<?php echo $_GET['id']; ?>&mode=<?php echo $_GET['mode']; ?>&name=<?php echo $_GET['name']; ?>">
        <input type="password" name="pass" placeholder="암호" required>
        <input type="submit" value="입력">
    </form>
</div>
</body>
</html>
