let storage = window.localStorage;
let jsonAgenda = storage.getItem("contactes");
let listaContactes = document.getElementById("contactes");
let contacteTemplate = document.getElementById("contacteTemplate");
const formContacte = document.getElementById("formAgenda");
const searchFilter = document.getElementById("buscador");
const modeFilter = document.getElementById("selFilter");
var searchMode = modeFilter.options[modeFilter.selectedIndex].value;

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
  //Els borro primer per a que no surtin repetits
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
});

listaContactes.addEventListener("click", (e) => {
  const element = e.target;
  if (element.classList.contains("personaEliminar")) {
    if (confirm("Segur que vols esborrar aquest contacte??") === true)
      deleteContacte(element);
  }
  if (element.classList.contains("personaEdit")) {
    copySpanToForm(element, element.getAttribute("data-id"));
  }
  e.stopPropagation();
});

formContacte.addEventListener("click", (e) => {
  const element = e.target;
  if (element.id === "btnSave") {
    element.getAttribute("data-id");
    let contactId = element.getAttribute("data-id");
    listaContactes.querySelector("div[data-id='" + contactId + "']").remove();
    storage.setItem("contactes", JSON.stringify(arrayContactes));
    createContacte();
    listContactes();
    document.getElementById("btnAdd").style.display = "block";
    element.style.display = "none";
    element.removeAttribute("data-id");
    let inputsForm = formContacte.querySelectorAll(".formulari");
    console.log(inputsForm);
    Array.from(inputsForm).forEach((e) => (e.value = ""));
  }
  e.stopPropagation();
});

searchFilter.addEventListener("change", (e) => {
  const element = e.target;
  if (element.id === "selFilter") {
    searchMode = element.options[element.selectedIndex].value;
  }
  console.log(searchMode);
});

searchFilter.addEventListener("keyup", (e) => {
  const element = e.target;
  console.log(searchMode);
  if (element.id === "inpQuery") {
    let searchQuery = element.value;
    searchQuery = searchQuery.toUpperCase();
    let arrContactes = listaContactes.getElementsByTagName("div");
    Array.from(arrContactes, (contacte) => {
      console.log(contacte);
      console.log(searchQuery);
      let textInfo = contacte.querySelector("span." + searchMode).innerHTML;
      console.log(textInfo);
      if (textInfo.toUpperCase().indexOf(searchQuery) > -1 || textInfo === "") {
        contacte.style.display = "block";
      } else {
        contacte.style.display = "none";
      }
    });
  }
});
