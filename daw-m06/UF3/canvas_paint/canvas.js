import { Circle } from "./figures.js";
import { Rectangle } from "./figures.js";

window.onload = function () {
  let canvasElement = new PhotoDaw("canvasContainer", true);
};

/**
 * @class PhotoDaw
 * @description Classe que permet crear un canvas amb les funcionalitats de dibuixar punts, línies, rectangles i cercles
 * @property {string} idContainer - id del div on es crearà el canvas
 * @property {boolean} showCoords - indica si es mostren les coordenades del ratolí al canvas
 * @property {HTMLElement} idContainer - element HTML on es crearà el canvas
 * @property {string} currentColor - color actual del dibuix
 */

class PhotoDaw {
  //Atributs de la classe
  idContainer = "";
  showCoords = false;
  container = null;
  currentColor = "#000000";
  currentWidth = 5;
  canvas = null;
  ctx = null;
  figures = [];

  /**
   * @constructor PhotoDaw
   * @description Constructor de la classe PhotoDaw
   * @param {string} idContainer - id del div on es crearà el canvas
   * @param {boolean} showCoords - indica si es mostren les coordenades del ratolí al canvas
   * @return {PhotoDaw} - retorna un objecte de la classe PhotoDaw
   *
   * @example
   * let canvasElement = new PhotoDaw("canvasContainer");
   * @example
   * let canvasElement = new PhotoDaw("canvasContainer", true);
   */
  constructor(idContainer, showCoords = false) {
    //Inicialitzo els atributs de la classe
    this.idContainer = idContainer;
    this.showCoords = showCoords;
    this.container = document.getElementById(idContainer);

    //Creo el canvas i els botons per crear les figures geomètriques
    this.createCanvas();
    this.createOptions();
  }

  createCanvas() {
    //Creo el canvas i el seu context
    this.canvas = document.createElement("canvas");
    this.ctx = this.canvas.getContext("2d");

    //Afegeixo els atributs necessaris al canvas i el penjo al DOM
    this.canvas.width = "800";
    this.canvas.height = "400";
    this.canvas.style.border = "1px solid black";
    this.canvas.id = "canvasPaint";
    this.ctx.fillStyle = "black";
    if (this.showCoords) {
      this.canvas.addEventListener(
        "mousemove",
        (e) => {
          this.drawCoords(e);
        },
        false
      );
    }
    this.container.appendChild(this.canvas);
  }
  drawCoords(e) {
    let mousePos = this.getMousePos(this.canvas, e);
    let message = "[" + mousePos.x + "," + mousePos.y + "]";
    this.writeMessage(this.ctx, message);
  }

  writeMessage(context, message) {
    //Clear the canvas where the text is going to be written
    let widthText = context.measureText(message).width;
    context.clearRect(
      context.canvas.width - widthText - 15,
      context.canvas.height - 30,
      widthText + 15,
      30
    );
    context.font = "18pt Calibri";
    context.fillStyle = "black";

    context.fillText(
      message,
      context.canvas.width - widthText - 10,
      context.canvas.height - 10
    );
  }

