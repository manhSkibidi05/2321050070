<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        session_start();
        if(isset($_SESSION['username'])) {
            echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
            echo "<p>This is the home page.</p>";
        } else {
            echo "<h1>Welcome, Guest!</h1>";
            echo "<p>Please log in to access more features.</p>";
        }
    ?>
</body>
</html>