<?php
include 'php/db.php';
include 'templates/header.php';
$test_id = $_GET['id'];
$sql = "SELECT * FROM Tests WHERE test_id = $test_id";
$test = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $test['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="test-container">
        <h2><?php echo $test['name']; ?></h2>
        <p>Teacher: <?php echo $test['teacher_id']; ?></p>
        <p>Date Created: <?php echo $test['date_created']; ?></p>
        <p>Rating: <?php echo $test['rating']; ?></p>
        <p>Number of Questions: <?php echo $test['number_of_questions']; ?></p>
        <p>Price: <?php echo $test['price']; ?></p>
        <p>Free Attempts: <?php echo $test['free_attempts']; ?></p>
        <p>Duration: <?php echo $test['duration']; ?> minutes</p>
        <a href="take_test.php?id=<?php echo $test['test_id']; ?>">Take Test</a>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
