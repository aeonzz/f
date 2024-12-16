<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the student data based on the provided ID
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $grade = $_POST['grade'];

        $stmt = $conn->prepare("UPDATE students SET name = :name, age = :age, grade = :grade WHERE id = :id");
        $stmt->execute(['name' => $name, 'age' => $age, 'grade' => $grade, 'id' => $id]);

        echo "<div class='alert alert-success'>Student updated successfully!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Student</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($student['age']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Grade:</label>
                <input type="text" name="grade" class="form-control" value="<?= htmlspecialchars($student['grade']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Student</button>
            <a href="read.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>

