document.addEventListener("DOMContentLoaded", function () {
  /**
   * Variables globals
   * @type {HTMLButtonElement} btnStartCanvas
   * @type {boolean} blnStartCanvas
   * @type {HTMLCanvasElement} canvas
   * @type {CanvasRenderingContext2D} ctx
   * @type {number} animId
   * @type {number} startX
   * @type {number} startY
   * @type {Audio} audioAnim
   */
  let btnStartCanvas = document.getElementById("canvasStart");
  let blnStartCanvas = false;
  let canvas = document.getElementById("dawAudi");
  let ctx = canvas.getContext("2d");
  let animId;

  //Posicio inicial del logo
  let startX = canvas.width / 2 - 105;
  let startY = -100;

  //Audio animacio
  let audioAnim = new Audio("./me-gusta-canvas.mp3");
  /**
   * Functions
   */

  /**
   * Dibuixa el canvas amb el fons de l'Audi
   * @return {void}
   */
  function drawCanvas() {
    if (ctx) {
      ctx.save();
      //Primer dibuixem el fons del canvas
      let audiFons = new Image();
      audiFons.src = "./audi-fons.png";
      audiFons.onload = function () {
        //Quan la imatge s'hagi carregat, la dibuixem
        ctx.drawImage(audiFons, 0, 0, canvas.width, canvas.height);

        //La resta de dibuixos nomes es faran si s'ha clicat el boto
        if (blnStartCanvas) {
          //Si el logo ha arribat al mig del canvas, parem l'animació
          if (startY < canvas.height / 2) {
            drawAudiLogo();
            //Augmentem la posicio del logo per a que es mogui cap avall
            startY += 0.3;
            animId = window.requestAnimationFrame(drawCanvas);
          } else {
            window.cancelAnimationFrame(animId);
            drawFinal();
            restartCanvas();
          }
        }
        ctx.restore();
      };
    }
  }

  /**
   * Dibuixa el logo de l'Audi amb el text DAW i JS
   * @return {void}
   */

  function drawAudiLogo() {
    drawTextDaw();
    for (let i = 0; i < 4; i++) {
      ctx.restore();
      ctx.beginPath();
      ctx.strokeStyle = "#000447";
      ctx.lineWidth = 10;
      ctx.arc(startX, startY, 50, 0, 2 * Math.PI);
      ctx.stroke();
      startX += 70;
    }
    drawTextJs();
    startX = canvas.width / 2 - 105;
  }

  /**
   * Dibuixa el text DAW al primer cercle
   * @return {void}
   */
  function drawTextDaw() {
    let radius = 50;
    let text = "DAW";
    let textWidth = ctx.measureText(text).width;
    let charWidth = textWidth / text.length;

    //Angle total que ocupa el text
    let totalAngle = (2 * Math.PI * radius) / charWidth;
    //Angle que ocupa cada lletra
    let charAngle = totalAngle / text.length;

    //Per a que el text comenci a la part superior del cercle(90 graus) i no a la dreta
    //Seria lo mateix sumar 270 graus o 3 * Math.PI / 2
    //Li sumo el angle que ocupa cada lletra per a que quedi centrat
    let angle = -(Math.PI / 2 + charAngle / 2);
    ctx.save();
    ctx.font = "30px Arial";
    ctx.fillStyle = "#ffffff";
    ctx.textAlign = "center";

    for (let i = 0; i < text.length; i++) {
      let char = text[i];
      ctx.save();
      ctx.translate(
        startX + radius * Math.cos(angle),
        startY + radius * Math.sin(angle) - 10 //Es per fer un margin amb el cercle i que no estigui empegat
      );
      ctx.rotate(angle + Math.PI / 2);
      ctx.fillText(char, 0, 0);
      ctx.restore();
      angle += charAngle / 2;
    }

    ctx.restore();
  }

  /**
   * Dibuixa el text JS a l'ultim cercle
   * @return {void}
   */
  function drawTextJs() {
    //Posiciono el text al cercle de la dreta
    startX -= 70;
    let radius = 50;
    let text = "JS";
    let textWidth = ctx.measureText(text).width;
    let charWidth = textWidth / text.length;

    //Calculo els angles necessaris per poder fer les rotacions
    let totalAngle = (2 * Math.PI * radius) / charWidth;
    let charAngle = totalAngle / text.length - 0.5;

    let angle = Math.PI / 2 + charAngle / 4;
    ctx.save();
    ctx.font = "30px Arial";
    ctx.fillStyle = "#ffffff";
    ctx.textAlign = "center";

    //Dibuixo lletra a lletra i vaig canviant l'angle
    for (let i = 0; i < text.length; i++) {
      let char = text[i];
      ctx.save();
      ctx.translate(
        startX + radius * Math.cos(angle),
        startY + radius * Math.sin(angle) + 30 //Els 30px son per fer un margin amb el cercle
      );
      ctx.rotate(angle + (3 * Math.PI) / 2);
      ctx.fillText(char, 0, 0);
      ctx.restore();
      angle -= charAngle / 2;
    }

    ctx.restore();
  }

  /**
   * Dibuixa el frame final de l'animacio
   * @return {void}
   */
  function drawFinal() {
    //Fem el fons del rectangle semitransparent
    ctx.fillStyle = "rgba(255, 255, 255, 0.2)";
    let rectMarginHeight = 200;
    let rectMarginWidth = 100;

    ctx.fillRect(
      rectMarginWidth,
      canvas.height / 2 - rectMarginHeight / 2,
      canvas.width - 200,
      rectMarginHeight
    );

    //Ara fem el borde del rectangle
    ctx.strokeStyle = "#000447";
    ctx.lineWidth = 10;
    ctx.strokeRect(
      rectMarginWidth,
      canvas.height / 2 - rectMarginHeight / 2,
      canvas.width - 200,
      rectMarginHeight
    );

    //Dibuixem el text amb ombra
    ctx.save();
    ctx.font = "40px Arial";
    ctx.fillStyle = "#ffffff";
    ctx.strokeStyle = "black";

    //Redueixo el borde de la linia per a que quedi mes bonic i configuro el shadow
    ctx.lineWidth = 8;
    ctx.shadowBlur = 5;
    ctx.shadowColor = "black";

    //Les mesures no tenen cap calcul, estan fetes a l'ull
    ctx.strokeText("D A W", canvas.width - 240, canvas.height / 2 - 10);
    ctx.fillText("D A W", canvas.width - 240, canvas.height / 2 - 10);
    ctx.font = "20px Arial";
    ctx.strokeText(
      "m'agrada canvas",
      canvas.width - 260,
      canvas.height / 2 + 30
    );
    ctx.fillText("m'agrada canvas", canvas.width - 260, canvas.height / 2 + 30);
    ctx.restore();

    //Per ultim dibuixem el logo de Audi
    startX -= 75;
    drawAudiLogo();
  }

  /**
   * Reinicia les variables per poder tornar a fer l'animacio
   * @return {void}
   */
  function restartCanvas() {
    btnStartCanvas.disabled = false;
    blnStartCanvas = false;
    startX = canvas.width / 2 - 105;
    startY = -100;
  }

  /**
   * Event listeners
   */

  /**
   * Quan l'usuari clica el botó de start, deshabilitem el botó
   * per evitar que es pugui tornar a clicar
   *
   */
  btnStartCanvas.addEventListener("click", function () {
    console.log("start", { blnStartCanvas });
    btnStartCanvas.disabled = true;
    blnStartCanvas = true;
    window.requestAnimationFrame(drawCanvas);
    audioAnim.play();
  });

  //Iniciem el canvas quan carregui la pàgina
  drawCanvas();
});
