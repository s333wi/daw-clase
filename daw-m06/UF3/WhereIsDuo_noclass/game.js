const pairs = 12;
const totalCards = pairs * 2;
const cardsObj = [
  { id: 1, imgPath: "/resources/frontal1.png" },
  { id: 2, imgPath: "/resources/frontal2.png" },
  { id: 3, imgPath: "/resources/frontal3.png" },
  { id: 4, imgPath: "/resources/frontal4.png" },
  { id: 5, imgPath: "/resources/frontal5.png" },
  { id: 6, imgPath: "/resources/frontal6.png" },
  { id: 7, imgPath: "/resources/frontal7.png" },
  { id: 8, imgPath: "/resources/frontal8.png" },
  { id: 9, imgPath: "/resources/frontal9.png" },
  { id: 10, imgPath: "/resources/frontal10.png" },
  { id: 11, imgPath: "/resources/frontal11.png" },
  { id: 12, imgPath: "/resources/frontal12.png" },
  { id: 13, imgPath: "/resources/frontal1.png" },
  { id: 14, imgPath: "/resources/frontal2.png" },
  { id: 15, imgPath: "/resources/frontal3.png" },
  { id: 16, imgPath: "/resources/frontal4.png" },
  { id: 17, imgPath: "/resources/frontal5.png" },
  { id: 18, imgPath: "/resources/frontal6.png" },
  { id: 19, imgPath: "/resources/frontal7.png" },
  { id: 20, imgPath: "/resources/frontal8.png" },
  { id: 21, imgPath: "/resources/frontal9.png" },
  { id: 22, imgPath: "/resources/frontal10.png" },
  { id: 23, imgPath: "/resources/frontal11.png" },
  { id: 24, imgPath: "/resources/frontal12.png" },
];

const cardBackImgPath = "/resources/trasera.png";
const cardContainerElem = document.querySelector(".card-container");
const matchSpan = document.getElementById("encerts");
const triesSpan = document.getElementById("intents");
/* <div class="card">
<div class="card-inner">
    <div class="card-front">
        <img src="/images/card-JackClubs.png" alt="" class="card-img">
    </div>
    <div class="card-back">
        <img src="/images/card-back-Blue.png" alt="" class="card-img">
    </div>
</div>
</div> */
function createRandPos() {
  let baseArr = [];
  for (var i = 1; i <= totalCards; i++) {
    baseArr.push(i);
  }

  let randArr = [];
  for (let i = 0; i < totalCards; i++) {
    let arr = baseArr[Math.floor(Math.random() * baseArr.length)];
    console.log(arr);
    while ((arr + pairs || arr - pairs) === baseArr[baseArr.length - 1]) {
      console.log(arr);
      console.log("coincide");
      console.log("current: " + arr, "last:" + baseArr[baseArr.length - 1]);
      arr = baseArr[Math.floor(Math.random() * baseArr.length)];
    }
    let index = baseArr.indexOf(arr);

    baseArr.splice(index, 1);

    randArr.push(arr);
  }
  return randArr;
}

const randArr = createRandPos();

console.log(randArr);
createCards();

//Creem les cartes al tauler
function createCards() {
  randArr.forEach((id) => {
    //La primera del array es 0 i jo genero ids del 1-24 per tant he de restar 1 per accedir a la seva posicio
    createCard(cardsObj[id - 1]);
  });
}

let cards = document.querySelectorAll(".card");
let lastCardId;
let cardsFlipped = 0;
let flipTime;
let matchResult = 0;
let triesResult = 0;
cards.forEach((card) => {
  card.addEventListener("click", function (e) {
    let innerCard = card.firstChild;
    console.log("Last card: " + lastCardId);

    if (innerCard.classList.contains("flip")) {
      innerCard.classList.remove("flip");
    } else if (cardsFlipped < 2) {
      addClassToElement(innerCard, "flip");
      if (flipTime && cardsFlipped === 0) {
        flipTime = undefined; //preguntar per que no funciona amb clear interval
      }
      cardsFlipped++;
    }

    if (cardsFlipped === 2 && flipTime === undefined) {
      if (
        (+card.id <= 12 && +card.id + 12 === lastCardId) ||
        (+card.id > 12 && +card.id - 12 === lastCardId)
      ) {
        document.querySelectorAll(".flip").forEach((card) => {
          card.classList.add("match");
          card.classList.remove("flip");
          console.log({ card });
        });
        matchSpan.innerHTML = ++matchResult;
      } else {
        triesSpan.innerHTML = ++triesResult;
      }
      flipTime = setTimeout(() => {
        document.querySelectorAll(".flip").forEach((card) => {
          card.classList.remove("flip");
        });
        cardsFlipped = 0;
      }, 2000);
    }
    lastCardId = +card.id;
  });
});

function createCard(card) {
  //Crear els divs per mostrar una carta
  const cardElem = createElement("div");
  const cardInner = createElement("div");
  const cardFront = createElement("div");
  const cardBack = createElement("div");

  //Crear les imatges del davant i del darrere
  const cardFrontImg = createElement("img");
  const cardBackImg = createElement("img");

  //Afegir la classe i el id a una carta
  addClassToElement(cardElem, "card");

  addIdToElement(cardElem, card.id);
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
  addCardToTable(cardElem);
}

function createElement(elemType) {
  return document.createElement(elemType);
}

function addClassToElement(element, className) {
  element.classList.add(className);
}

function addIdToElement(element, idName) {
  element.id = idName;
}

function addSrcToImg(imgElement, src) {
  imgElement.src = src;
}

function addChildElement(parentElement, childElement) {
  parentElement.appendChild(childElement);
}

function addCardToTable(card) {
  addChildElement(cardContainerElem, card);
}
