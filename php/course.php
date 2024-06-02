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
$stmt = $conn->prepare('SELECT name, description, picture, price, rating FROM Courses WHERE course_id = ?');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$stmt->bind_result($name, $description, $picture, $price, $rating);
$stmt->fetch();
$stmt->close();

// Fetch user courses for the sidebar
$user_id = $_SESSION['user_id'];
$user_courses_query = "SELECT c.course_id, c.name FROM Courses c
JOIN User_Courses uc ON c.course_id = uc.course_id
WHERE uc.user_id = ?";
$stmt = $conn->prepare($user_courses_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_courses_result = $stmt->get_result();
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
                <img src="../img/<?php echo htmlspecialchars($picture); ?>" alt="<?php echo htmlspecialchars($name); ?>">
                <p><?php echo htmlspecialchars($description); ?></p>
                <p>Price: $<?php echo htmlspecialchars($price); ?></p>
                <p>Rating: <?php echo htmlspecialchars($rating); ?>/5</p>
            </div>
        </main>
    </div>
    <footer>
        <?php include '../templates/footer.php'; ?>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
