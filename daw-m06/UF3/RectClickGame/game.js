var startTime = new Date().getTime();
//Temps total del contador, si no es fica minuts s'utilitzaran nomes els segons
var minuts = 1;
var segons = 25;
var tempsTotal = minuts * 60 || segons;


//Constructor del contador
function Countdown(elem, seconds) {
  //
   var timerObj = {};
   timerObj.elem = elem;
   timerObj.seconds = seconds;
   timerObj.totalTime = seconds * 100;
   timerObj.usedTime = 0;
   timerObj.startTime = +new Date();
   timerObj.timerID = null;
 
   //Metodes del contador
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

//Funcions del contador

//Funcio main del contador
function timerCount(timer) {
  timer.usedTime = Math.floor((+new Date() - timer.startTime) / 10);
  var remainingTime = timer.totalTime - timer.usedTime;
  timer.elem.style.color = remainingTime <= 1000 ? "red" : "black";
  if (remainingTime <= 0) {
    alert("TIMEUP");
    clearInterval(gameTargetInterval);
    gameTargetInterval = 0;
    clearInterval(timer.timerID);
    btnStart.style.display = "block";
    btnStop.style.display = "none";
    playGame=false;
    timer.reset();
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

//Reinicia el contador i les seves variables
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

//El mateix amb les unitats de les dimensions
var dimensionsUnit = "px";

//Selecciono i aplico les dimensions a les figures
var boxGame = document.getElementById("tauler");
var targetGame = document.getElementById("target");
boxGame.style.width = boxWidth + dimensionsUnit;
boxGame.style.height = boxHeight + dimensionsUnit;
targetGame.style.width = targetWidth + dimensionsUnit;
targetGame.style.height = targetHeight + dimensionsUnit;

//Parent dels botons i contador
var clickCounter;
var counterResult = document.getElementById("counter-result");
var counterAccumulator = document.getElementById("correctClick");
var btnStart = document.getElementById("startGame");
var btnStop = document.getElementById("stopGame");

//Id interval del target
var gameTargetInterval;
var gameTargetIntervalInitTime = 2000;
var gameTargetIntervalTime = gameTargetIntervalInitTime;

//Posicions inicials del target
var posX = 0;
var posY = 0;

function moveTarget() {
  posX = Math.floor(Math.random() * (boxWidth - targetWidth));
  posY = Math.floor(Math.random() * (boxHeight - targetHeight));
  targetGame.style.left = posX.toString() + dimensionsUnit;
  targetGame.style.top = posY.toString() + dimensionsUnit;
}

//Variable per veure si es pot jugar, fins que no doni al start no es pot
var playGame; 

counterResult.addEventListener("click", function (e) {
  const element = e.target;
  if (element.id === "startGame") {
    clickCounter = 0;
    counterAccumulator.innerHTML = clickCounter;
    targetGame.style.left = "0" + dimensionsUnit;
    targetGame.style.top = "0" + dimensionsUnit;
    alert("Empieza");
    if (gameTargetInterval) {
      moveTarget();
    } else {
      moveTarget();
      gameTargetInterval = setInterval(function () {
        moveTarget();
      }, gameTargetIntervalInitTime);
    }
    countdown.reset();
    countdown.start();
    element.nextElementSibling.style.display = "block";
    element.style.display = "none";
    gameTargetIntervalTime = gameTargetIntervalInitTime;
    playGame=true;
  } else if (element.id === "stopGame") {
    playGame=false;
    clearInterval(gameTargetInterval);
    element.previousElementSibling.style.display = "block";
    element.style.display = "none";
    countdown.stop();
  }
});
boxGame.addEventListener("click", function (e) {
  const element = e.target;
  if (element.id === "target" && gameTargetInterval && playGame) {
    clearInterval(gameTargetInterval);
    clickCounter++;
    if (gameTargetIntervalTime > 500) gameTargetIntervalTime -= 100;
    moveTarget();
    gameTargetInterval = setInterval(function () {
      moveTarget();
    }, gameTargetIntervalTime);
    counterAccumulator.innerHTML = clickCounter;
    console.log(clickCounter);
  }
});
