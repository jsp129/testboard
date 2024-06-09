<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시판 - 답변하기</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 1200px; /* 최대 너비 설정 */
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
        }
        td {
            padding: 10px;
        }
        input[type="text"], input[type="password"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="file"] {
            width: 80%;
            margin-top: 5px;
        }
        input[type="submit"], input[type="reset"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #999;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #777;
        }
    </style>
</head>
<body>

<?php
$con = mysqli_connect("localhost", "root", "apmsetup", "class");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$board = $_GET['board'];
$id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM $board WHERE id=$id");

if (!$result) {
    echo "게시글을 불러오는데 실패했습니다.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$topic = "[Re]" . $row['topic'];
$content = $row['content'];

$pre_content = "\n\n\n--------------< 원본글 >-------------\n" . $content . "\n";
?>

<div class="container">
    <h1>게시판 - 답변하기</h1>
    <form method='post' action='rprocess.php?board=<?php echo $board ?>&id=<?php echo $id ?>' enctype='multipart/form-data'>
        <table>
            <tr>
                <td align='right'>이름:</td>
                <td><input type='text' name='writer' size='20'></td>
            </tr>
            <tr>
                <td align='right'>Email:</td>
                <td><input type='text' name='email' size='40'></td>
            </tr>
            <tr>
                <td align='right'>제목:</td>
                <td><input type='text' name='topic' size='60' value='<?php echo $topic ?>'></td>
            </tr>
            <tr>
                <td align='right'>내용:</td>
                <td><textarea name='content' rows='12' cols='60'><?php echo $pre_content ?></textarea></td>
            </tr>
            <tr>
                <td align='right'><font size='2'>첨부파일:</font></td>
                <td><input type='file' name='userfile' size='45' maxlength='80'></td>
            </tr>
            <tr>
                <td align='right'>암호:</td>
                <td><input type='password' name='passwd' size='15'></td>
            </tr>
            <tr>
                <td colspan='2' align='center'>
                    <input type='submit' value='답변완료'>
                    <input type='reset' value='지우기'>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php mysqli_close($con); ?>

</body>
</html>
