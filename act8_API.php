<?php
header("Content-Type: application/json");

$host = 'localhost';
$db = 'act8';
$user = 'root';
$pass = '1234';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type === 'book') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query("SELECT * FROM book");
        $books = $stmt->fetchAll();
        echo json_encode($books);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO book (title, author, price, copies) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$input['title'], $input['author'], $input['price'], $input['copies']]);
        echo json_encode(['message' => 'Book added successfully']);
    }
} elseif ($type === 'user') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query("SELECT * FROM user");
        $users = $stmt->fetchAll();
        echo json_encode($users);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO user (username, password, email, name) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$input['username'], $input['password'], $input['email'], $input['name']]);
        echo json_encode(['message' => 'User added successfully']);
    }
} else {
    echo json_encode(['error' => 'Invalid type parameter']);
}
?>
