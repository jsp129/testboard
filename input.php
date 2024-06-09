<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시판 작성</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #555;
            overflow-y: auto; /* 세로 스크롤이 필요할 때만 표시 */
        }
        .container {
            width: 80%;
            max-width: 800px; /* 폭을 최대 800px로 설정 */
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2; /* 게시판의 배경색을 회색으로 변경 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="password"], input[type="file"], textarea, select {
            margin-bottom: 20px;
            padding: 5px; /* 폼 요소의 내부 여백을 줄임 */
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 12px); /* 오른쪽 여백 제거 */
            box-sizing: border-box;
            font-size: 14px; /* 폰트 크기를 줄임 */
            background-color: #f9f9f9;
        }
        input[type="submit"], input[type="reset"] {
            padding: 8px 16px; /* 버튼 내부 여백을 줄임 */
            color: #fff;
            background-color: #999; /* 버튼 색상을 회색으로 변경 */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px; /* 폰트 크기를 줄임 */
            margin-right: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #777; /* 버튼 호버시 색상 변경 */
        }
        .form-group {
            margin-bottom: 10px; /* 각 입력 그룹의 마진을 줄임 */
        }
        .button-group {
            display: flex;
            justify-content: center;
        }
        .list-link {
            display: flex;
            justify-content: flex-end;
            margin-top: -30px;
            margin-right: -10px;
        }
        .list-link img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>게시판 작성</h1>
        <?php
        // 게시판 선택을 위한 드롭다운 메뉴
        $boards = array("testboard"); // 사용 가능한 게시판 목록
        ?>
        <form method="post" action="process.php">
            <table>
                <tr>
                    <td width="100" align="right">게시판 선택</td>
                    <td width="600">
                        <select name="board">
                            <?php
                            foreach ($boards as $board) {
                                echo "<option value='$board'>$board</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">이름</td>
                    <td width="600"><input type="text" name="writer" size="20"></td>
                </tr>
                <tr>
                    <td width="100" align="right">Email</td>
                    <td width="600"><input type="text" name="email" size="40"></td>
                </tr>
                <tr>
                    <td width="100" align="right">제목</td>
                    <td width="600"><input type="text" name="topic" size="60"></td>
                </tr>
                <tr>
                    <td width="100" align="right">내용</td>
                    <td><textarea name="content" rows="6" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td align="right"><label for="userfile">첨부파일</label></td>
                    <td><input type="file" name="userfile" id="userfile" size="45" maxlength="80"></td>
                </tr>
                <tr>
                    <td align="right"><label for="passwd">암호</label></td>
                    <td><input type="password" name="passwd" size="15"></td>
                </tr>
                <!-- 나머지 입력 폼 요소들 추가 -->
                <tr>
                    <td align="center" colspan="2">
                        <input type="submit" value="등록하기">
                        <input type="reset" value="지우기">
                    </td>
                    <td align="right" colspan="2">
                        <a href='show.php?board=<?php echo $board; ?>' title='리스트'><img src='list1.png' width=30 height=30></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

