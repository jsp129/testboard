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
        }

        .container {
            width: 80%; /* 변경: 너비를 80%로 조정 */
            max-width: 1200px; /* 추가: 최대 너비를 1200px로 제한 */
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 20px;
        }

        td, th {
            padding: 10px;
            border-bottom: 1px solid #ddd;
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
<div class="container">
    <?php
    $con = mysqli_connect("localhost", "root", "apmsetup", "class");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    $id = $_GET['id'];
    $board = $_GET['board'];

    $query = "SELECT * FROM $board WHERE id = $id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "게시글을 불러오는데 실패했습니다.";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $writer = $row['writer'];
    $topic = $row['topic'];
    $hit = $row['hit'];
    $filename = $row['filename'];
    $filesize = $row['filesize'];
    $wdate = $row['wdate'];
    $email = $row['email'];
    $content = $row['content'];

    $hit++;

    $update_query = "UPDATE $board SET hit = $hit WHERE id = $id";
    mysqli_query($con, $update_query);

    if ($filesize > 1000) {
        $kb_filesize = (int)($filesize / 1000);
        $disp_size = $kb_filesize . ' KBytes';
    } else {
        $disp_size = $filesize . ' Bytes';
    }
    ?>
    <table>
        <tr>
            <td colspan='4' align = center><h1>게시판</h1></td>

        </tr>
        <tr id='t1'>
            <td width='100'>번호: <?php echo $id; ?></td>
            <td width='200'>글쓴이: <a href='mailto:<?php echo $email; ?>'><?php echo $writer; ?></a></td>
            <td width='300'>글쓴날짜: <?php echo $wdate; ?></td>
            <td width='100'>조회: <?php echo $hit; ?></td>
        </tr>
        <tr>
            <?php if (!$filesize) : ?>
                <td colspan='4' bgcolor='#f5f5f5'>파일:</td>
            <?php else : ?>
                <td colspan='4' bgcolor='#e8e8e8'>파일: <a href='./pds/<?php echo $filename; ?>'><?php echo $filename; ?></a> [ <?php echo $disp_size; ?> ]</td>
            <?php endif; ?>
        </tr>
        <tr>
            <td colspan='4' bgcolor='#f5f5f5'>제목: <?php echo $topic; ?></td>
        </tr>
        <tr>
            <td colspan='4' bgcolor='#fcfcfc'><?php echo $content; ?></td>
        </tr>
    </table>

	<table>
        <tr>
            <td align=right>
				
				<a href='cpass.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>&mode=0&wdate=<?php echo $wdate; ?>&wname=<?php echo $name; ?>&wmemo=<?php echo $message; ?>' title = '수정'> <img src='edit1.png' width=30 height=30></a>|
                <a href='cpass.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>&mode=1&wdate=<?php echo $wdate; ?>'title='삭제'><img src='eraser.png' width=30 height=30></a>
                <a href='reply.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>' title='답변'><img src='edit3.png' width=30 height=30></a>
                <a href='show.php?board=<?php echo $board; ?>' title='리스트'><img src='list1.png' width=30 height=30></a>
            </td>
        </tr>
    </table><br>

    <?php
    $query = "SELECT * FROM memojang WHERE id = $id ORDER BY wdate DESC";
    $result = mysqli_query($con, $query);
    $total_comments = mysqli_num_rows($result);
    ?>
    <table>
        <?php if ($total_comments == 0) : ?>
            <tr id='t1' align=center><td width='50'>번호</td><td width='100'>이름</td><td width='150'>쓴날짜</td><td width='400'>댓글내용</td></tr>
            <tr><td align=center colspan=4>등록된 댓글이 없습니다</td></tr>
        <?php else : ?>
            <tr id='t1' align=center><td width='50'>번호</td><td width='100'>이름</td><td width='150'>쓴날짜</td><td width='300'>댓글</td><td width='50'></td></tr>
            <?php
            $pagesize = 5;
            $mcpage = isset($_GET['mcpage']) ? $_GET['mcpage'] : 1;
            $endpage = (int)($total_comments / $pagesize);
            if (($total_comments % $pagesize) != 0) $endpage = $endpage + 1;
            $i = 0;
            $counter = 0;
            while ($i < $pagesize && $counter < $total_comments) {
                $num = $i + 1;
                $comment_row = mysqli_fetch_assoc($result);
                $name = $comment_row['name'];
                $wdate = $comment_row['wdate'];
                $date = substr($wdate, 0, 16);
                $message = $comment_row['message'];
                ?>
                <tr>
                    <td align=center><?php echo $num; ?></td>
                    <td align=center><?php echo $name; ?></td>
                    <td align=center><?php echo $date; ?></td>
                    <td><?php echo $message; ?></td>
					<td width ='100' align=center>
                        <a href='pass.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>&mode=0&wdate=<?php echo $wdate; ?>&name=<?php echo $name; ?>&wmemo=<?php echo $message; ?>'>수정</a>|
                        <a href='pass.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>&mode=1&wdate=<?php echo $wdate; ?>&name=<?php echo $name; ?>&wmemo=<?php echo $message; ?>'>삭제</a>
                    </td>
                </tr>
                <?php
                $i++;
                $counter++;
            }
            ?>
        <?php endif; ?>
    </table>
  

    <form method='post' align=center action='memo.php?board=<?php echo $board; ?>&id=<?php echo $id; ?>'>
        <table>
            <tr>
                <td>이름</td>
                <td><input type='text' size=10 name='wname' align=center></td>
                <td>댓글</td>
                <td><input type='text' size=30 name='wmemo'></td>
                <td>암호</td>
                <td><input type='password' name='wpasswd' size=15></td>
                <td><input type='image' src='upload1.png' width=18 height=18 title='글올리기'></td>
            </tr>
        </table>
    </form>

    <table>
        <tr id='t1' align=center>
            <td align=center width=50><b>번호</b></td>
            <td align=center width=100><b>글쓴이</b></td>
            <td align=center width=400><b>제목</b></td>
            <td align=center width=150><b>날짜</b></td>
            <td align=center width=50><b>조회</b></td>
        </tr>

        <?php
        $query = "SELECT * FROM $board ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        $total_posts = mysqli_num_rows($result);

        $cpage = isset($_GET['cpage']) ? $_GET['cpage'] : 1;
        $pagesize = 5;
        $totalpage = (int)($total_posts / $pagesize);
        if (($total_posts % $pagesize) != 0) $totalpage = $totalpage + 1;

        $counter = 0;
        $start = ($cpage - 1) * $pagesize;
        while ($row = mysqli_fetch_assoc($result)) {
            $idd = $row['id'];
            $writer = $row['writer'];
            $topic = $row['topic'];
            $hit = $row['hit'];
            $wdate = $row['wdate'];
            $date = substr($wdate, 0, 10);
            ?>
            <tr onMouseover="this.style.backgroundColor='#dedede', this.style.color='white'"
                onMouseOut="this.style.backgroundColor='#f2f2f2', this.style.color='black'">
                <?php if ($id == $idd) : ?>
                    <td align=center><img src='check.png' width=30 height=35></td>
                <?php else : ?>
                    <td align=center><?php echo $idd; ?></td>
                <?php endif; ?>
                <td align=center><?php echo $writer; ?></td>
                <td align=left><a href='content.php?board=<?php echo $board; ?>&id=<?php echo $idd; ?>'><?php echo $topic; ?></a></td>
                <td align=center><?php echo $date; ?></td>
                <td align=center><?php echo $hit; ?></td>
            </tr>
            <?php
            $counter++;
            if ($counter >= $pagesize) break;
        }
        ?>
    </table>

    <table border=0 width=700 align=center>
        <tr>
            <td align=center>
                <?php if ($totalpage > 1) : ?>
                    <b>페이지: </b>
                    <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                        <a href='content.php?board=<?php echo $board; ?>&cpage=<?php echo $i; ?>'><?php echo $i; ?></a>
                    <?php endfor; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <?php mysqli_close($con); ?>
</div>
</body>
</html>
