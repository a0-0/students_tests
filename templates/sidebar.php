<aside class="sidebar">
    <nav>
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="my_courses.php">My Courses</a></li>
            <li><a href="courses.php">All Courses</a></li>
        </ul>
        <h3>My Courses</h3>
        <ul class="course-list">
            <?php while($user_course = $user_courses_result->fetch_assoc()): ?>
                <li>
                    <a href="course.php?id=<?php echo $user_course['course_id']; ?>">
                        <?php echo htmlspecialchars($user_course['name']); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </nav>
</aside>
