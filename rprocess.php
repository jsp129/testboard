<?php
if(empty($_POST['writer'])){
    echo("<script>
        window.alert('이름이 없습니다. 다시 입력하세요.');
        history.go(-1);
        </script>");
    exit;
}

// MySQL 데이터베이스 연결
$con = mysqli_connect("localhost", "root", "apmsetup", "class");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// POST로 전달된 데이터 가져오기
$board = $_GET['board'];
$id = $_GET['id'];
$writer = $_POST['writer'];
$email = $_POST['email'];
$passwd = $_POST['passwd'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$userfile_name = $_FILES['userfile']['name'];
$userfile_size = $_FILES['userfile']['size'];
$userfile_tmp = $_FILES['userfile']['tmp_name'];

// 답변 글을 쓴 날짜 저장
$wdate = date("Y-m-d-H:i:s");

// 답변글이 추가되면 글의 개수가 하나 증가하므로 글 번호를 정리
$tmp = mysqli_query($con, "SELECT id FROM $board");
$total = mysqli_num_rows($tmp);

while($total >= $id){
    mysqli_query($con, "UPDATE $board SET id=id+1 WHERE id=$total");
    mysqli_query($con, "UPDATE memojang SET id=id+1 WHERE id=$total");
    $total--;
}

// 첨부 파일이 있을 경우 저장 및 처리
if ($userfile_name) {
    $savedir = "./pds"; // 첨부 파일이 저장될 폴더
    $filepath = "$savedir/$userfile_name";
    move_uploaded_file($userfile_tmp, $filepath);
}

// 원래 글 번호 위치에 답변 글을 삽입함
mysqli_query($con, "INSERT INTO $board(id, writer, email, passwd, topic, content, hit, wdate, space, filename, filesize) 
                    VALUES ($id, '$writer', '$email', '$passwd', '$topic', '$content', 0, '$wdate', $space, '$userfile_name', $userfile_size)");

// MySQL 연결 종료
mysqli_close($con);

// 페이지 이동
header("Location: show.php?board=$board");
exit;
?>
