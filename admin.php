<?php
require "stranky.php";

session_start();

$chyba = "";

// zpracovani prihl. formulare
if (array_key_exists("prihlasit", $_POST))
{
    $jmeno = $_POST["jmeno"];
    $heslo = $_POST["heslo"];

    if ($jmeno == "admin" && $heslo == "1234")
    {
        // uzivatel. zadal platne prihlasovaci udaje
        $_SESSION["prihlasenyUzivatel"] = $jmeno;
    }
    else
    {
        // spatne prihlasovaci udaje
        $chyba = "Nesprávné přihlašovací údaje";
    }
}

// zpracování odhl. formuláře
if (array_key_exists("odhlasit", $_POST))
{
    unset($_SESSION["prihlasenyUzivatel"]);
    header("Location: ?");
}

// zpracovani akci v administraci je pouze pro prihlasene uzivatele
if (array_key_exists("prihlasenyUzivatel", $_SESSION))
{
    // promenna predstavujici stranku s kterou zrovna editujeme
    $instanceAktualniStranky = null;

    // zpracovani vyberu aktualni stranky
    if (array_key_exists("stranka", $_GET))
    {
        $idStranky = $_GET["stranka"];
        $instanceAktualniStranky = $seznamStranek[$idStranky];
    }

    // zpracovani formulare pro ulozeni
    if (array_key_exists("ulozit", $_POST))
    {
        $obsah = $_POST["obsah"];
        $instanceAktualniStranky->setObsah($obsah);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrace</title>
</head>
<body>
    <?php
    if (array_key_exists("prihlasenyUzivatel", $_SESSION) == false)
    {
        // sekce pro neprihlasene uzivatele
        ?>
        <form method="post">
            <label for="jmeno">Přihl. jméno</label>
            <input type="text" name="jmeno" id="jmeno">
            <br>
            <label for="heslo">Heslo</label>
            <input type="password" name="heslo" id="heslo">
            <br>

            <button name="prihlasit">Přihlásit</button>
        </form>

        <?php
        echo $chyba;
    }
    else
    {
        // sekce pro prihlasene uzivatele
        echo "Přihlášen uživatel: {$_SESSION["prihlasenyUzivatel"]}";

        echo "<form method='post'>
            <button name='odhlasit'>Odhlásit</button>
            </form>";

        // vypiseme seznam stranek, ktere lze editovat
        echo "<ul>";
        foreach ($seznamStranek as $idStranky => $instanceStranky)
        {
            echo "<li>
                <a href='?stranka=$instanceStranky->id'>$instanceStranky->id</a>

                / <a href='$instanceStranky->id' target='_blank'>zobrazit</a>
                </li>";
        }
        echo "</ul>";

        // editacni formular
        // zobbrazit pokud je nejaka stranka vybrana k editaci
        if ($instanceAktualniStranky != null)
        {
            echo "<h1>Editace stránky: $instanceAktualniStranky->id</h1>";

            ?>
            <form method="post">
                <textarea id="obsah" name="obsah" cols="80" rows="15"><?php
                echo htmlspecialchars($instanceAktualniStranky->getObsah());
                ?></textarea>
                <br>
                <button name="ulozit">Uložit</button>
            </form>
            <script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
            <script type="text/javascript">
                tinymce.init({
                    selector: '#obsah'
                });
            </script>
            <?php
        }
    }
    ?>
</body>
</html>