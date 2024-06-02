
<?php
include 'php/db.php';
include 'templates/header.php';
session_start();
$test_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM TestResults WHERE user_id = $user_id AND test_id = $test_id";
$result = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="result-container">
        <h2>Test Result for Test: <?php echo $test_id; ?></h2>
        <p>Score: <?php echo $result['score']; ?></p>
        <p>Time Taken: <?php echo $result['time_taken']; ?> minutes</p>
        <p>Status: <?php echo $result['status']; ?></p>
        <a href="take_test.php?id=<?php echo $test_id; ?>">Retake Test</a>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
