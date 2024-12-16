<?php
require 'config.php';

// Set the number of students to display per page
$studentsPerPage = 10;

// Get the current page from the query string, defaulting to 1 if not set
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, $page); // Ensure the page is at least 1

// Calculate the offset for the query
$offset = ($page - 1) * $studentsPerPage;

// Fetch the total number of students
$totalStudents = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();

// Calculate the total number of pages
$totalPages = ceil($totalStudents / $studentsPerPage);

// Fetch the students for the current page
$stmt = $conn->prepare("SELECT * FROM students LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $studentsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Students List</h1>
        <a href="create.php" class="btn btn-success mb-3">Add New Student</a>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['age']) ?></td>
                        <td><?= htmlspecialchars($student['grade']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $student['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <!-- Previous Page -->
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next Page -->
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>