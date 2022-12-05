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
];

const cardBackImgPath = "/resources/trasera.png";
const cardContainerElem = document.querySelector(".card-container");
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
function createRandPos(arr) {
  for (var i = 3; i <= 24; i++) {
    arr.push(i);
  }
}

let cardsGame = [];
createCards();
createCards();
let cards = document.querySelectorAll(".card");
let randCardPos = [];
createRandPos(randCardPos);
console.log(randCardPos);

//Creem les cartes al tauler
function createCards() {
  cardsObj.forEach((card) => {
    createCard(card);
  });
}
let cardsFlipped = 0;
cards.forEach((card) => {
  card.addEventListener("click", function (e) {
    let innerCard = card.firstChild;
    if (innerCard.classList.contains("flip")) {
      innerCard.classList.remove("flip");
    } else if (cardsFlipped < 2) {
      addClassToElement(innerCard, "flip");
      cardsFlipped++;
    }
    if (cardsFlipped === 2) {
      setTimeout(() => {
        document.querySelectorAll(".flip").forEach((card) => {
          card.classList.remove("flip");
        });
        cardsFlipped = 0;
      }, 2000);
    }
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
