<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch user courses
$user_courses_query = "SELECT c.course_id, c.name, c.description, c.picture, c.price, c.rating FROM Courses c
JOIN User_Courses uc ON c.course_id = uc.course_id
WHERE uc.user_id = ?";
$stmt = $conn->prepare($user_courses_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_courses_result = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="../css/mainstyle.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="main.php">Home</a></li>
                    <li><a href="my_courses.php">My Courses</a></li>
                    <li><a href="courses.php">All Courses</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <h1>My Courses</h1>
            <div class="courses-container">
                <?php while ($course = $user_courses_result->fetch_assoc()): ?>
                    <div class="course-card">
                        <img src="../images/<?php echo htmlspecialchars($course['picture']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>">
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
