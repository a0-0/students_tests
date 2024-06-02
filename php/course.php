<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

// Fetch course details
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare('SELECT c.name, c.description, c.picture, c.price, c.rating, u.full_name as teacher_name, c.created_at FROM Courses c JOIN Users u ON c.teacher_id = u.user_id WHERE c.course_id = ?');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$stmt->bind_result($name, $description, $picture, $price, $rating, $teacher_name, $created_at);
$stmt->fetch();
$stmt->close();

// Fetch user courses for the sidebar
$user_id = $_SESSION['user_id'];
$user_courses_query = "SELECT c.course_id, c.name FROM Courses c JOIN User_Courses uc ON c.course_id = uc.course_id WHERE uc.user_id = ?";
$stmt = $conn->prepare($user_courses_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_courses_result = $stmt->get_result();

// Fetch course tests
$tests_query = "SELECT t.test_id, t.name as test_name, t.duration as period, t.number_of_questions as sum_questions
FROM Tests t
JOIN Course_Tests ct ON t.test_id = ct.test_id
WHERE ct.course_id = ?";
$stmt = $conn->prepare($tests_query);
$stmt->bind_param('i', $course_id);
$stmt->execute();
$tests_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="../css/coursestyle.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <?php include '../templates/sidebar.php'; ?>
        <main class="main-content">
            <h1><?php echo htmlspecialchars($name); ?></h1>
            <div class="course-detail">
                <img src="../img/<?php echo htmlspecialchars($picture); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="course-image">
                <div class="course-info">
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($price); ?></p>
                    <p><strong>Rating:</strong> <?php echo htmlspecialchars($rating); ?>/5</p>
                    <p><strong>Teacher:</strong> <?php echo htmlspecialchars($teacher_name); ?></p>
                    <p><strong>Date Created:</strong> <?php echo htmlspecialchars($created_at); ?></p>
                    <p><strong>Sum of Tests:</strong> <?php echo $tests_result->num_rows; ?></p>
                </div>
            </div>
            <h2>Tests</h2>
            <table class="tests-table">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Period</th>
                        <th>Sum of Questions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($test = $tests_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                            <td><?php echo htmlspecialchars($test['period']); ?></td>
                            <td><?php echo htmlspecialchars($test['sum_questions']); ?></td>
                            <td><a href="take_test.php?test_id=<?php echo $test['test_id']; ?>" class="btn">Take Test</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
    <footer>
        <?php include '../templates/footer.php'; ?>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
