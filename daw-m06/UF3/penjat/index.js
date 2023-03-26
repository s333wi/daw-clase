import { wordList } from "./diccionari.js";
/**
 * @type {HTMLInputElement} inputFocus El input que te el focus
 * @type {string} currLetter La lletra correcta que s'ha de escriure
 * @type {number} countdownTimer El id del interval per al countdown
 * @type {number} timeLeft El temps que queda per acabar la
 * @type {boolean} gamePlaying Si el joc esta en marxa o no
 */
let inputFocus;
let currLetter;
let countdownTimer;
let timeLeft = 60;
let gamePlaying = true;
let goodTry = 0;
let badTry = 0;

//Quan carregui la pagina es crida a la funcio init i escollim una paraula
window.addEventListener("load", function () {
  let word = chooseWord();
  init("game", word);
});

/**
 * Funcions del joc del penjat
 */

//Funcio per escollir una paraula aleatoria del array wordList
function chooseWord() {
  let word = wordList[Math.floor(Math.random() * wordList.length)];
  return word.toUpperCase();
}

function _(element) {
  return document.querySelector(element);
}

//Funcio per dibuixar el joc amb la paraula i el teclat
function init(gamediv, word) {
  window.pos = 0;
  drawWord(gamediv, word);
  drawKeyBoard(gamediv);
  drawScore(gamediv);
  drawCountDown(gamediv);
  drawRepeatButton(gamediv);
}

//Funcio per dibuixar la paraula amb els inputs
function drawWord(gamediv, word) {
  console.log(word);
  let wordDiv = document.createElement("div");
  wordDiv.id = "word";
  let game = _("#" + gamediv);

  //Funcio per crear les caselles de la paraula amb els inputs
  for (let i = 0; i < word.length; i++) {
    let box = document.createElement("div");
    box.classList.add("box");
    box.setAttribute("data-letter", word[i]);

    let input = document.createElement("input");

    input.setAttribute("type", "text");
    input.setAttribute("maxlength", "1");
    input.setAttribute("size", "1");
    input.addEventListener("click", function (ev) {
      console.log(ev.target);
      inputFocus = ev.target;
    });

    box.appendChild(input);
    wordDiv.appendChild(box);
    //Si es la primera lletra li donem el focus i la guardem a la variable inputFocus
    if (i == 0) {
      inputFocus = input;
      input.setAttribute("autofocus", "");
      currLetter = word[i];
    }
  }
  game.appendChild(wordDiv);
}

//Funcio per dibuixar el teclat
function drawKeyBoard(gamediv) {
  let keyboard = document.createElement("div");
  keyboard.id = "keyboard";

  addKeys(["q", "w", "e", "r", "t", "y", "u", "i", "o", "p"], keyboard);
  addKeys(["a", "s", "d", "f", "g", "h", "j", "k", "l", "ç"], keyboard);
  addKeys(["Enter", "z", "x", "c", "v", "b", "n", "m", "del"], keyboard);

  let game = _("#" + gamediv);
  game.appendChild(keyboard);

  document.body.addEventListener("keyup", function (ev) {
    letterClick(ev.key);
  });
}

//Funcio que crea el contador de temps
function drawCountDown(gamediv) {
  let countdown = document.createElement("div");
  countdown.id = "countdown";
  let game = _("#" + gamediv);
  game.appendChild(countdown);
  startCounter();
}

//Funcio que comença el contador de temps
function startCounter() {
  timeLeft = 60;
  countdownTimer = setInterval(function () {
    if (timeLeft <= 0) {
      clearInterval(countdownTimer);
      let repeatButton = _("#repeatButton");
      repeatButton.style.display = "block";

      document.getElementById("countdown").innerHTML = "Ha acabat el temps";
      gamePlaying = false;
      alert("Has perdut si vols tornar a jugar prem el boto de repetir");

      //Els inputs que no estiguin omplerts els desactivem
      let inputs = document.querySelectorAll("input");
      for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value == "") {
          inputs[i].disabled = true;
          inputs[i].parentElement.classList.add("finishWrong");
        }
      }
    } else {
      document.getElementById("countdown").innerHTML =
        timeLeft + " segons restants";
    }
    timeLeft--;
  }, 1000);
}

