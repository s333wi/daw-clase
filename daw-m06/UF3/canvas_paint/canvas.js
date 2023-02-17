import { Point, Circle, Line, Rectangle, Pencil, Triangle } from "./figures.js";

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
  currentFigure = "Point";
  currentFigureObject = null;
  canvas = null;
  ctx = null;
  figures = [];
  startDraw = false;

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
    this.drawAllFigures = this.drawAllFigures.bind(this);
  }

  drawAllFigures() {
    if (this.startDraw) {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.figures.forEach((figure) => {
        figure.draw(this.ctx);
      });
    }
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

    this.startDrawing = this.startDrawing.bind(this);
    this.drawing = this.drawing.bind(this);
    this.endDrawing = this.endDrawing.bind(this);

    this.canvas.addEventListener("mousedown", this.startDrawing, false);
    this.canvas.addEventListener("mousemove", this.drawing, false);
    this.canvas.addEventListener("mouseup", this.endDrawing, false);
    this.canvas.addEventListener("mouseout", this.endDrawing, false);
    this.container.appendChild(this.canvas);
  }

  drawCoords(e) {
    let mousePos = this.getMousePos(this.canvas, e);
    let message = "[" + mousePos.x + "," + mousePos.y + "]";
    this.writeMessage(this.ctx, message);
  }

  //TODO: Mirar per que al tocar el borde les figures no es pinten
  getMousePos(canvas, evt) {
    let rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top,
    };
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

  startDrawing(e) {
    this.startDraw = true;
    switch (this.currentFigure) {
      case "Point":
        this.currentFigureObject = new Point();
        break;
      case "Line":
        this.currentFigureObject = new Line();
        break;
      case "Rectangle":
        this.currentFigureObject = new Rectangle();
        break;
      case "Circle":
        this.currentFigureObject = new Circle();
        break;
      case "Triangle":
        this.currentFigureObject = new Triangle();
        break;
      case "Pencil":
        this.currentFigureObject = new Pencil();
        break;
      case "Polygon":
        this.currentFigureObject = new Polygon();
        break;
      default:
        break;
    }

    let mousePos = this.getMousePos(this.canvas, e);
    this.currentFigureObject.xPos = mousePos.x;
    this.currentFigureObject.yPos = mousePos.y;
    this.currentFigureObject.color = this.currentColor;
    this.currentFigureObject.lineWidth = this.currentWidth;
  }

  drawing(e) {
    if (this.startDraw) {
      let mousePos = this.getMousePos(this.canvas, e);
      this.currentFigureObject.xEnd = mousePos.x;
      this.currentFigureObject.yEnd = mousePos.y;
      
      this.drawAllFigures();
      this.currentFigureObject.drawPreview(this.ctx);
      this.drawCoords(this.canvas, e);
    }
  }

  endDrawing(e) {
    if (this.startDraw) {
      let mousePos = this.getMousePos(this.canvas, e);

      this.currentFigureObject.xEnd = mousePos.x;
      this.currentFigureObject.yEnd = mousePos.y;

      this.figures.push(this.currentFigureObject);
      this.drawAllFigures();
      this.startDraw = false;
    }
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
    this.createTriangleBtn(btnContainer);
    this.createPencilBtn(btnContainer);
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
    pointBtn.value = "Point";
    pointBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
    container.appendChild(pointBtn);
  }

  createLineBtn(container) {
    let lineBtn = document.createElement("button");
    lineBtn.innerHTML = "Línia";
    lineBtn.id = "line";
    lineBtn.classList.add("btn", "btn-success");
    lineBtn.value = "Line";
    lineBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
    container.appendChild(lineBtn);
  }

  createRectangleBtn(container) {
    let rectangleBtn = document.createElement("button");
    rectangleBtn.innerHTML = "Rectangle";
    rectangleBtn.id = "rectangle";
    rectangleBtn.classList.add("btn", "btn-info");
    rectangleBtn.value = "Rectangle";
    rectangleBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
    container.appendChild(rectangleBtn);
  }

  createCircleBtn(container) {
    let circleBtn = document.createElement("button");
    circleBtn.innerHTML = "Cercle";
    circleBtn.id = "circle";
    circleBtn.classList.add("btn", "btn-warning");
    circleBtn.value = "Circle";
    container.appendChild(circleBtn);

    circleBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
  }

  createTriangleBtn(container) {
    let triangleBtn = document.createElement("button");
    triangleBtn.innerHTML = "Triangle";
    triangleBtn.id = "triangle";
    triangleBtn.classList.add("btn", "btn-secondary");
    triangleBtn.value = "Triangle";
    container.appendChild(triangleBtn);

    triangleBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
  }

  createPencilBtn(container) {
    let pencilBtn = document.createElement("button");
    pencilBtn.innerHTML = "Llapis";
    pencilBtn.id = "pencil";
    pencilBtn.classList.add("btn", "btn-dark");
    pencilBtn.value = "Pencil";
    pencilBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
    container.appendChild(pencilBtn);
  }

  createPolygonBtn(container) {
    let polygonBtn = document.createElement("button");
    polygonBtn.innerHTML = "Polígon";
    polygonBtn.id = "polygon";
    polygonBtn.classList.add("btn", "btn-dark");
    polygonBtn.value = "Polygon";
    polygonBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });
    container.appendChild(polygonBtn);
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
      this.figures = [];
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
      this.currentWidth = parseInt(widthLineRange.value);
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
