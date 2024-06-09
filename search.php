<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #555;
        }

        #container {
            width: 80%;
            max-width: 1200px; /* 최대 너비 설정 */
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9; /* 배경색 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #ddd;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            color: #555;
        }

        a:hover {
            text-decoration: underline;
            color: red;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #ddd;
            color: #555;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #bbb;
            color: white;
        }
    </style>
</head>
<body>
<div id="container">
    <?php
    if(empty($_POST['key'])) {
        echo("<script>
            window.alert('검색어를 입력하세요');
            history.go(-1);
            </script>");
        exit;
    }

    $key = $_POST['key'];
    $field = $_POST['field'];
    $board = $_GET['board'];

    $con = mysqli_connect("localhost", "root", "apmsetup", "class");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $field = mysqli_real_escape_string($con, $field);
    $key = mysqli_real_escape_string($con, $key);
    $result = mysqli_query($con, "SELECT * FROM $board WHERE $field LIKE '%$key%' ORDER BY id DESC");
    $total = mysqli_num_rows($result);

    echo("
       <table border=0 width=700 align=center>
       <tr><td align=center colspan=2><h1>게시판</h1></td><tr>
       <tr><td>검색어:$key , 찾은 개수:$total 개</td>
       <td align=right><a href=show.php?board=$board><img src=back.png width=20 height=20></a></td></tr>
       </table>
    ");

    echo("
       <table border=0 width=700 align=center>
       <tr id=t1><td align=center width=50><b>번호</b></td>
       <td align=center width=100><b>글쓴이</b></td>
       <td align=center width=400><b>제목</b></td>
       <td align=center width=150><b>날짜</b></td>
       <td align=center width=50><b>조회</b></td>
       </tr>
    ");

    if (!$total) {
        echo("<tr id=t2><td colspan=5 align=center>검색된 글이 없습니다.</td></tr>");
    } else {
        $counter = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $writer = $row['writer'];
            $topic = $row['topic'];
            $hit = $row['hit'];
            $wdate = $row['wdate'];
            $date = substr($wdate, 0, 16);
            $space = $row['space'];

            $result1 = mysqli_query($con, "SELECT * FROM memojang WHERE id=$id");
            $total1 = mysqli_num_rows($result1);

            $t = "";

            if ($space > 0) {
                for ($i = 0; $i <= $space; $i++) {
                    $t .= "&nbsp;";
                }
            }

            echo("
                <tr onMouseover=\"this.style.backgroundColor='#dedede', this.style.color='white'\"
                    onMouseOut=\"this.style.backgroundColor='#f2f2f2', this.style.color='black'\">
                    <td align=center>$id</td>
                    <td align=center>$writer</td>");
                       if ($total1 != 0) {
                echo("
                    <td align=left>$t<a href=content.php?board=$board&id=$id>$topic [$total1]</a></td>
                ");
            } else {
                echo("
                    <td align=left>$t<a href=content.php?board=$board&id=$id>$topic</a></td>
                ");
            }
            echo("
                    <td align=center>$date</td><td align=center>$hit</td>
                </tr>
            ");
            $counter++;
        }
        echo("</table>");
    }

    mysqli_close($con);
    ?>
</div>
</body>
</html>
