let pairs = 8;
let maxNumPairs = 12;
let totalCards = pairs * 2;
//Make an array of objects that will contain the id and the path of the front image with a loop, make one pair per path
let cardssObj = [];
for (let i = 1; i <= maxNumPairs*2; i+=1) {
  cardssObj.push({ id: i, imgPath: `./resources/frontal${i}.png` });
  cardssObj.push({ id: i + 1, imgPath: `./resources/frontal${i}.png` });
}
console.log(cardssObj);
//Array de les cartes amb un id i un path
let cardsObj = [
  { id: 1, imgPath: "./resources/frontal1.png" },
  { id: 2, imgPath: "./resources/frontal1.png" },
  { id: 3, imgPath: "./resources/frontal2.png" },
  { id: 4, imgPath: "./resources/frontal2.png" },
  { id: 5, imgPath: "./resources/frontal3.png" },
  { id: 6, imgPath: "./resources/frontal3.png" },
  { id: 7, imgPath: "./resources/frontal4.png" },
  { id: 8, imgPath: "./resources/frontal4.png" },
  { id: 9, imgPath: "./resources/frontal5.png" },
  { id: 10, imgPath: "./resources/frontal5.png" },
  { id: 11, imgPath: "./resources/frontal6.png" },
  { id: 12, imgPath: "./resources/frontal6.png" },
  { id: 13, imgPath: "./resources/frontal7.png" },
  { id: 14, imgPath: "./resources/frontal7.png" },
  { id: 15, imgPath: "./resources/frontal8.png" },
  { id: 16, imgPath: "./resources/frontal8.png" },
  { id: 17, imgPath: "./resources/frontal9.png" },
  { id: 18, imgPath: "./resources/frontal9.png" },
  { id: 19, imgPath: "./resources/frontal10.png" },
  { id: 20, imgPath: "./resources/frontal10.png" },
  { id: 21, imgPath: "./resources/frontal11.png" },
  { id: 22, imgPath: "./resources/frontal11.png" },
  { id: 23, imgPath: "./resources/frontal12.png" },
  { id: 24, imgPath: "./resources/frontal12.png" },
];

for (let i = 8; i <= 12; i += 2) {
  let option = document.createElement("option");
  option.value = i;
  option.textContent = `${i} Parelles`;
  document.getElementById("selPar").appendChild(option);
}

// Same path for the back image of the card
let cardBackImgPath = "./resources/trasera.png";
let cardContainerElem = document.querySelector(".card-container");
let matchSpan = document.getElementById("encerts");
let triesSpan = document.getElementById("intents");

//Crea un array amb els ids de les cartes de forma aleatoria i sense repetir
function createRandPos() {
  let baseArr = [];
  for (var i = 1; i <= totalCards; i++) {
    baseArr.push(i);
  }
  let baseArrClone = [...baseArr];
  //Ara creem un array agafant valors random segons la longitud
  let randArr = [];
  for (let i = 0; i < totalCards; i++) {
    let arr = baseArr[Math.floor(Math.random() * baseArr.length)];

    //Bucle que mira si el nou valor random es el mateix que el anterior.
    //La condicio del bucle es divideix en dos per el format que te l'array
    //de rutes de les imatges. Les cartes coincideixen si al ID de una carta
    //li sumem 1 (en el cas de que el id de la carta actual impar) o restant 1 (en l'altre cas, quan el ID actual sigui parell)
    let error = 0;
    while (randomCheck(arr, randArr)) {
      error++;
      if (baseArr.length === 1 && randomCheck(arr, randArr)) {
        baseArr = [...baseArrClone];
        randArr.length = 0;
        i = 0;
      } else {
        arr = baseArr[Math.floor(Math.random() * baseArr.length)];
      }
    }
    let index = baseArr.indexOf(arr);

    //Escurço l'array original per poder seguir randomitzant l'array resultant
    baseArr.splice(index, 1);

    randArr.push(arr);
  }
  return randArr;
}

//He tret el condicional a una funcio per a que sigui mes llegible el codi
function randomCheck(arr, randArr) {
  return (
    (arr % 2 === 0 && arr - 1 === randArr[randArr.length - 1]) ||
    (arr % 2 === 1 && arr + 1 === randArr[randArr.length - 1])
  );
}

