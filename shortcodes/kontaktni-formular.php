<?php
$chyby = [];
$jmeno = "";
$telefon = "";
$email = "";
$zprava = "";
$odeslano = false;
$formularOdeslan = false;
if (array_key_exists("odeslat", $_POST))
{
    // formular byl odeslan
    $formularOdeslan = true;
    $jmeno = $_POST["jmeno"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $zprava = $_POST["zprava"];

    // validace hodnot
    if (mb_strlen($jmeno) < 5)
    {
        $chyby["jmeno"] = "Jméno musí být zadáno";
    }
    if (mb_strlen($telefon) < 9)
    {
        $chyby["telefon"] = "Telefon musí být zadán";
    }
    if (!preg_match("/.+@.+\\..+/", $email))
    {
        $chyby["email"] = "Neplatný email";
    }
    if (mb_strlen($zprava) < 5)
    {
        $chyby["zprava"] = "Zpráva musí být zadána";
    }

    // zkontrolujeme zda-li pole s chybami je prazdne
    if (count($chyby) == 0)
    {
        // vse ok
        $odeslano = true;

        // odesleme zpravci email ze mu nekdo napsal pres kontaktni formular
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        $mail->CharSet = "utf-8";

        $mail->setFrom('info@primakavarna.cz', 'PrimaKavarna');
        $adresaEmailu = $shortcode->getParameter("email");
        $mail->addAddress($adresaEmailu);

        $mail->isHTML(true);
        $mail->Subject = 'Kontaktní formulář PrimaKavárna';
        $mail->Body = "
            <h1>Kontaktní formulář PrimaKavárna</h1>
            <div><b>Jméno:</b> $jmeno</div>
            <div><b>Telefon:</b> $telefon</div>
            <div><b>Email:</b> $email</div>
            <div><b>Zpráva:</b> $zprava</div>
        ";
        $mail->send();
    }
}
?>

<div class="obsah" id="kontaktni-formular">
    <div class="container">
        <h2>Napište nám</h2>
        <div class="formular">
            <?php if ($odeslano == false) { ?>
                <form method="post" action="#kontaktni-formular">
                    <div class="radka">
                        <input class="prvek" type="text" name="jmeno" id="jmeno" placeholder=" " value="<?php echo htmlspecialchars($jmeno) ?>" />
                        <label for="jmeno">Jméno</label>
                        <?php
                        $status = "";
                        if ($formularOdeslan)
                        {
                            $status = "ok";
                            if (array_key_exists("jmeno", $chyby))
                            {
                                $status = "chyba";
                                echo "<div class='chyba'>{$chyby['jmeno']}</div>";
                            }
                        }
                        ?>
                        <div class="status <?php echo $status ?>">
                            <i class="spravne fa-solid fa-check"></i>
                            <i class="spatne fa-solid fa-xmark"></i>
                        </div>
                    </div>
                    <div class="radka">
                        <input class="prvek" type="text" name="telefon" id="telefon" placeholder=" "  value="<?php echo htmlspecialchars($telefon) ?>" />
                        <label for="telefon">Telefon</label>
                        <?php
                        $status = "";
                        if ($formularOdeslan)
                        {
                            $status = "ok";
                            if (array_key_exists("telefon", $chyby))
                            {
                                $status = "chyba";
                                echo "<div class='chyba'>{$chyby['telefon']}</div>";
                            }
                        }
                        ?>
                        <div class="status <?php echo $status ?>">
                            <i class="spravne fa-solid fa-check"></i>
                            <i class="spatne fa-solid fa-xmark"></i>
                        </div>
                    </div>
                    <div class="radka">
                        <input class="prvek" type="text" name="email" id="email" placeholder=" "  value="<?php echo htmlspecialchars($email) ?>"/>
                        <label for="email">E-mail</label>
                        <?php
                        $status = "";
                        if ($formularOdeslan)
                        {
                            $status = "ok";
                            if (array_key_exists("email", $chyby))
                            {
                                $status = "chyba";
                                echo "<div class='chyba'>{$chyby['email']}</div>";
                            }
                        }
                        ?>
                        <div class="status <?php echo $status ?>">
                            <i class="spravne fa-solid fa-check"></i>
                            <i class="spatne fa-solid fa-xmark"></i>
                        </div>
                    </div>
                    <div class="radka">
                        <textarea class="prvek" name="zprava" id="zprava" placeholder=" " rows="3"><?php echo htmlspecialchars($zprava) ?></textarea>
                        <label for="zprava">Zpráva</label>
                        <?php
                        $status = "";
                        if ($formularOdeslan)
                        {
                            $status = "ok";
                            if (array_key_exists("zprava", $chyby))
                            {
                                $status = "chyba";
                                echo "<div class='chyba'>{$chyby['zprava']}</div>";
                            }
                        }
                        ?>
                        <div class="status <?php echo $status ?>">
                            <i class="spravne fa-solid fa-check"></i>
                            <i class="spatne fa-solid fa-xmark"></i>
                        </div>
                    </div>
                    <div class="radka">
                        <button name="odeslat">Odeslat</button>
                    </div>
                </form>
            <?php }else { ?>
                <h1>Kontaktní formulář byl úspěšně odeslán</h1>
            <?php } ?>
        </div>
    </div>
</div>

<style>
    .chyba {
        color: red;
        font-weight: bold;
    }
</style>

<script>
    $("#kontaktni-formular [name]").on("input", (udalost) => {
        const input = udalost.currentTarget;
        const nazevInputu = input.getAttribute("name");
        const hodnotaInputu = input.value;
        //console.log(hodnotaInputu);

        let ok = true;
        if (nazevInputu == "jmeno")
        {
            // validace jmena
            if (hodnotaInputu.length < 5)
            {
                ok = false;
            }
        }
        else if (nazevInputu == "telefon")
        {
            if (hodnotaInputu.length < 9)
            {
                ok = false;
            }
        }
        else if (nazevInputu == "email")
        {
            if (hodnotaInputu.match(/.+@.+\..+/) == null)
            {
                ok = false;
            }
        }
        else if (nazevInputu == "zprava")
        {
            if (hodnotaInputu.length < 5)
            {
                ok = false;
            }
        }

        // zvizualizujeme vysledek validace
        const statusElement = document.querySelector(`#kontaktni-formular [name=${nazevInputu}]~.status`);
        if (ok)
        {
            statusElement.className = "status ok";
        }
        else
        {
            statusElement.className = "status chyba";
        }
    });
</script>