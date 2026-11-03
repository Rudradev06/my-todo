<?php
try {
    $dbPath = __DIR__ . '/task_db.db';

    $pdo = new PDO("sqlite:" . $dbPath);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    echo "Connected to the SQLite database successfully via PDO!";
    
    $sql = "CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        is_completed INTEGER DEFAULT 0 CHECK (is_completed IN (0, 1)),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'tasks' is ready to use!";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navbar">
        <div id="logo">TODO</div>
        <div id="auth">LogIN | SignUP</div>
    </div>

    <div class="container">

        <div class="task-container">
            <div class="task">
                <p>Task 1</p>
                <div>
                    <img src="./icons/check.svg" alt="img1" class="img1">
                    <img src="./icons/delete.svg" alt="img2" class="img2">
                </div>
            </div>
            <div class="task">
                <p>Task 2</p>
                <div>
                    <img src="./icons/check.svg" alt="img1" class="img1">
                    <img src="./icons/delete.svg" alt="img2" class="img2">
                </div>
            </div>
            <div class="task">
                <p>Task 3</p>
                <div>
                    <img src="./icons/check.svg" alt="img1" class="img1">
                    <img src="./icons/delete.svg" alt="img2" class="img2">
                </div>
            </div>
        </div>

        <div class="input-container">
            <input type="text" placeholder="Input Your Task Here!" id="textInput"  required>
            <button id="add-task-btn">Add Task!</button>
        </div>

    </div>

    <script src="script.js"></script>
</body>

</html>