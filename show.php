
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

        .write-button {
            text-align: right;
            margin-top: 20px;
        }

        .search-form {
            text-align: left;
            margin-bottom: 20px;
        }

        .search-form select, .search-form input[type="text"], .search-form input[type="submit"] {
            margin-right: 10px;
        }

    </style>
</head>
<body>
<div id="container">
    <h1>게시판</h1>
    <?php
    // MySQL 데이터베이스에 연결
    $con = mysqli_connect("localhost", "root", "apmsetup", "class");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    // GET 요청을 통해 받은 게시판(board) 이름을 변수에 저장
    $board = $_GET['board'];

    // 해당 게시판에서 글을 조회하여 결과를 가져옴
    $result = mysqli_query($con, "SELECT * FROM $board ORDER BY id DESC");

    // 총 글의 개수를 계산
    $total = mysqli_num_rows($result);

    // 페이지당 보여줄 글의 개수
    $pagesize = 10;

    // 총 페이지 수 계산
    $totalpage = ceil($total / $pagesize);

    // GET 요청을 통해 받은 현재 페이지 번호
    $cpage = isset($_GET['cpage']) ? $_GET['cpage'] : 1;

    // 페이지 시작 위치 계산
    $start = ($cpage - 1) * $pagesize;

    // LIMIT을 사용하여 페이징 처리된 쿼리를 실행하여 각 페이지에 해당하는 글 목록을 가져옴
    $query = "SELECT * FROM $board ORDER BY id DESC LIMIT $start, $pagesize";
    $result = mysqli_query($con, $query);

    // 글 목록을 테이블 형식으로 출력
    echo "<table>";
    echo "<tr><th>번호</th><th>글쓴이</th><th>제목</th><th>날짜</th><th>조회</th></tr>";
	

    // 글 목록 출력
    if (!$total) {
        echo "<tr><td colspan='5'>아직 등록된 글이 없습니다.</td></tr>";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $writer = $row['writer'];
            $topic = $row['topic'];
            $hit = $row['hit'];
            $wdate = $row['wdate'];
            $date = substr($wdate, 0, 10);

            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$writer</td>";
            echo "<td><a href='content.php?board=$board&id=$id'>$topic</a></td>";
            echo "<td>$date</td>";
            echo "<td>$hit</td>";
            echo "</tr>";
        }
    }

    // MySQL 연결 닫기
    mysqli_close($con);
    ?>
</div>

<div class="pagination">
    <?php
    // 페이지 번호 출력
    if ($totalpage > 1) {
        for ($i = 1; $i <= $totalpage; $i++) {
            echo "<a href='show.php?board=$board&cpage=$i'>$i</a> ";
        }
    }
    ?>
</div>

<div class="search-form">
    <form method="post" action="search.php?board=<?php echo $board; ?>">
        <select name="field">
            <option value="writer">글쓴이</option>
            <option value="topic">제목</option>
            <option value="content">내용</option>
        </select>
        <input type="text" name="key" size="20">
        <input type="submit" value="검색">
    </form>
</div>

<div class="write-button">
	<a href='input.php'><img src='edit3.png' width=30 height=30></a>
</div>

</body>
</html>