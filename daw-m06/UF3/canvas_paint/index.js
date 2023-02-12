window.onload = function () {
  let canvasElement = new PhotoDaw("canvasContainer");
};

/**
 * @class PhotoDaw
 * @description Classe que permet crear un canvas amb les funcionalitats de dibuixar punts, línies, rectangles i cercles
 * @property {string} idContainer - id del div on es crearà el canvas
 * @property {boolean} showCoords - indica si es mostren les coordenades del ratolí al canvas
 * @property {HTMLElement} idContainer - element HTML on es crearà el canvas
 * @property {string} currentColor - color actual del dibuix
 */

//create a class photodaw with a constructor that gets the id of the container where the canvas will be created and a boolean
//that indicates if the canvas is editable or not
class PhotoDaw {
  //Atributs de la classe
  idContainer = "";
  showCoords = false;
  container = null;
  currentColor = "#000000";
  canvas = null;
  ctx = null;

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
    this.container.appendChild(this.canvas);
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
    container.appendChild(rectangleBtn);
  }

  createCircleBtn(container) {
    let circleBtn = document.createElement("button");
    circleBtn.innerHTML = "Cercle";
    circleBtn.id = "circle";
    circleBtn.classList.add("btn", "btn-warning");
    circleBtn.value = "circle";
    container.appendChild(circleBtn);
  }

  createClearBtn(container) {
    let clearBtn = document.createElement("button");
    clearBtn.innerHTML = "Netejar";
    clearBtn.id = "clear";
    clearBtn.classList.add("btn", "btn-danger");
    clearBtn.value = "clear";
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