  getMousePos(canvas, evt) {
    let rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top,
    };
  }

  /**
   * @method createOptions
   * @description Crea els botons per dibuixar punts, línies, rectangles,cercles, netejar el canvas
   * i els inputs per canviar el color i l'amplada de la línia
   * @return {void}
   */
  createOptions() {
    //Creo els div containers per els botons i els inputs
    let optionsContainer = document.createElement("div");
    let btnContainer = document.createElement("div");
    optionsContainer.id = "optionsContainer";
    optionsContainer.classList.add("btn-toolbar", "mb-3", "align-items-center");
    btnContainer.id = "btnContainer";
    btnContainer.classList.add("btn-group", "me-2");
    btnContainer.setAttribute("role", "group");

    //Afegeixo els divs al DOM
    optionsContainer.appendChild(btnContainer);
    this.container.appendChild(optionsContainer);

    //Creo els botons i els inputs, els botons els penjo al div btnContainer i els inputs al div optionsContainer
    this.createPointBtn(btnContainer);
    this.createLineBtn(btnContainer);
    this.createRectangleBtn(btnContainer);
    this.createCircleBtn(btnContainer);
    this.createClearBtn(btnContainer);
    this.createColorPicker(optionsContainer);
    this.createWidthLineRange(optionsContainer);
    this.createWidthLineSpan(optionsContainer);
  }

  /**
   * Funcions per crear els botons
   * @param {HTMLElement} container - element HTML on es crearà el botó
   * @return {void}
   */
  createPointBtn(container) {
    let pointBtn = document.createElement("button");
    pointBtn.innerHTML = "Punt";
    pointBtn.id = "point";
    pointBtn.classList.add("btn", "btn-primary");
    pointBtn.value = "point";
    pointBtn.addEventListener("click", (e) => {
      this.canvas.addEventListener(
        "click",
        (e) => {
          let mousePos = this.getMousePos(this.canvas, e);
          let point = new Point();
        },
        false
      );
    });
    container.appendChild(pointBtn);
  }

  createLineBtn(container) {
    let lineBtn = document.createElement("button");
    lineBtn.innerHTML = "Línia";
    lineBtn.id = "line";
    lineBtn.classList.add("btn", "btn-success");
    lineBtn.value = "line";
    container.appendChild(lineBtn);
  }

  createRectangleBtn(container) {
    let rectangleBtn = document.createElement("button");
    rectangleBtn.innerHTML = "Rectangle";
    rectangleBtn.id = "rectangle";
    rectangleBtn.classList.add("btn", "btn-info");
    rectangleBtn.value = "rectangle";
    rectangleBtn.addEventListener("click", (e) => {});
    container.appendChild(rectangleBtn);
  }

  createCircleBtn(container) {
    let circleBtn = document.createElement("button");
    circleBtn.innerHTML = "Cercle";
    circleBtn.id = "circle";
    circleBtn.classList.add("btn", "btn-warning");
    circleBtn.value = "circle";
    container.appendChild(circleBtn);

    circleBtn.addEventListener("click", (e) => {
      let circle = new Circle(
        100,
        50,
        20,
        this.currentColor,
        this.currentWidth
      );
      circle.draw(this.ctx);
    });
  }

  createClearBtn(container) {
    let clearBtn = document.createElement("button");
    clearBtn.innerHTML = "Netejar";
    clearBtn.id = "clear";
    clearBtn.classList.add("btn", "btn-danger");
    clearBtn.value = "clear";
    clearBtn.addEventListener("click", (e) => {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.drawCoords(e);
    });

    container.appendChild(clearBtn);
  }

  createWidthLineRange(container) {
    let widthLineRange = document.createElement("input");
    widthLineRange.type = "range";
    widthLineRange.id = "widthLineRange";
    widthLineRange.classList.add("me-2", "ms-2");
    widthLineRange.min = "1";
    widthLineRange.max = "50";
    widthLineRange.value = "5";
    widthLineRange.step = "1";

    widthLineRange.addEventListener("change", (e) => {
      let widthLine = document.getElementById("widthLine");
      widthLine.innerHTML = `Gruix: ${widthLineRange.value}px`;
      this.currentWidth = widthLineRange.value;
    });
    container.appendChild(widthLineRange);
  }

  createColorPicker(container) {
    let colorPicker = document.createElement("input");
    colorPicker.type = "color";
    colorPicker.id = "colorPicker";
    colorPicker.classList.add(
      "form-control",
      "form-control-color",
      "me-2",
      "ms-2"
    );
    colorPicker.value = "#000000";
    colorPicker.addEventListener("change", (e) => {
      this.currentColor = colorPicker.value;
    });
    container.appendChild(colorPicker);
  }

  createWidthLineSpan(container) {
    let widthLineRange = document.getElementById("widthLineRange");
    let widthLineSpan = document.createElement("span");
    widthLineSpan.id = "widthLine";
    widthLineSpan.innerHTML = `Gruix: ${widthLineRange.value}px`;
    container.appendChild(widthLineSpan);
  }
}
