var storage = window.localStorage;
var listaCompra = document.getElementById("listaCompra");
var arrCompra = [];
var jsonCompra = storage.getItem("compra");
window.onload = function () {

    alert(jsonCompra);
    if (jsonCompra !== null) {
        arrCompra = JSON.parse(jsonCompra);

        for (let producte of arrCompra) {
            listaCompra.innerHTML += "<li><span style='visibility:visible'>" + producte + "</span><input type=text style='visibility:hidden' id='" + producte + "'>" +
                "<button class='btnEdit'>Editar</button><button class='btnDelete'>Borrar</button></li>";
        }
    }

    document.getElementById("btnSearch").addEventListener("click", function () {
        var addQuery = document.getElementById("searchQuery");
        alert(addQuery.value);
        arrCompra.push(addQuery.value);
        console.log({ arrCompra });
        storage.setItem("compra", JSON.stringify(arrCompra));
    });

    const editArr = document.getElementsByClassName("btnEdit");
    for (let btnEdit of editArr) {
        btnEdit.addEventListener("click", function () {
            var btnValue = btnEdit.innerHTML;
            var parent = btnEdit.parentElement;

            if (btnValue === "Editar") {
                btnEdit.innerHTML = "Guardar";
                console.log(parent.children[1]);
                parent.children[1].value = parent.children[0].innerHTML;
                parent.children[0].style.visibility = "hidden";
                parent.children[1].style.visibility = "visible";
            } else if (btnValue === "Guardar") {
                btnEdit.innerHTML = "Editar";
                console.log(parent.children[1]);
                parent.children[0].style.visibility = "hidden";
                parent.children[1].style.visibility = "none";
                let index = arrCompra.indexOf(parent.children[0].innerHTML);
                console.log(parent.children[1]);
                arrCompra[index] = parent.children[1].value;
            }
        });
    }


}