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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    selector: '#obsah',
                    language: 'cs',
                    language_url: '<?php echo dirname($_SERVER["PHP_SELF"]); ?>/vendor/tweeb/tinymce-i18n/langs/cs.js',
                    height: '50vh',
                    entity_encoding: "raw",
                    verify_html: false,
                    content_css: [
                        'css/reset.css',
                        'css/section.css',
                        'css/style.css',
                        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
                        'https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap',
                    ],
                    body_id: "content",
                    plugins: 'advlist anchor autolink charmap code colorpicker contextmenu directionality emoticons fullscreen hr image imagetools insertdatetime link lists nonbreaking noneditable pagebreak paste preview print save searchreplace tabfocus table textcolor textpattern visualchars',
                    toolbar1: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor",
                    toolbar2: "link unlink anchor | fontawesome | image media | responsivefilemanager | preview code",
                });
            </script>
            <?php
        }
    }
    ?>
</body>
</html>