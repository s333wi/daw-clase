document.addEventListener("DOMContentLoaded", function () {
  let btnStartCanvas = document.getElementById("canvasStart");
  let blnStartCanvas = false;
  let canvas = document.getElementById("dawAudi");
  let ctx = canvas.getContext("2d");
  let animId;
  let startX = canvas.width / 2 - 105;
  let startY = -100;

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
      let audiFons = new Image();
      audiFons.src = "./audi-fons.png";
      audiFons.onload = function () {
        ctx.drawImage(audiFons, 0, 0, canvas.width, canvas.height);
        if (blnStartCanvas) {
          //Si el logo ha arribat al mig del canvas, parem l'animació
          if (startY > canvas.height / 2) {
            drawAudiLogo();
            startY += 1;
            animId = window.requestAnimationFrame(drawCanvas);
          } else {
            window.cancelAnimationFrame(animId);
            drawFinal();
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
    startX -= 70;
    let radius = 50;
    let text = "JS";
    let textWidth = ctx.measureText(text).width;
    let charWidth = textWidth / text.length;

    let totalAngle = (2 * Math.PI * radius) / charWidth;
    let charAngle = totalAngle / text.length;

    let angle = Math.PI / 2 + charAngle / 4;
    ctx.save();
    ctx.font = "30px Arial";
    ctx.fillStyle = "#ffffff";
    ctx.textAlign = "center";

    for (let i = 0; i < text.length; i++) {
      let char = text[i];
      ctx.save();
      ctx.translate(
        startX + radius * Math.cos(angle),
        startY + radius * Math.sin(angle) + 30
      );
      ctx.rotate(angle + (3 * Math.PI) / 2);
      ctx.fillText(char, 0, 0);
      ctx.restore();
      angle -= charAngle / 2;
    }

    ctx.restore();
  }

  function drawFinal() {
    // Set the rectangle fill color to white with alpha of 0.5
    ctx.fillStyle = "rgba(255, 255, 255, 0.2)";
    let rectTotalHeight = 200;
    let rectTotalWidth = 100;
    // Draw the rectangle in the center of the canvas
    ctx.fillRect(
      rectTotalWidth,
      canvas.height / 2 - rectTotalHeight / 2,
      canvas.width - 300,
      rectTotalHeight
    );

    // Draw a 10px border around the rectangle
    ctx.strokeStyle = "blue";
    ctx.lineWidth = 10;
    ctx.strokeRect(
      rectTotalWidth,
      canvas.height / 2 - rectTotalHeight / 2,
      canvas.width - 300,
      rectTotalHeight
    );
    startX -= 100;
    drawAudiLogo();
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
    btnStartCanvas.disabled = true;
    blnStartCanvas = true;
    window.requestAnimationFrame(drawCanvas);
  });

  //Iniciem el canvas quan carregui la pàgina
  drawCanvas();
});
