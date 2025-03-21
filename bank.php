<?php
session_start();

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kwota = floatval($_POST['kwota']);
    $czas = date('Y-m-d H:i:s');

    if ($_POST['operacja'] === 'wplata') {
        $_SESSION['konto']['saldo'] += $kwota;
        $_SESSION['historia'][] = ["data" => $czas, "typ" => "Wpłata", "kwota" => $kwota];
        $komunikat = "Wpłacono {$kwota} zł.";
    } elseif ($_POST['operacja'] === 'wyplata') {
        if ($kwota > $_SESSION['konto']['saldo']) {
            $komunikat = "Błąd: niewystarczające środki.";
        } else {
            $_SESSION['konto']['saldo'] -= $kwota;
            $_SESSION['historia'][] = ["data" => $czas, "typ" => "Wypłata", "kwota" => $kwota];
            $komunikat = "Wypłacono {$kwota} zł.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Panel bankowy</title><link rel="stylesheet" href="style.css"></head>
<body>
 <div class="container">
    <h2>Witaj w swoim banku!</h2>
    <p><strong>Właściciel:</strong> <?= $_SESSION['konto']['wlasciciel'] ?></p>
    <p><strong>Numer konta:</strong> <?= $_SESSION['konto']['numer'] ?></p>
    <p><strong>Saldo:</strong> <?= number_format($_SESSION['konto']['saldo'], 2) ?> $</p>

    <?php if (isset($komunikat)): ?>
        <p><strong><?= $komunikat ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <label>Kwota ($): <input type="number" name="kwota" step="0.01" required></label><br><br>
        <button type="submit" name="operacja" value="wplata">Wpłać</button>
        <button type="submit" name="operacja" value="wyplata">Wypłać</button>
    </form>

    <h3>🕒 Historia transakcji:</h3>
    <?php if (empty($_SESSION['historia'])): ?>
        <p>Brak transakcji.</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Data</th>
                <th>Typ</th>
                <th>Kwota</th>
            </tr>
            <?php foreach (array_reverse($_SESSION['historia']) as $transakcja): ?>
                <tr>
                    <td><?= $transakcja['data'] ?></td>
                    <td><?= $transakcja['typ'] ?></td>
                    <td><?= number_format($transakcja['kwota'], 2) ?> $</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="logout.php">Wyloguj się</a>
    </div>
</body>
</html>