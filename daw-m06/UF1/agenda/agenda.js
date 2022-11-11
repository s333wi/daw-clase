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
} else {
  var arrayContactes = new Array();
}

document.getElementById("btnAdd").addEventListener("click", () => {
  createContacte();
  listContactes();
  let formulari = document.getElementsByClassName("formulari");
  Array.from(formulari, (element) => element.value='');

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
  let contacte = {
    nom: formInputs[0],
    cognom: formInputs[1],
    telefon: formInputs[2],
    address: formInputs[3],
    localitat: formInputs[4],
  };
  arrayContactes.push(contacte);
  storage.setItem("contactes", JSON.stringify(arrayContactes));
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
  arrayContactes.splice(found, 1);
  listaContactes.querySelector("div[data-id='" + data_id + "']").remove();
  storage.setItem("contactes", JSON.stringify(arrayContactes));
}

function copySpanToForm(element, id) {
  let parent = element.parentNode.parentNode;
  var found = arrayContactes.findIndex((element) => element.telefon == id);
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

function exportContactes(text) {
  var blob = new Blob([text], { type: "aplication/json" });

  var elem = window.document.createElement("a");
  elem.href = window.URL.createObjectURL(blob);
  elem.download = "arxiu.txt";
  document.body.appendChild(elem);
  elem.click();
  document.body.removeChild(elem);
}

function readSingleFile(e) {
  var file = e.target.files[0];
  if (!file) {
    return;
  }
  var reader = new FileReader();
  reader.onload = function (e) {
    var contents = e.target.result;
    displayContents(contents);
  };
  reader.readAsText(file);
}

function displayContents(contents) {
  let storageAgenda = storage.getItem("contactes");
  let arrContactesImport = JSON.parse(contents);
  let arrContactesStorage = JSON.parse(storageAgenda);
  arrContactesStorage = arrContactesStorage.concat(arrContactesImport);

  //Ho fico en un map per eliminar els valors repetits
  let foo = new Map();
  for (const tag of arrContactesStorage) {
    foo.set(tag.telefon, tag);
  }
  let sortedContactes = [...foo.values()];
  storage.setItem("contactes", JSON.stringify(sortedContactes));
  listContactes();
}

document
  .getElementById("file-input")
  .addEventListener("change", readSingleFile, false);

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
    Array.from(inputsForm).forEach((e) => (e.value = ""));
  }
  e.stopPropagation();
});

searchFilter.addEventListener("change", (e) => {
  const element = e.target;
  if (element.id === "selFilter") {
    searchMode = element.options[element.selectedIndex].value;
  }
});

document.addEventListener("click", (e) => {
  const element = e.target;
  if (element.id === "backup") {
    let backup = JSON.stringify(arrayContactes);
    exportContactes(backup);
  }

  e.stopPropagation();
});

searchFilter.addEventListener("keyup", (e) => {
  const element = e.target;
  if (element.id === "inpQuery") {
    let searchQuery = element.value;
    searchQuery = searchQuery.toUpperCase();
    let arrContactes = listaContactes.getElementsByTagName("div");
    Array.from(arrContactes, (contacte) => {
      let textInfo = contacte.querySelector("span." + searchMode).innerHTML;
      if (textInfo.toUpperCase().indexOf(searchQuery) > -1 || textInfo === "") {
        contacte.style.display = "block";
      } else {
        contacte.style.display = "none";
      }
    });
  }
});
