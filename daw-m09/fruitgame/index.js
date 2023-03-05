document.addEventListener("DOMContentLoaded", function () {
	/*
	* Parametres globals del joc
	* @param {object} btnStartCanvas - Botó per iniciar el joc
	* @param {boolean} blnStartCanvas - Variable per controlar si el joc s'ha iniciat
	* @param {object} canvas - Canvas del joc
	* @param {object} ctx - Context del canvas
	* @param {object} animId - Variable per controlar l'animació del canvas
	* @param {object} skyBg - Imatge de fons del canvas
	* @param {object} grassBg - Imatge de terra del canvas
	* @param {object} fruit - Imatge de la fruita
	* @param {number} speed - Velocitat de la fruita
	* @param {number} fruitX - Posició X de la fruita
	* @param {number} fruitY - Posició Y de la fruita
	* @param {number} score - Puntuació del joc
	* @param {number} lives - Vides del joc
	 */

	let btnStartCanvas = document.getElementById("canvasStart");
	let blnStartCanvas = false;
	let canvas = document.getElementById("fruityGame");
	let ctx = canvas.getContext("2d");
	let animId;
	let skyBg = new Image();
	skyBg.src = "./img/cloud.jpg";
	let grassBg = new Image();
	grassBg.src = "./img/grass.png";
	let fruit = new Image();
	let speed = 1;
	let fruitX = 0;
	let fruitY = 0;

	let score = 0;
	let lives = 7;

	/*
	* @function draw - Funció main que controlar el dibuix del canvas
	 */
	function draw() {
		if (lives > 0) {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			ctx.drawImage(skyBg, 0, 0, canvas.width, canvas.height);
			ctx.save();
			drawFruit();
			drawScore();
			ctx.drawImage(grassBg, 0, canvas.height - grassBg.height + 35, canvas.width, grassBg.height);
			ctx.restore();
			animId = window.requestAnimationFrame(draw);
		} else {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			ctx.drawImage(skyBg, 0, 0, canvas.width, canvas.height);
			ctx.drawImage(grassBg, 0, canvas.height - grassBg.height + 35, canvas.width, grassBg.height);
			ctx.save();
			drawGameOver();
			ctx.restore();
			window.cancelAnimationFrame(animId);
		}
	}

	function drawCanvasBg() {
		if (ctx) {
			ctx.save();
			//Dibuixem el fons del canvas
			skyBg.onload = function () {
				console.log("skyBg.onload");
				ctx.drawImage(skyBg, 0, 0, canvas.width, canvas.height);
				grassBg.onload = function () {
					console.log("grassBg.onload");
					ctx.drawImage(grassBg, 0, canvas.height - grassBg.height + 35, canvas.width, grassBg.height);
					ctx.restore();
				};
			};
		}
	}

	function drawFruit() {
		ctx.drawImage(fruit, fruitX, fruitY, fruit.width / 2, fruit.height / 2);
		//Si la fruita no ha tocat el terra incremento la fruitY, sino resetejo la fruitY i escolleixo una fruita nova
		if (fruitY < canvas.height - grassBg.height + 35) {
			fruitY += speed;
		} else {
			fruitY = 0;
			getNewFruit();
			lives--;
		}
	}

	//Funció per a obtenir una fruita aleatòria
	function getNewFruit() {
		//Escullo un número aleatori entre 1 i 10 per a escollir la imatge de la fruita
		let num = Math.floor(Math.random() * 10) + 1;
		fruit.src = `./img/fruit${num}.png`;
		//Calculo una posició aleatòria per a la fruita
		fruitX = Math.floor(Math.random() * (canvas.width - fruit.width));
	}

	function drawScore() {
		ctx.save();
		drawScoreBox();
		ctx.strokeStyle = "white";
		ctx.fillStyle = "white";
		ctx.font = "30px Calibri";
		ctx.fillStyle = "white";
		let txtScore = "SCORE";
		ctx.strokeText("SCORE", canvas.width - ctx.measureText(txtScore).width - 5, 25);
		drawLives();
	}

	function drawScoreBox() {
		ctx.save();
		ctx.fillStyle = "purple";
		ctx.fillRect(canvas.width - 110, 0, 125, 90);
		ctx.strokeStyle = "white";
		ctx.strokeRect(canvas.width - 110, 0, 125, 90);
		ctx.restore();
	}

	function drawLives() {
		let txtLives = "";
		for (let i = 0; i < lives; i++) {
			txtLives += "*";
		}

		ctx.fillText(txtLives, canvas.width - ctx.measureText(txtLives).width, 60);
		let txtScoreNum = score.toString();
		console.log(ctx.measureText(txtScoreNum));
		ctx.fillText(txtScoreNum, canvas.width - ctx.measureText(txtScoreNum).width - 5, 75);
		ctx.restore();
	}

	function drawGameOver() {
		ctx.font = "70px Calibri";
		ctx.strokeStyle = "red";
		ctx.shadowColor = "black";
		ctx.shadowBlur = 5;
		ctx.strokeText("GAME OVER", canvas.width / 2 - ctx.measureText("GAME OVER").width / 2, canvas.height / 2);
		ctx.font = "30px Calibri";
		ctx.fillStyle = "black";
		ctx.fillText("SCORE: " + score, canvas.width / 2 - ctx.measureText("SCORE: " + score).width / 2, canvas.height / 2 + 50);
		restartGame();
	}

	function restartGame() {
		blnStartCanvas = false;
		btnStartCanvas.disabled = false;
		score = 0;
		lives = 7;
		animId = null;
		fruitX = 0;
		fruitY = 0;
		speed = 1;
		getNewFruit();
	}

	btnStartCanvas.addEventListener("click", function () {
		console.log("btnStartCanvas.addEventListener");
		blnStartCanvas = true;
		btnStartCanvas.disabled = true;
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		//Si les imatges ja s'han carregat, dibuixo el canvas, sinó espero a que s'acabin de carregar
		if (skyBg.complete && grassBg.complete) {
			getNewFruit();
			animId = window.requestAnimationFrame(draw);
		}
	});

	canvas.addEventListener("click", function (e) {
		//Miro si el click ha caigut dins de la fruita i incremento el score i la velocitat, sino decremento les vides
		if (e.offsetX >= fruitX && e.offsetX <= fruitX + fruit.width / 2 && e.offsetY >= fruitY && e.offsetY <= fruitY + fruit.height / 2) {
			score += 10;
			fruitY = 0;
			speed += 0.1;
			getNewFruit();
		} else {
			lives--;
		}
	});

	//Funció per a dibuixar el canvas per primera vegada perquè no es vegi el canvas en blanc
	drawCanvasBg();
});