<?php include 'php/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <div class="sidebar">
            <h2>NAVIGATION</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Dashboard</a></li>
                <li>My courses
                    <ul>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM Courses");
                        $stmt->execute();
                        $courses = $stmt->fetchAll();
                        foreach ($courses as $course) {
                            echo '<li><a href="course.php?id=' . $course['course_id'] . '">' . $course['name'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="main">
            <?php
            if (isset($_GET['id'])) {
                $course_id = $_GET['id'];
                $stmt = $conn->prepare("SELECT * FROM Courses WHERE course_id = :course_id");
                $stmt->bindParam(':course_id', $course_id);
                $stmt->execute();
                $course = $stmt->fetch();
                if ($course) {
                    echo '<h2>' . $course['name'] . '</h2>';
                    echo '<p>Teacher: ' . $course['teacher_id'] . '</p>';
                    echo '<p>' . $course['description'] . '</p>';
                    echo '<p>Price: $' . $course['price'] . '</p>';
                } else {
                    echo '<p>Course not found.</p>';
                }
            } else {
                echo '<p>No course selected.</p>';
            }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
