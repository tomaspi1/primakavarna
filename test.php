
<?php
if (array_key_exists("odeslat", $_POST))
{
    $jmeno = $_POST["jmeno"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $zprava = $_POST["zprava"];

    $teloEmailu = "
        Jméno: $jmeno
        E-mail: $email
        Telefon: $telefon
        Zpráva: $zprava
    ";

    mb_send_mail(
        "pit.tom@seznam.cz",
        "Kontaktní formulář na domena.cz",
        $teloEmailu,
        ["From" => "Kontaktní formulář <josef.kyrian.test@gmail.com>"]
    );

    echo "Odesláno";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        Vaše jméno: <input type="text" name="jmeno">
        <br>

        Vaš email: <input type="text" name="email">
        <br>

        Vaš telefon: <input type="text" name="telefon">
        <br>

        Zpráva: <textarea name="zprava" rows=5 cols=30></textarea>
        <br>

        <button name="odeslat">Odeslat</button>

    </form>
</body>
</html>