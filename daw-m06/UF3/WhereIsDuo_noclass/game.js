const cardsObj = [
  { id: 1, imgPath: "/resources/frontal1.png" },
  { id: 2, imgPath: "/resources/frontal2.png" },
  { id: 3, imgPath: "/resources/frontal3.png" },
  { id: 4, imgPath: "/resources/frontal4.png" },
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
let cardsGame = [];
createCards();
cards = document.querySelectorAll(".card");
flipCards(true);

//Creem les cartes al tauler
function createCards() {
  cardsObj.forEach((card) => {
    createCard(card);
  });
}

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
  const cardPositionClass = mapCardIdToTable(card);

  const cardPositionElement = document.querySelector(cardPositionClass);

  addChildElement(cardPositionElement, card);
}

function mapCardIdToTable(card) {
  if (card.id == 1) {
    return ".card-pos-a";
  } else if (card.id == 2) {
    return ".card-pos-b";
  } else if (card.id == 3) {
    return ".card-pos-c";
  } else if (card.id == 4) {
    return ".card-pos-d";
  }
}

function flipCard(card, flipToBack) {
  const innerCardElem = card.firstChild;
  if (flipToBack && !innerCardElem.classList.contains("flip")) {
    innerCardElem.classList.add("flip");
  } else if (innerCardElem.classList.contains("flip")) {
    innerCardElem.classList.remove("flip");
  }
}

function flipCards(flipToBack) {
  cards.forEach((card, index) => {
      flipCard(card, flipToBack);
  });
}
