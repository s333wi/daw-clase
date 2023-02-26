import { Point, Circle, Line, Rectangle, Triangle } from "./figures.js";

window.onload = function () {
  //Objecte de figures que encapsula les instancies de les figures geomètriques
  let figures = {};
  figures.point = class {
    constructor() {
      this.object = new Point();
    }
  };
  figures.circle = class {
    constructor() {
      this.object = new Circle();
    }
  };

  figures.line = class {
    constructor() {
      this.object = new Line();
    }
  };

  figures.rectangle = class {
    constructor() {
      this.object = new Rectangle();
    }
  };

  figures.triangle = class {
    constructor() {
      this.object = new Triangle();
    }
  };

  let canvasElement = new PhotoDaw("canvasContainer", figures, true);
};

/**
 * @class PhotoDaw
 * @description Classe que permet crear un canvas amb les funcionalitats de dibuixar punts, línies, rectangles i cercles
 *
 * @property {string} idContainer - id del div on es crearà el canvas
 * @property {boolean} showCoords - indica si es mostren les coordenades del ratolí al canvas
 * @property {Object} container - objecte del div on es crearà el canvas
 * @property {string} currentColor - color actual de la figura
 * @property {number} currentWidth - amplada de la línia de la figura
 * @property {string} currentFigure - figura actual que es dibuixarà
 * @property {Object} currentFigureObject - objecte de la figura actual que es dibuixarà
 * @property {Object} canvas - objecte del canvas
 * @property {Object} ctx - objecte context del canvas
 * @property {Array} arrSavedFigures - array amb les figures dibuixades
 * @property {Object} objFigures - objecte amb les figures geomètriques que es poden dibuixar
 * @property {boolean} startDraw - indica si s'ha iniciat el dibuix de la
 *
 */

class PhotoDaw {
  idContainer = "";
  showCoords = false;
  container = null;
  currentColor = "#000000";
  currentWidth = 5;
  currentFigure = "Point";
  currentFigureObject = null;
  canvas = null;
  ctx = null;
  arrSavedFigures = [];
  objFigures;
  startDraw = false;

  /**
   * @constructor PhotoDaw
   * @description Constructor de la classe PhotoDaw
   * @param {string} idContainer - id del div on es crearà el canvas
   * @param {Object} figures - objecte amb les figures geomètriques que es poden dibuixar
   * @param {boolean} showCoords - indica si es mostren les coordenades del ratolí al canvas
   * @return {PhotoDaw} - retorna un objecte de la classe PhotoDaw
   *
   * @example
   * let canvasElement = new PhotoDaw("canvasContainer",figures);
   * @example
   * let canvasElement = new PhotoDaw("canvasContainer",figures,true);
   */
  constructor(idContainer, figures, showCoords = false) {
    //Inicialitzo els atributs de la classe
    this.idContainer = idContainer;
    this.showCoords = showCoords;
    this.container = document.getElementById(idContainer);
    this.objFigures = figures;
    //Creo el canvas i els botons per crear les figures geomètriques
    this.createCanvas();
    this.createOptions();
    this.drawAllFigures = this.drawAllFigures.bind(this);
  }

  /**
   * @method drawAllFigures
   * @description Metode que permet dibuixar totes les figures que hi ha a l'array arrSavedFigures.
   * He de fer figure.object al bucle perque guardo l'instancia de la classe en l'atribut object.
   * Aixo ho torno a fer als metodes @method startDrawing, @method drawing i @method endDrawing
   */
  drawAllFigures() {
    if (this.startDraw) {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.arrSavedFigures.forEach((figure) => {
        figure.object.draw(this.ctx);
      });
    }
  }

