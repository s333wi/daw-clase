import { wordList } from "./diccionari.js";
let inputFocus;
let currLetter;

window.addEventListener("load", function () {
  let word = chooseWord();
  init("game", word);
});

function chooseWord() {
  var word = wordList[Math.floor(Math.random() * wordList.length)];
  return word.toUpperCase();
}

function _(element) {
  return document.querySelector(element);
}
function init(gamediv, word) {
  window.pos = 0;
  drawWord(gamediv, word);
  drawKeyBoard(gamediv);
}

function drawWord(gamediv, word) {
  console.log(word);
  let wordDiv = document.createElement("div");
  wordDiv.id = "word";
  let game = _("#" + gamediv);

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
    if (i == 0) {
      input.setAttribute("autofocus", "");
      currLetter = word[i];
    }
  }
  game.appendChild(wordDiv);
}

function drawKeyBoard(gamediv) {
  var keyboard = document.createElement("div");
  keyboard.id = "keyboard";

  addKeys(["q", "w", "e", "r", "t", "y", "u", "i", "o", "p"], keyboard);
  addKeys(["a", "s", "d", "f", "g", "h", "j", "k", "l", "ç"], keyboard);
  addKeys(["Enter", "z", "x", "c", "v", "b", "n", "m", "del"], keyboard);

  var game = _("#" + gamediv);
  game.appendChild(keyboard);

  document.body.addEventListener("keyup", function (ev) {
    console.log(ev.key + " : " + ev.code);
    letterClick(ev.key);
    //change the value of the inputFocus
  });
}

function checkWord(letter) {
  console.log("check word");
  console.log(letter);
  console.log(currLetter);
  if (letter.toUpperCase() == currLetter) {
    console.log("correct letter");
    inputFocus.value = letter;
    window.pos++;
    inputFocus.parentElement.classList.add("right");
    inputFocus = inputFocus.parentElement.nextElementSibling.firstChild;
    inputFocus.focus();
    currLetter = inputFocus.parentElement.getAttribute("data-letter");
    console.log(currLetter);
  } else {
    inputFocus.parentElement.classList.add("wrong");
    setTimeout(function () {
      inputFocus.parentElement.classList.remove("wrong");
    }, 600);
  }
}

function letterClick(letter) {
  if (letter == "Enter") {
    console.log(document.activeElement);
    console.log("Enter key");
    console.log("Entered " + window.pos + " letters");
    window.pos = 0;
  } else if (letter == "Backspace" || letter == "del") {
    window.pos = window.pos > 0 ? window.pos - 1 : 0;
    console.log("Back key");
  }
  checkWord(letter);
}

function addKeys(letters, kbobj) {
  var keyrow = document.createElement("div");
  keyrow.classList.add("keyrow");

  for (let i = 0; i < letters.length; i++) {
    var btn = document.createElement("button");
    btn.textContent = letters[i];
    btn.setAttribute("data-key", letters[i]);
    btn.addEventListener("click", function (ev) {
      var key = ev.target;
      let letter = key.getAttribute("data-key");
      console.log(letter);
      letterClick(letter);
      if (letter != "Enter" && letter != "Backspace" && letter != "del") {
        inputFocus.value = letter;
      }
      console.log(inputFocus);
    });
    keyrow.append(btn);
  }
  kbobj.append(keyrow);
}

setTimeout(function () {
  inputFocus = document.activeElement;
  console.log(inputFocus);
}, 500);
