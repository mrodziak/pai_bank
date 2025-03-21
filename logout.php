<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wylogowano</title>
    <link rel="stylesheet" href="style.css"> 
    <meta http-equiv="refresh" content="3;url=login.php"> 
</head>
<body>
    <div class="container">
        <h2>Zostales wylogowany!</h2>
        <p>Za chwile wrocisz do strony logowania...</p>
    </div>
</body>
</html>