  /**
   * @method createCanvas
   * @description Metode que permet crear el canvas i els events listeners corresponents
   * @return {void}
   */
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
      this.drawCoords = this.drawCoords.bind(this);
      this.canvas.addEventListener("mousemove", this.drawCoords, false);
    }

    //Canvio el contexte del this per a que sigui el mateix que del objecte @class PhotoDaw
    this.startDrawing = this.startDrawing.bind(this);
    this.drawing = this.drawing.bind(this);
    this.endDrawing = this.endDrawing.bind(this);

    //Afegeixo els events listeners al canvas
    this.canvas.addEventListener("mousedown", this.startDrawing, false);
    this.canvas.addEventListener("mousemove", this.drawing, false);
    this.canvas.addEventListener("mouseup", this.endDrawing, false);
    this.canvas.addEventListener("mouseout", this.endDrawing, false);
    this.container.appendChild(this.canvas);
  }

  /**
   * @method drawCoords
   * @description Metode que permet mostrar les coordenades del ratolí al canvas
   *
   * @return {void}
   */
  drawCoords() {
    let mousePos = this.getMousePos(this.canvas, window.event);
    let message = "[" + mousePos.x + "," + mousePos.y + "]";
    this.writeMessage(this.ctx, message);
  }

  /**
   * @method getMousePos
   * @description Metode que permet obtenir les coordenades del ratolí
   * @param {Object} canvas - objecte del canvas
   *
   * @return {Object} - retorna un objecte amb les coordenades del ratolí
   */
  getMousePos(canvas) {
    let evt = window.event;
    let rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top,
    };
  }

  /**
   * @method writeMessage
   * @description Metode que permet escriure un missatge al canvas, en aquest cas nomes les coordenades del ratolí
   * @param {Object} context - objecte context del canvas
   * @param {string} message - missatge que es vol escriure al canvas
   *
   * @return {void}
   */
  writeMessage(context, message) {
    //El valor del width esta hardcodejat perque quan les coordenades tenen menos de 3 digits,
    // no es borren del tot el valor anterior. Avans utilitzava el mesureText per a saber el width del text.
    let widthText = 95;
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

  /**
   * @method startDrawing
   * @description Metode que permet iniciar el dibuix, es crida quan es prem el botó del ratolí.
   *
   * @return {void}
   */
  startDrawing() {
    this.startDraw = true;
    //Creo una nova instancia de la classe que estigui utilitzant l'usuari, un objecte en JS el puc accedir amb [] tambe.
    //Com el currentFigure es un string, el puc utilitzar per a accedir a l'objecte de la classe que vull utilitzar.
    this.currentFigureObject = new this.objFigures[
      this.currentFigure.toLowerCase()
    ]();

    let mousePos = this.getMousePos(this.canvas);
    this.currentFigureObject.object.xPos = mousePos.x;
    this.currentFigureObject.object.yPos = mousePos.y;
    this.currentFigureObject.object.color = this.currentColor;
    this.currentFigureObject.object.lineWidth = this.currentWidth;
  }

  /**
   * @method drawing
   * @description Metode que permet dibuixar mentre es prem el botó del ratolí. Es veura el preview de la figura.
   * Utilitzo el metode @method drawPreview de la classe que estigui utilitzant en aquell moment l'usuari.
   *
   * @return {void}
   */
  drawing() {
    if (this.startDraw) {
      let mousePos = this.getMousePos(this.canvas);
      this.currentFigureObject.object.xEnd = mousePos.x;
      this.currentFigureObject.object.yEnd = mousePos.y;

      this.drawAllFigures();
      this.currentFigureObject.object.drawPreview(this.ctx);
      this.drawCoords(this.canvas);
    }
  }

  /**
   * @method endDrawing
   * @description Metode que permet finalitzar el dibuix, es crida quan es deixa de premre el botó del ratolí.
   * Es guarda la figura en un array i es dibuixa tot el canvas.
   *
   * @return {void}
   */
  endDrawing() {
    if (this.startDraw) {
      let mousePos = this.getMousePos(this.canvas);

      this.currentFigureObject.object.xEnd = mousePos.x;
      this.currentFigureObject.object.yEnd = mousePos.y;

      this.arrSavedFigures.push(this.currentFigureObject);
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

    circleBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });

    container.appendChild(circleBtn);
  }

  createTriangleBtn(container) {
    let triangleBtn = document.createElement("button");
    triangleBtn.innerHTML = "Triangle";
    triangleBtn.id = "triangle";
    triangleBtn.classList.add("btn", "btn-secondary");
    triangleBtn.value = "Triangle";

    triangleBtn.addEventListener("click", (e) => {
      this.currentFigure = e.target.value;
    });

    container.appendChild(triangleBtn);
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

  createClearBtn(container) {
    let clearBtn = document.createElement("button");
    clearBtn.innerHTML = "Netejar";
    clearBtn.id = "clear";
    clearBtn.classList.add("btn", "btn-danger");
    clearBtn.value = "clear";

    clearBtn.addEventListener("click", (e) => {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.drawCoords(e);
      this.arrSavedFigures = [];
    });

    container.appendChild(clearBtn);
  }

  createWidthLineRange(container) {
    let widthLineRange = document.createElement("input");
    widthLineRange.type = "range";
    widthLineRange.id = "widthLineRange";
    widthLineRange.classList.add("me-2", "ms-2");
    widthLineRange.min = "1";
    widthLineRange.max = "25";
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
