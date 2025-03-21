<?php
session_start();

$uzytkownik = 'admin';
$haslo = '1234';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $pass = $_POST['haslo'];

    if ($login === $uzytkownik && $pass === $haslo) {
        $_SESSION['zalogowany'] = true;

        if (!isset($_SESSION['konto'])) {
            $_SESSION['konto'] = [
                'numer' => rand(10000000, 99999999),
                'wlasciciel' => 'Caroline Derpienski',
                'saldo' => 1000.00
            ];
        }
        if (!isset($_SESSION['historia'])) {
            $_SESSION['historia'] = [];
        }

        header('Location: bank.php');
        exit;
    } else {
        $blad = "Nieprawidłowy login lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Logowanie</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <h2>Logowanie do systemu bankowego</h2>

    <?php if (isset($blad)) echo "<p style='color:red;'>$blad</p>"; ?>

    <form method="post">
        <label>Login: <input type="text" name="login" required></label><br><br>
        <label>Hasło: <input type="password" name="haslo" required></label><br><br>
        <button type="submit">Zaloguj</button>
    </form>
    </div>
</body>
</html>