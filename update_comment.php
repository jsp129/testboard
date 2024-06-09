<?php
// MySQL �����ͺ��̽� ����
$servername = "localhost";
$username = "root";
$password = "apmsetup";
$dbname = "class";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ��� ID�� �Խ��� �̸� ��������
$id = $_POST['id'];
$board = $_POST['board'];

// POST�� ���۵� ������ ��� ���� ��������
$name = $_POST['wname'];
$message = $_POST['wmemo'];

// ��� ������Ʈ ���� �غ� �� ����
$sql = "UPDATE memojang SET name=?, message=? WHERE name=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $message, $name);

if ($stmt->execute()) {
    // ��� ������Ʈ ���� �� ���� �������� �����̷�Ʈ
    header("Location: content.php?board=$board&id=$id");
    exit();
} else {
    echo "����� ������Ʈ�ϴ� ���� ������ �߻��߽��ϴ�: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
