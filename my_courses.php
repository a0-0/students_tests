<?php
session_start();
include 'php/db.php';
include 'templates/header.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT Courses.* FROM Courses 
        INNER JOIN User_Courses ON Courses.course_id = User_Courses.course_id 
        WHERE User_Courses.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-container">
        <h2>My Courses</h2>
        <div class="courses">
            <?php while ($course = $result->fetch_assoc()) { ?>
                <div class="course">
                    <img src="images/<?php echo $course['picture']; ?>" alt="<?php echo $course['name']; ?>">
                    <h3><?php echo $course['name']; ?></h3>
                    <p><?php echo $course['description']; ?></p>
                    <a href="course.php?id=<?php echo $course['course_id']; ?>">View Course</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
