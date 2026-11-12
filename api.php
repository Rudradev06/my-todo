<?php
header('Content-Type: application/json');


try {
    $dbPath = __DIR__ . '/task_db.db';

    $pdo = new PDO("sqlite:" . $dbPath);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Create table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            is_completed INTEGER DEFAULT 0 CHECK (is_completed IN (0, 1)),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM tasks");
        $tasks = $stmt->fetchAll();
        
        echo json_encode([
            "success" => true,
            "tasks" => $tasks
        ]);
        exit;
    }

    if ($method === 'POST') {

        $raw = file_get_contents("php://input");
        $in = json_decode($raw, true);

        $task_title = $in['task_title'];
        

        // for Inserting the task
        $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:task_title)");
        $stmt->bindParam(':task_title', $task_title);
        $stmt->execute();

        // to Get the newly inserted task
        $lastId = $pdo->lastInsertId();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $lastId]);
        $newTask = $stmt->fetch();   

        // Return success response
        echo json_encode([
            "success" => true,
            "task" => $newTask
        ]);
    }

    if ($method === 'PATCH') {
        $raw = file_get_contents("php://input");
        $in = json_decode($raw, true);

        $id = $in['id'];
        $is_completed = $in['is_completed'];

        $stmt = $pdo->prepare("UPDATE tasks SET is_completed = :is_completed WHERE id = :id");

        $stmt->execute([':is_completed' => $is_completed,':id' => $id]);

        echo json_encode([
            "success" => true
        ]);

        exit;
    }

    if ($method === 'DELETE') {
        $raw = file_get_contents("php://input");
        $in = json_decode($raw, true);
        $id = $in['id'];

        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(["success" => true]);
        exit;
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Database error: " . $e->getMessage()
    ]);
}
?>