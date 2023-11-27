$("#stranky").sortable({
    update: () => {
        //alert("Změna pořadí stránek");
        const sortedIDs = $( "#stranky" ).sortable( "toArray" );
        console.log(sortedIDs);

        $.ajax({
            url: "admin.php",
            data: {
                "poradi" : sortedIDs,
            }
        })
    }
});

$("#stranky .smazat").click((udalost) => {
    if (confirm("Opravdu chcete danou stránku smazat?") == false)
    {
        // prerusime udalost cimz se zrusi nasledne navstiveni odkazu
        // pro smazani stranky
        udalost.preventDefault();
    }
});