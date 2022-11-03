let storage = window.localStorage;
let jsonAgenda = storage.getItem("contactes");
let listaContactes = document.getElementById("contactes");
let contacteTemplate = document.getElementById("contacteTemplate");
if (jsonAgenda !== null) {
  arrayContactes = JSON.parse(jsonAgenda);
  console.log({ arrayContactes });
} else {
  var arrayContactes = new Array();
}

document.getElementById("btnAdd").addEventListener("click", () => {
    createContacte();
  listContactes();
});

function listContactes() {
  while (listaContactes.firstChild) {
    listaContactes.removeChild(listaContactes.lastChild);
  }
  let jsonAgenda = storage.getItem("contactes");
  var arrayContactes = JSON.parse(jsonAgenda);
  arrayContactes.forEach((contacte) => {
    cloneContacte(contacte);
  });
}
function createContacte() {
  let formulari = document.getElementsByClassName("formulari");
  let formInputs = Array.from(formulari, (element) => element.value);
  console.log({ formInputs });
  let contacte = {
    nom: formInputs[0],
    cognom: formInputs[1],
    telefon: formInputs[2],
    address: formInputs[3],
    localitat: formInputs[4],
  };
  arrayContactes.push(contacte);
  storage.setItem("contactes", JSON.stringify(arrayContactes));
  console.log({ arrayContactes });
  cloneContacte(contacte);
}

function cloneContacte(contacte) {
  let contacteClone = contacteTemplate.cloneNode(true);
  contacteClone.removeAttribute("id");
  contacteClone.setAttribute("data-id", contacte.telefon);
  let spansContacte = contacteClone.querySelectorAll("span");
  let buttonsContacte = contacteClone.querySelectorAll("button");
  spansContacte[0].innerHTML = contacte.nom;
  spansContacte[1].innerHTML = contacte.cognom;
  spansContacte[2].innerHTML = contacte.telefon;
  spansContacte[3].innerHTML = contacte.address;
  spansContacte[4].innerHTML = contacte.localitat;
  Array.from(buttonsContacte).forEach((button) =>
    button.setAttribute("data-id", contacte.telefon)
  );
  listaContactes.appendChild(contacteClone);
}

function deleteContacte(element) {
  let data_id = element.getAttribute("data-id");
  var arrayContactes = JSON.parse(jsonAgenda);
  var found = arrayContactes.findIndex((element) => element.telefon == data_id);
  console.log(found);
  console.log({ arrayContactes });
  arrayContactes.splice(found, 1);
  console.log({ arrayContactes });
  listaContactes.querySelector("div[data-id='" + data_id + "']").remove();
  storage.setItem("contactes", JSON.stringify(arrayContactes));
}

function copySpanToForm(element, id) {
  let parent = element.parentNode.parentNode;
  var found = arrayContactes.findIndex((element) => element.telefon == id);
  console.log(found);
  let spansList = parent.querySelectorAll("span");
  var formulari = document.getElementsByClassName("formulari");
  let indexForm = 0;
  Array.from(formulari, (element) => {
    element.value = spansList[indexForm++].innerHTML;
  });
  arrayContactes.splice(found, 1);
  document.getElementById("btnAdd").style.display = "none";
  document.getElementById("btnSave").style.display = "block";
  document.getElementById("btnSave").setAttribute("data-id", id);
}

document.addEventListener("DOMContentLoaded", function () {
  listContactes();
  let btnListEliminar =
    listaContactes.getElementsByClassName("personaEliminar");
  let btnListEditar = listaContactes.getElementsByClassName("personaEdit");
  Array.from(btnListEliminar).forEach((element) =>
    element.addEventListener("click", () => {
      deleteContacte(element);
    })
  );
  Array.from(btnListEditar).forEach((element) =>
    element.addEventListener("click", () => {
      copySpanToForm(element, element.getAttribute("data-id"));
    })
  );

  document.getElementById("btnSave").addEventListener("click", () => {
    let contactId = document.getElementById("btnSave").getAttribute("data-id");
    listaContactes.querySelector("div[data-id='" + contactId + "']").remove();
    storage.setItem("contactes", JSON.stringify(arrayContactes));
    createContactes();
    listContactes();
    document.getElementById("btnAdd").style.display = "block";
    document.getElementById("btnSave").style.display = "none";
    document.getElementById("btnSave").removeAttribute("data-id");
  });
});
