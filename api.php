<?php

require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "error" => "Unauthorized. Please login."
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute([':user_id' => $user_id]);
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
        $stmt = $pdo->prepare("INSERT INTO tasks (title, user_id) VALUES (:task_title, :user_id)");
        $stmt->execute([':task_title' => $task_title, ':user_id' => $user_id]);

        // to Get the newly inserted task
        $lastId = $pdo->lastInsertId();
        $stmt = $pdo->prepare(" SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $lastId, ':user_id' => $user_id]);
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

        $stmt = $pdo->prepare("UPDATE tasks SET is_completed = :is_completed WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':is_completed' => $is_completed,':id' => $id, ':user_id' => $user_id]);
        echo json_encode([
            "success" => true
        ]);

        exit;
    }

    if ($method === 'DELETE') {
        $raw = file_get_contents("php://input");
        $in = json_decode($raw, true);
        $id = $in['id'];

        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $id, ':user_id' => $user_id]);
        
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