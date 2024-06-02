<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

// Fetch user information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT full_name FROM Users WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($full_name);
$stmt->fetch();
$stmt->close();

// Fetch all courses
$courses_query = "SELECT course_id, name, description, picture, price, rating FROM Courses";
$courses_result = $conn->query($courses_query);

// Fetch courses related to the current user
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
    <title>Main Page</title>
    <link rel="stylesheet" href="../css/mainstyle.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <?php include '../templates/sidebar.php'; ?>
        <main class="main-content">
            <h1>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h1>
            <h2>All Courses</h2>
            <div class="courses-container">
                <?php
                $courses_result->data_seek(0); // Reset the result pointer to the beginning
                while ($course = $courses_result->fetch_assoc()):
                ?>
                    <div class="course-card">
                        <img src="../img/<?php echo htmlspecialchars($course['picture']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>">
                        <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($course['price']); ?></p>
                        <p>Rating: <?php echo htmlspecialchars($course['rating']); ?>/5</p>
                        <a href="course.php?id=<?php echo $course['course_id']; ?>" class="btn">View Course</a>
                    </div>
                <?php endwhile; ?>
            </div>
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
