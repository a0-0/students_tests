<?php
include 'php/db.php';
include 'templates/header.php';
$test_id = $_GET['id'];
$sql = "SELECT * FROM Questions WHERE test_id = $test_id";
$questions = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Test</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="test-taking-container">
        <h2>Test: <?php echo $test_id; ?></h2>
        <form action="php/submit_test.php" method="POST">
            <?php while ($question = $questions->fetch_assoc()) { ?>
                <div class="question">
                    <p><?php echo $question['question_text']; ?></p>
                    <?php if ($question['question_type'] == 'multiple_choice') { ?>
                        <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option1"> <?php echo $question['option1']; ?><br>
                        <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option2"> <?php echo $question['option2']; ?><br>
                        <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option3"> <?php echo $question['option3']; ?><br>
                        <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option4"> <?php echo $question['option4']; ?><br>
                    <?php } else { ?>
                        <input type="text" name="question_<?php echo $question['question_id']; ?>">
                    <?php } ?>
                </div>
            <?php } ?>
            <button type="submit">Submit Test</button>
        </form>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
