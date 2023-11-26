<?php

class Stranka
{
    public $id;
    public $titulek;
    public $menu;

    function __construct($id, $titulek, $menu)
    {
        $this->id = $id;
        $this->titulek = $titulek;
        $this->menu = $menu;
    }

    function getObsah()
    {
        return file_get_contents("$this->id.html");
    }

    function setObsah($obsah)
    {
        file_put_contents("$this->id.html", $obsah);
    }
}

$seznamStranek = [
    "uvod" => new Stranka("uvod", "PrimaPenzion", "Domů"),
    "nabidka" => new Stranka("nabidka", "PrimaPenzion - Nabídka", "Nabídka"),
    "galerie" => new Stranka("galerie", "PrimaPenzion - Galerie", "Galerie"),
    "rezervace" => new Stranka("rezervace", "PrimaPenzion - Rezervace", "Rezervace"),
    "kontakt" => new Stranka("kontakt", "PrimaPenzion - Kontakt", "Kontakt"),
    "404" => new Stranka("404", "Stránka neexistuje", ""),
];
