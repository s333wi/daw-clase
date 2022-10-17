window.onload = function () {
    var storage = window.localStorage;
    var listaCompra = document.getElementById("listaCompra");
    var arrCompra = [];
    var jsonCompra = storage.getItem("compra");


    if (jsonCompra !== "null") {
        arrCompra = JSON.parse(jsonCompra);
    }
    for (let producte of arrCompra) {
        listaCompra.innerHTML += "<li><span style='visibility:visible'>" + producte + "</span><input type=text style='visibility:hidden' id='" + producte + "'>" +
            "<button class='btnEdit'>Editar</button><button class='btnDelete'>Borrar</button></li>";
    }

    document.getElementById("btnSearch").addEventListener("click", () => {
        var addQuery = document.getElementById("searchQuery");
        alert(addQuery.value);
        arrCompra.push(addQuery.value);
    });

    const editArr = document.getElementsByClassName("btnEdit");
    for (let btnEdit of editArr) {
        btnEdit.addEventListener("click", () => {
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
                parent.children[0].style.visibility = "visible";
                parent.children[1].style.visibility = "hidden";
                let index = arrCompra.indexOf(parent.children[0].innerHTML);
                arrCompra[index] = parent.children[1].value;
            }
        });
    }
    console.log(arrCompra);
    storage.setItem("compra", JSON.stringify(arrCompra));
    
    $('.task-delete').click(() => {
        idfniogf
    })
}