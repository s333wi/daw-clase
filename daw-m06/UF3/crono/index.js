window.onload = function () {
  //Variables globals per a poder parar el crono i fer-lo funcionar
  let boolStop = false;
  let animFrameId;
  let timeStart;
  let timeNow;
  let miliseconds;
  let seconds;
  let minutes;
  let timePaused;

  //Variables per a poder dibuixar el crono
  let espaiBarra = 20;
  let canvas = document.getElementById("crono");
  let ctx = canvas.getContext("2d");
  let text = "00:00";

  //Funcio main que fa la animacio del crono
  function crono() {
    if (!boolStop) {
      timeNow = new Date(new Date() - timeStart);
      //Agafem els milisegons, segons i minuts per poder dibuixar el temps del cronòmetre
      //I els convertim a string per poder afegir els 0 que falten a l'esquerra
      miliseconds = timeNow.getMilliseconds().toString().padStart(3, "0");
      seconds = timeNow.getSeconds().toString().padStart(2, "0");
      minutes = timeNow.getMinutes().toString().padStart(2, "0");
      text = `${minutes}:${seconds}`;
      printCrono();

      window.requestAnimationFrame(crono);
    }
  }

  //Funcions per a poder parar, començar i reiniciar el crono
  function startCrono() {
    boolStop = false;
    //Si el crono esta pausat, agafem el temps que ha passat i el guardem a timeStart per a poder continuar
    //Si no, guardem el temps actual a timeStart per a poder començar a contar
    if (timePaused) {
      timeStart = new Date(new Date() - timePaused);
      timePaused = null;
    } else {
      timeStart = new Date();
    }
    animFrameId = window.requestAnimationFrame(crono);
  }

  function stopCrono() {
    //Cancelo la peticio de frame per a que no es dibuixi el crono
    if (animFrameId) {
      window.cancelAnimationFrame(animFrameId);
    }
    //Canvio el boolea per a que no es dibuixi el crono
    boolStop = true;

    //Guardem el temps que ha passat per a poder continuar despres el crono
    timePaused = new Date(new Date() - timeStart);
  }

  function resetCrono() {
    stopCrono();
    //Reiniciem les variables per a poder tornar a començar el crono
    text = "00:00";
    timeStart = null;
    timePaused = null;
    timeNow = null;
    miliseconds = undefined;
    animFrameId = requestAnimationFrame(printCrono);
  }

  //Funcio per a crear el gradient de la barra
  function createGradient() {
    let gradient = ctx.createLinearGradient(0, 0, canvas.width, 0);
    gradient.addColorStop("0", "#000");
    gradient.addColorStop("1.0", "#9933ff");
    return gradient;
  }

  //Funcio per a dibuixar el crono i la barra
  function printCrono() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    //Agafem l'amplada del text per poder dibuixar la barra
    let widthText = ctx.measureText(text).width;
    //Creem el gradient per la barra
    let gradientStyle = createGradient();
    //Dibuixem el temps del cronòmetre
    ctx.font = "bold 100px Arial";
    ctx.textAlign = "center";
    ctx.fillStyle = "black";
    ctx.fillText(text, canvas.width / 2, canvas.height / 2 - espaiBarra);
    //Guardo aqui el context per a poder dibuixar el reflexe del crono
    ctx.save();
    ctx.transform(1, 0, -0.5, 1, 35, 0);

    ctx.textAlign = "center";
    ctx.font = "20px Arial";
    ctx.fillStyle = miliseconds % 1000 < 999 ? gradientStyle : "white"; //Quan arriba al segon es reinicia
    ctx.fillText(
      miliseconds,
      canvas.width / 2 + widthText / 2 + 50,
      miliseconds / 10 + 50
      // Sumo 50 ja que 1 segon son 1000 milisegons i 1000/10 = 100 per tant sumo
      // per a que estigui mes o menos al mig del canvas ja que el canvas es de 500x200
    );

    //Dibuixem la barra del cronòmetre
    ctx.lineWidth = 2;
    ctx.fillRect(
      widthText / 2,
      canvas.height / 2 - espaiBarra / 2,
      (miliseconds / 1000) * widthText,
      //Ample dinamic de la barra respectant l'amplada del text
      espaiBarra
    );

    //Restauro el context per a poder dibuixar el reflexe del crono com avans
    ctx.restore();
    //Guardo aqui el context per a poder tornar despres de fer la rotacio
    ctx.save();
    //Dibuixem el reflexe del crono
    ctx.translate(canvas.width / 2, canvas.height / 2 + espaiBarra);

    ctx.scale(1, -1);

    //Inclinacio del reflex
    ctx.transform(1, 0, 0.5, 1, 0, 0);
    ctx.globalAlpha = 0.1;

    ctx.fillText(text, 0, 0);

    //Finalment restaurem el context per a poder dibuixar el crono en la seguent iteracio
    ctx.restore();
  }

  //Afegeixo els listeners als botons
  document.getElementById("cronoStart").addEventListener("click", startCrono);
  document.getElementById("cronoPause").addEventListener("click", stopCrono);
  document.getElementById("cronoReset").addEventListener("click", resetCrono);

  //Printo per primera vegada el crono
  printCrono();
};
