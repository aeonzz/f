<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];

    $stmt = $conn->prepare("INSERT INTO students (name, age, grade) VALUES (:name, :age, :grade)");
    $stmt->execute(['name' => $name, 'age' => $age, 'grade' => $grade]);

    echo "<div class='alert alert-success'>Student added successfully!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Student</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Grade:</label>
                <input type="text" name="grade" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="read.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>
