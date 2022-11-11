var storage = window.localStorage;
var storageCompraVerdura = storage.getItem("verdura");
var storageCompraFruita = storage.getItem("fruita");
var listaCompra = document.getElementById("listaCompra");
var listaFruita = document.getElementById("listaCompraFruita");
var listaVerdura = document.getElementById("listaCompraVerdura");
var producteTemplate = document.getElementById("templateProducte");
var arrFruita = new Array();
var arrVerdura = new Array();
console.log({ storage });
if (storageCompraVerdura !== null) {
  arrVerdura = JSON.parse(storageCompraVerdura);
}

if (storageCompraFruita !== null) {
  arrFruita = JSON.parse(storageCompraFruita);
}

function listProductes(tipusProd) {
  if (tipusProd === "verdura") {
    while (listaVerdura.firstChild) {
      listaVerdura.removeChild(listaVerdura.lastChild);
    }
    storageCompraVerdura = storage.getItem("verdura");
    arrVerdura = JSON.parse(storageCompraVerdura);
    arrVerdura.forEach((verdura) => cloneProducte(verdura));
  } else if (tipusProd === "fruita") {
    while (listaFruita.firstChild) {
      listaFruita.removeChild(listaFruita.lastChild);
    }
    storageCompraFruita = storage.getItem("fruita");
    arrFruita = JSON.parse(storageCompraFruita);
    arrFruita.forEach((fruita) => cloneProducte(fruita));
  }
}

function cloneProducte(producte) {
  let producteClone = producteTemplate.cloneNode(true);
  producteClone.removeAttribute("id");
  producteClone.setAttribute("data-id", producte.nom);
  let producteButtons = producteClone.querySelectorAll("input");
  let spansProducte = producteClone.querySelectorAll("span");
  spansProducte[0].innerHTML = producte.quantitat;
  spansProducte[1].innerHTML = producte.tipuspes;
  spansProducte[2].innerHTML = producte.nom;
  if (producte.tipusproducte === "tipusFruita") {
    listaFruita.appendChild(producteClone);
  } else {
    listaVerdura.appendChild(producteClone);
  }
  Array.from(producteButtons).forEach((button) =>
    button.setAttribute("data-id", producte.nom)
  );
}

function deleteProducte(element, array) {
  let data_id = element.getAttribute("data-id");
  var found = array.findIndex((element) => element.nom == data_id);
  array.splice(found, 1);
  return found;
}

function copySpanToForm(element, id, array) {
  let parent = element.parentNode.parentNode;
  console.log({ parent });
  var found = array.findIndex((element) => element.nom == id);
  let spansList = parent.querySelectorAll("span");
  console.log({ spansList });
  document.getElementById("inpQuantitat").value = spansList[0].innerHTML;
  document.getElementById("inpProducteSearch").value = spansList[2].innerHTML;
  array.splice(found, 1);
  document.getElementById("inpProducteSearch").setAttribute("readonly", "true");
  document.getElementById("btnAdd").style.display = "none";
  document.getElementById("btnSave").style.display = "block";
  document.getElementById("btnSave").setAttribute("data-id", id);
}

document.addEventListener("DOMContentLoaded", function () {
  if (arrVerdura.length > 0) listProductes("verdura");
  if (arrFruita.length > 0) listProductes("fruita");
});

document.getElementById("formProducte").addEventListener("click", (e) => {
  let element = e.target;
  if (element.id === "btnAdd") {
    let formulari = document.getElementsByClassName("formulariInp");
    let formInputs = Array.from(formulari, (element) => element.value);
    let foundVerdura = arrVerdura.findIndex(
      (verdura) => verdura.nom === formInputs[2]
    );
    let foundFruita = arrFruita.findIndex(
      (fruita) => fruita.nom === formInputs[2]
    );

    let producte = {
      quantitat: formInputs[0],
      tipuspes: formInputs[1],
      nom: formInputs[2],
      tipusproducte: formInputs[3],
    };
    if (producte.tipusproducte === "tipusVerdura" && foundVerdura === -1) {
      arrVerdura.push(producte);
      storage.setItem("verdura", JSON.stringify(arrVerdura));
      cloneProducte(producte);
    } else if (producte.tipusproducte === "tipusFruita" && foundFruita === -1) {
      arrFruita.push(producte);
      storage.setItem("fruita", JSON.stringify(arrFruita));
      cloneProducte(producte);
    } else {
      alert("Ja existeix el producte");
    }
    listProductes("fruita");
    listProductes("verdura");
  }

  e.stopPropagation();
});

listaFruita.addEventListener("click", (e) => {
  const element = e.target;
  if (element.classList.contains("btnDelete")) {
    let exists = deleteProducte(element, arrFruita);
    if (exists) {
      storage.setItem("fruita", JSON.stringify(arrFruita));
      listProductes("fruita");
    }
  } else if (element.classList.contains("btnEdit")) {
    copySpanToForm(element, element.getAttribute("data-id"), arrFruita);
  }
  e.stopPropagation();
});

listaVerdura.addEventListener("click", (e) => {
  const element = e.target;
  if (element.classList.contains("btnDelete")) {
    let exists = deleteProducte(element, arrVerdura);
    if (exists) {
      storage.setItem("verdura", JSON.stringify(arrVerdura));
      listProductes("verdura");
    }
  } else if (element.classList.contains("btnEdit")) {
    copySpanToForm(element, element.getAttribute("data-id"), arrVerdura);
  }
  e.stopPropagation();
});

document.getElementById("formProducte").addEventListener("click", (e) => {
  const element = e.target;
  if (element.id === "btnSave") {
    let formulari = document.getElementsByClassName("formulariInp");
    let formInputs = Array.from(formulari, (element) => element.value);
    let producte = {
      quantitat: formInputs[0],
      tipuspes: formInputs[1],
      nom: formInputs[2],
      tipusproducte: formInputs[3],
    };
    element.getAttribute("data-id");
    let producteId = element.getAttribute("data-id");
    if (producte.tipusproducte === "tipusVerdura") {
      arrVerdura.push(producte);
      storage.setItem("verdura", JSON.stringify(arrVerdura));
      listaVerdura.querySelector("li[data-id='" + producteId + "']").remove();
    } else if (producte.tipusproducte === "tipusFruita") {
      arrFruita.push(producte);
      storage.setItem("fruita", JSON.stringify(arrFruita));
      listaFruita.querySelector("li[data-id='" + producteId + "']").remove();
    }
    cloneProducte(producte);
    listProductes("fruita");
    listProductes("verdura");
    document.getElementById("btnAdd").style.display = "block";
    element.style.display = "none";
    element.removeAttribute("data-id");
    document.getElementById("inpProducteSearch").removeAttribute("readonly");
    let inputsForm = element.querySelectorAll(".formulariInp");
    Array.from(inputsForm).forEach((e) => (e.value = ""));
  }
  e.stopPropagation();
});
