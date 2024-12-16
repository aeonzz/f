<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the student record for confirmation
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['confirm'])) {
            // Delete the student record
            $deleteStmt = $conn->prepare("DELETE FROM students WHERE id = :id");
            $deleteStmt->execute(['id' => $id]);

            header("Location: read.php?deleted=1");
            exit;
        } else {
            // Redirect back to the read page if canceled
            header("Location: read.php");
            exit;
        }
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Delete Student</h1>
        <div class="alert alert-warning">
            <strong>Are you sure you want to delete this student?</strong>
            <p>Name: <strong><?= htmlspecialchars($student['name']) ?></strong></p>
            <p>Age: <strong><?= htmlspecialchars($student['age']) ?></strong></p>
            <p>Grade: <strong><?= htmlspecialchars($student['grade']) ?></strong></p>
        </div>

        <form method="POST" action="">
            <button type="submit" name="confirm" class="btn btn-danger">Yes, Delete</button>
            <a href="read.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

