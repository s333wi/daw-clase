let formulari = document.getElementsByClassName('formulari');
console.log(typeof formulari);

Array.from(formulari).forEach(element => {
    let childClone = element.cloneNode();
    console.log({childClone});
});
document.addEventListener("DOMContentLoaded", function(event) {
    
});