//Creem les cartes al tauler
function createCards() {
  let randIds = createRandPos();
  randIds.forEach((id) => {
    //La primera del array es 0 i jo genero ids del 1-24 per tant he de restar 1 per accedir a la seva posicio
    createCard(cardsObj[id - 1]);
  });

  let cards = document.querySelectorAll(".card");
  let lastCardId;
  let cardsFlipped = 0;
  let flipTime;
  let matchResult = 0;
  let triesResult = 0;
  cards.forEach((card) => {
    card.addEventListener("click", function () {
      let innerCard = card.firstChild;
      //Agafem el data-id de la carta per poder comparar-la amb l'anterior
      let cardId = +card.getAttribute("data-id");

      //Si la carta no esta girada i no conte la classe match la girarem
      if (
        cardsFlipped < 2 &&
        !innerCard.classList.contains("match") &&
        !innerCard.classList.contains("flip")
      ) {
        innerCard.classList.add("flip");
        flipTime = undefined;
        clearTimeout(flipTime);
        cardsFlipped++;
      }

      //Preguntar si a les ternaries es poden ficar funcions anonimes
      if (
        cardsFlipped === 2 &&
        flipTime === undefined &&
        !innerCard.classList.contains("match")
      ) {
        flipTime = setTimeout(() => {
          document.querySelectorAll(".flip").forEach((card) => {
            card.classList.remove("flip");
            cardsFlipped = 0;
          });
        }, 1000);
        if (
          (cardId % 2 === 1 && cardId + 1 === lastCardId) ||
          (cardId % 2 === 0 && cardId - 1 === lastCardId)
        ) {
          clearTimeout(flipTime);

          document.querySelectorAll(".flip").forEach((card) => {
            card.classList.add("match");
            card.classList.remove("flip");
            card.style.cursor = "not-allowed";
          });
          matchSpan.innerHTML = ++matchResult;
          if (matchResult === pairs) {
            document.getElementById("gameWon").style.display = "block";
          }
          cardsFlipped = 0;
        }
        triesSpan.innerHTML = ++triesResult;
      }
      lastCardId = cardId;
    });
  });
}

//Inicialitzem el joc
createCards();

//Selector del nº de parelles en el joc
document.getElementById("selPar").addEventListener("change", function (e) {
  //Cada vegada que canvia reinicia el tauler i canvia el numero de parelles
  removeAllChildNodes(document.querySelector(".card-container"));
  pairs = +e.target.value;
  totalCards = pairs * 2;
  document.documentElement.style.setProperty("--num-cards-row", pairs / 2);
  document.documentElement.style.setProperty("--num-cards", totalCards);

  //El fico a none en cas de que si ha guanyat en un altre tauler i canvia de tauler no digui que ha guanyat
  document.getElementById("gameWon").style.display = "none";
  matchSpan.innerHTML = 0;
  triesSpan.innerHTML = 0;

  //Per ultim torno a inicialitzar el joc
  createCards();
});

//Constructor visual de cada carta
function createCard(card) {
  //Crear els elements de la carta
  let cardElem = createElement("div");
  let cardInner = createElement("div");
  let cardFront = createElement("div");
  let cardBack = createElement("div");

  //Crear les imatges del davant i del darrere
  let cardFrontImg = createElement("img");
  let cardBackImg = createElement("img");

  //Afegir la classe i el id a la carta
  addClassToElement(cardElem, "card");
  addIdToElement(cardElem, card.id);

  //Afegir la resta de les classes als seus fills
  addClassToElement(cardInner, "card-inner");
  addClassToElement(cardFront, "card-front");
  addClassToElement(cardBack, "card-back");
  addClassToElement(cardFrontImg, "card-img");
  addClassToElement(cardBackImg, "card-img");

  //Afegir el src al front i el back de les imatges
  addSrcToImg(cardFrontImg, card.imgPath);
  addSrcToImg(cardBackImg, cardBackImgPath);

  //Afegir les imatges al div frontal i div traser
  addChildElement(cardBack, cardBackImg);
  addChildElement(cardFront, cardFrontImg);

  //Afegir els divs frontals i trasers al div de la carta
  addChildElement(cardInner, cardFront);
  addChildElement(cardInner, cardBack);

  addChildElement(cardElem, cardInner);

  //Afegir la carta al tauler
  appendCardToTable(cardElem);
}

//Funcions de la creacio de les cartes per afegir classes, id, src i afegir fills
function createElement(elemType) {
  return document.createElement(elemType);
}
function addClassToElement(element, className) {
  element.classList.add(className);
}

function addIdToElement(element, idName) {
  element.setAttribute("data-id", idName);
}

function addSrcToImg(imgElement, src) {
  imgElement.src = src;
}

function addChildElement(parentElement, childElement) {
  parentElement.appendChild(childElement);
}

function appendCardToTable(card) {
  addChildElement(cardContainerElem, card);
}

//Funcio per eliminar totes les cartes quan canvia el nº de parelles
function removeAllChildNodes(parent) {
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
}
