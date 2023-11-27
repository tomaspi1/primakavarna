<?php

$slozka = $shortcode->getParameter("slozka");

$slozka = "upload/source/$slozka";

$soubory = scandir($slozka);
//var_dump($soubory);

echo "<div class='fotogalerie'>";
foreach ($soubory as $soubor)
{
    // preskocit soubory co nas nezajimaji
    if ($soubor[0] == ".")
    {
        continue;
    }

    $celaCesta = "$slozka/$soubor";
    $info = pathinfo($celaCesta);
    if ($info["extension"] == "jpg")
    {
        $rozmery = getimagesize($celaCesta);
        $sirka = $rozmery[0];
        $vyska = $rozmery[1];
        echo "
            <a href='$celaCesta' data-pswp-width=$sirka data-pswp-height=$vyska>
            <img src='$celaCesta' height=200>
            </a>";
    }
}
echo "</div>";

?>
<script type="module">
import PhotoSwipeLightbox from './vendor/photoswipe/dist/photoswipe-lightbox.esm.js';
const lightbox = new PhotoSwipeLightbox({
  gallery: '.fotogalerie',
  children: 'a',
  pswpModule: () => import('./vendor/photoswipe/dist/photoswipe.esm.js')
});
lightbox.init();
</script>