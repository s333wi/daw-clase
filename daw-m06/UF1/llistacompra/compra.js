var storage = window.localStorage;
var listaCompra = document.getElementById("listaCompra");
var arrCompra = [];
var jsonCompra = storage.getItem("compra");
window.onload = function () {

    if (jsonCompra !== null) {
        arrCompra = JSON.parse(jsonCompra);
        for (let producte of arrCompra) {
            listaCompra.innerHTML += "<li><span>" + producte + "</span><input value='" + producte + "' type=text style='display:none' id='" + producte + "'>" +
                "<button class='btnEdit'>Editar</button><button class='btnDelete'>Borrar</button></li>";
        }
    }

    document.getElementById("btnSearch").addEventListener("click", function () {
        var addQuery = document.getElementById("searchQuery");
        arrCompra.push(addQuery.value);
        storage.setItem("compra", JSON.stringify(arrCompra));
        location.reload();
    });

    const editArr = document.getElementsByClassName("btnEdit");
    for (let btnEdit of editArr) {
        btnEdit.addEventListener("click", function () {
            var btnValue = btnEdit.innerHTML;
            var parent = btnEdit.parentElement;

            if (btnValue === "Editar") {
                btnEdit.innerHTML = "Guardar";
                parent.children[1].value = parent.children[0].innerHTML;
                parent.children[0].style.display = "none";
                parent.children[1].style.display = "inline-block";
            } else if (btnValue === "Guardar") {
                let editValue = parent.children[1].value;
                let index = arrCompra.indexOf(parent.children[0].innerHTML);
                arrCompra[index] = editValue;
                storage.setItem("compra", JSON.stringify(arrCompra));
                location.reload();
            }
        });
    }

    const deleteArr = document.getElementsByClassName("btnDelete");
    for (let btnDelete of deleteArr) {
        btnDelete.addEventListener("click", function () {
            let parent = btnDelete.parentElement;
            let key = parent.children[0].innerHTML;
            let confirmDelete = confirm("Segurs que vols esborrar?");
            if (confirmDelete) {
                arrCompra.splice(key, 1);
                storage.setItem("compra", JSON.stringify(arrCompra));
                location.reload();
            }
        });
    }
}