function drawScore(gamediv) {
  let score = document.createElement("div");
  score.id = "score";
  score.innerHTML = "Acerts: " + goodTry + " Fallos: " + badTry;
  let game = _("#" + gamediv);
  game.appendChild(score);
}

//Funcio que crea el boto de repetir el joc
function drawRepeatButton(gamediv) {
  let repeatButton = document.createElement("button");
  repeatButton.id = "repeatButton";
  repeatButton.textContent = "Repetir";
  repeatButton.style.display = "none";

  repeatButton.addEventListener("click", function () {
    //Reiniciem el joc amb les seves variables
    if (!gamePlaying) {
      repeatButton.style.display = "none";
      resetGame();
    }
  });
  let game = _("#" + gamediv);
  game.appendChild(repeatButton);
}

function resetGame() {
  clearInterval(countdownTimer);
  goodTry = 0;
  badTry = 0;
  let word = chooseWord();
  let game = _("#game");
  game.innerHTML = "";
  init("game", word);
  gamePlaying = true;
  inputFocus.focus();
}

//Funcio que comprova si la lletra que s'ha escrit es correcta o no
function checkWord(letter) {
  if (gamePlaying) {
    let score = _("#score");
    if (letter.toUpperCase() == currLetter) {
      goodTry++;
      window.pos++;
      inputFocus.parentElement.classList.add("right");

      //Si no es la ultima lletra li donem el focus a la seguent
      if (window.pos < inputFocus.parentElement.parentElement.children.length) {
        inputFocus.value = letter;
        inputFocus = inputFocus.parentElement.nextElementSibling;
        inputFocus = inputFocus.firstElementChild;
        inputFocus.focus();
        currLetter = inputFocus.parentElement.getAttribute("data-letter");
      } else {
        inputFocus.value = letter;
        alert("Has guanyat si vols tornar a jugar prem el boto de repetir");
        clearInterval(countdownTimer);
        gamePlaying = false;
        
        let repeatButton = _("#repeatButton");
        repeatButton.style.display = "block";
      }
    } else {
      badTry++;
      inputFocus.parentElement.classList.add("wrong");
      setTimeout(function () {
        inputFocus.parentElement.classList.remove("wrong");
      }, 600);
    }
    score.innerHTML = "Acerts: " + goodTry + " Fallos: " + badTry;
  }
}

//Funcio que comprova quina tecla s'ha pitjat al teclat en pantalla
function letterClick(letter) {
  if (letter == "Enter") {
    window.pos = 0;
  } else if (letter == "Backspace" || letter == "del") {
    window.pos = window.pos > 0 ? window.pos - 1 : 0;
    if (!inputFocus.disabled) {
      inputFocus.value = letter;
    }
  }
  checkWord(letter);
}

//Funcio que dibuixa el teclat
function addKeys(letters, kbobj) {
  let keyrow = document.createElement("div");
  keyrow.classList.add("keyrow");

  for (let i = 0; i < letters.length; i++) {
    let btn = document.createElement("button");
    btn.textContent = letters[i];
    btn.setAttribute("data-key", letters[i]);
    btn.addEventListener("click", function (ev) {
      let key = ev.target;
      let letter = key.getAttribute("data-key");
      letterClick(letter);
    });
    keyrow.append(btn);
  }
  kbobj.append(keyrow);
}

//He de guardar l'input d'aquesta manera perque sino el activeElement al carregar la pagina es el body i no el input
//he intentat ficar-ho al event onload i encara aixi el activeElement es el body
setTimeout(function () {
  inputFocus = document.activeElement;
}, 500);
