const nahoru = document.querySelector("#nahoru");
nahoru.addEventListener("click", (udalost) => {
    window.scrollTo({
        left: 0,
        top: 0,
        behavior: 'smooth'
    });
});

const header = document.querySelector("header");
window.addEventListener("scroll", (udalost) => {
    //console.log(window.scrollY);
    const poziceHeaderu = header.getBoundingClientRect();
    //console.log(poziceHeaderu);

    if (window.scrollY > poziceHeaderu.bottom)
    {
        nahoru.classList.add("zobrazit");
    }
    else
    {
        nahoru.classList.remove("zobrazit");
    }
});