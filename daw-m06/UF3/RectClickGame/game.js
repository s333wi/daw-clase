var startTime = new Date().getTime();
//Temps total del contador, si no es fica minuts s'utilitzaran nomes els segons
var minuts = 0;
var segons = 25;
var tempsTotal = minuts * 60 || segons;

//Funcions del contador

//Funcio main del contador
function timerCount(timer) {
  timer.usedTime = Math.floor((+new Date() - timer.startTime) / 10);

  var remainingTime = timer.totalTime - timer.usedTime;
  timer.elem.style.color = remainingTime <= 1000 ? "red" : "black";
  if (remainingTime <= 0) {
    clearInterval(timer.timerID);
    timer.reset();
    console.log("TIMEUP");
  } else {
    var mi = Math.floor(remainingTime / (60 * 100));
    var ss = Math.floor((remainingTime - mi * 60 * 100) / 100);
    var ms = remainingTime - Math.floor(remainingTime / 100) * 100;

    timer.elem.innerHTML =
      fillZero(mi) + ":" + fillZero(ss) + "." + fillZero(ms) + "ms";
  }
}

//Emplena els zeros de l'esquerra quan el numero te 1 digit
function fillZero(num) {
  return num < 10 ? "0" + num : num;
}

//
function resetTimer(timerObj, seconds) {
  if (timerObj.timerID) {
    clearInterval(timerObj.timerID);
    timerObj.elem.innerHTML = "00:00.00ms";
    timerObj.totalTime = seconds * 100;
    timerObj.usedTime = 0;
    timerObj.startTime = +new Date();
    timerObj.timerID = null;
    timerObj.elem.style.color = "black";
  }
}

//Constructor del contador
function Countdown(elem, seconds) {
  var timerObj = {};

  timerObj.elem = elem;
  timerObj.seconds = seconds;
  timerObj.totalTime = seconds * 100;
  timerObj.usedTime = 0;
  timerObj.startTime = +new Date();
  timerObj.timerID = null;

  timerObj.count = function () {
    timerCount(timerObj);
  };

  timerObj.reset = function () {
    resetTimer(timerObj, seconds);
  };

  timerObj.start = function () {
    if (!timerObj.timerID) {
      timerObj.timerID = setInterval(timerObj.count, 1);
    }
  };

  timerObj.stop = function () {
    console.log("usedTime = " + countdown.usedTime);
    if (timerObj.timerID) clearInterval(timerObj.timerID);
  };

  return timerObj;
}

//Creacio del contador
var span = document.getElementById("time");
var countdown = new Countdown(span, tempsTotal);

//Agregar els events als botons del contador i les seves accions corresponents
document.getElementById("stop").addEventListener("click", function () {
  countdown.stop();
});

document.getElementById("reset").addEventListener("click", function () {
  countdown.reset();
});

//Declaro les dimensions aqui per si un dia les volem canviar
var boxWidth = 800;
var boxHeight = 500;
var targetWidth = 50;
var targetHeight = 50;
var dimensionsUnit = "px";
//Selecciono i aplico les dimensions a les figures
var boxGame = document.getElementById("tauler");
var targetGame = document.getElementById("target");
boxGame.style.width = boxWidth + dimensionsUnit;
boxGame.style.height = boxHeight + dimensionsUnit;
targetGame.style.width = targetWidth + dimensionsUnit;
targetGame.style.height = targetHeight + dimensionsUnit;

var counterResult = document.getElementById("counter-result");

counterResult.addEventListener("click", function (e) {
  const element = e.target;
  if (element.id === "startGame") {
    alert("Empieza");
    var gameTargetInterval = setInterval(function () {
      var posX = Math.floor(Math.random() * (boxWidth - targetWidth));
      var posY = Math.floor(Math.random() * (boxHeight - targetHeight));
      targetGame.style.left = posX.toString() + dimensionsUnit;
      targetGame.style.top = posY.toString() + dimensionsUnit;
    }, 1500);
    countdown.start();
  }
});
var clickCounter = 0;
boxGame.addEventListener("click", function (e) {
  const element = e.target;
  if (element.id === "target") {
    clickCounter++;
    console.log(clickCounter);
  }
});
