let cardContainerElem = document.querySelector(".card-container");
let cardBackImgPath = "./resources/trasera.png";
let matchSpan = document.getElementById("encerts");
let triesSpan = document.getElementById("intents");

//Declaracio de la classe Card i els seus metodes i atributs
class Card {
  constructor(id, imgPath) {
    //Atributs necessaris per a la carta
    this.id = id;
    this.imgPath = imgPath;

    //Creo els elements necessaris per a la carta
    this.cardElem = this.createElement("div");
    this.cardInner = this.createElement("div");
    this.cardFront = this.createElement("div");
    this.cardBack = this.createElement("div");

    //Ara creem les imatges
    this.cardFrontImg = this.createElement("img");
    this.cardBackImg = this.createElement("img");
  }

  //Els metodes de la classe per crear els elements de la carta
  createElement(elemType) {
    return document.createElement(elemType);
  }

  addClassToElement(element, className) {
    element.classList.add(className);
  }

  addIdToElement(element, idName) {
    element.setAttribute("data-id", idName);
  }

  addSrcToImg(imgElement, src) {
    imgElement.src = src;
  }

  addChildElement(parentElement, childElement) {
    parentElement.appendChild(childElement);
  }

  addCardToTable(card) {
    this.addChildElement(cardContainerElem, card);
  }

  create() {
    //Afegir la classe i el id a la carta
    this.addClassToElement(this.cardElem, "card");
    this.addIdToElement(this.cardElem, this.id);

    //Afegir la resta de les classes als seus fills
    this.addClassToElement(this.cardInner, "card-inner");
    this.addClassToElement(this.cardFront, "card-front");
    this.addClassToElement(this.cardBack, "card-back");
    this.addClassToElement(this.cardFrontImg, "card-img");
    this.addClassToElement(this.cardBackImg, "card-img");

    //Afegir el src al front i el back de les imatges
    this.addSrcToImg(this.cardFrontImg, this.imgPath);
    this.addSrcToImg(this.cardBackImg, cardBackImgPath);

    //Afegir les imatges al div frontal i div traser
    this.addChildElement(this.cardBack, this.cardBackImg);
    this.addChildElement(this.cardFront, this.cardFrontImg);

    //Afegir els divs frontals i trasers al div de la carta
    this.addChildElement(this.cardInner, this.cardFront);
    this.addChildElement(this.cardInner, this.cardBack);

    this.addChildElement(this.cardElem, this.cardInner);

    //Afegir la carta al tauler
    this.addCardToTable(this.cardElem);
  }
}

//Creem les parelles de cartes
for (let i = 8; i <= 12; i += 2) {
  let option = document.createElement("option");
  option.value = i;
  option.textContent = `${i} Parelles`;
  document.getElementById("selPar").appendChild(option);
}

let pairs;

//Quan es carrega la pagina, es creen les cartes
document.addEventListener("DOMContentLoaded", () => {
  createCards();
});

//Quan es canvia el numero de parelles, es tornen a crear les cartes
let select = document.getElementById("selPar");

select.addEventListener("change", () => {
  createCards();
  matchSpan.innerHTML = 0;
  triesSpan.innerHTML = 0;
  document.getElementById("gameWon").style.display = "none";
});

//Funcio 'main' la cual s'encarrega de crear les cartes i afegir els events corresponents
function createCards() {
  //Primer mirem el numero de parelles que ha escollit l'usuari
  pairs = +document.getElementById("selPar").value;
  totalCards = pairs * 2;

  //Creem un array amb els ids de les cartes segons el numero de parelles
  let cardIds = [];
  for (let i = 1; i <= pairs; i++) {
    //El afegeixo dos vegades per no haber de repetir dues vegades el bucle,
    //d'aquesta manera tinc un array amb els ids de les cartes en parelles
    cardIds.push(i, i);
  }

  //Barregem els ids de les cartes per a que no estiguin sempre en el mateix ordre,
  //aquest metode es conegut com 'Fisher-Yates shuffle', el vaig descobrir a StackOverflow
  function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      let j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
  }

  let shuffledCardIds = shuffle(cardIds);

  //Creem un array de cartes amb els ids barrejats i els paths de les imatges
  let cards = shuffledCardIds.map(
    (id) => new Card(id, `./resources/frontal${id}.png`)
  );

  //Eliminem les cartes anteriors del tauler
  while (cardContainerElem.firstChild) {
    cardContainerElem.removeChild(cardContainerElem.firstChild);
  }

  //Creem les cartes i les afegim al tauler, canvio el numero de cartes per fila del CSS
  cards.forEach((card) => card.create());
  document.documentElement.style.setProperty("--num-cards-row", pairs / 2);
  document.documentElement.style.setProperty("--num-cards", totalCards);

  addEvent();
}

//Funcio per afegir els events a les cartes
function addEvent() {
  //Primer agafem totes les cartes del tauler
  let cards = document.querySelectorAll(".card");

  //Variables per guardar el resultat de les partides
  let cardsFlipped = 0;
  let flipTime;
  let matchResult = 0;
  let triesResult = 0;

  //Variables per guardar la carta anterior i poder comparar-la amb l'actual
  let lastCardId;

  //Afegim el event principal a les cartes
  cards.forEach((card) => {
    card.addEventListener("click", function () {
      //Agafem el primer fill de la carta, que es el div amb la classe 'card-inner'
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
        if (cardId === lastCardId) {
          clearTimeout(flipTime);

          document.querySelectorAll(".flip").forEach((card) => {
            card.classList.remove("flip");
            card.classList.add("match");
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
//       const action = (cardId === lastCardId)
//   ? () => {
//     clearTimeout(flipTime);
//     document.querySelectorAll(".flip").forEach((card) => {
//       card.classList.remove("flip");
//       card.classList.add("match");
//       card.style.cursor = "not-allowed";
//     });
//     matchSpan.innerHTML = ++matchResult;
//     if (matchResult === pairs) {
//       document.getElementById("gameWon").style.display = "block";
//     }
//     cardsFlipped = 0;
//   }
//   : () => {
//     setTimeout(() => {
//       document.querySelectorAll(".flip").forEach((card) => {
//         card.classList.remove("flip");
//         cardsFlipped = 0;
//       });
//     }, 1000);
//     triesSpan.innerHTML = ++triesResult;
//   };
// if (
//   cardsFlipped === 2 &&
//   flipTime === undefined &&
//   !innerCard.classList.contains("match")
// ) {
//   action();
// }
      lastCardId = cardId;
    });
  });
}
