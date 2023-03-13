//grab the canvas from the DOM
var canvas = document.getElementById("myCanvas");

//Agafem el contexte 2D del canvas
var ctx = canvas.getContext("2d");
let startX = canvas.width / 2 - 105;
console.log(canvas.width);
if (ctx) {
  //Dibuixem una linea vertical en el centre del canvas
  ctx.beginPath();
  ctx.lineWidth = 1;
  ctx.setLineDash([10, 10]);
  ctx.strokeStyle = "red";
  ctx.moveTo(canvas.width / 2, 0);
  ctx.lineTo(canvas.width / 2, canvas.height);
  ctx.stroke();

  //Dibuixem una linea horitzontal en el centre del canvas
  ctx.lineWidth = 0;
  ctx.beginPath();
  ctx.moveTo(0, canvas.height / 2);
  ctx.lineTo(canvas.width, canvas.height / 2);
  ctx.stroke();

  //Dibuixem els 4 cercles
  for (let i = 0; i < 4; i++) {
    //Dibuixem una linea vertical en el centre de cada cercle
    ctx.beginPath();
    ctx.lineWidth = 1;
    ctx.setLineDash([10, 10]);
    ctx.strokeStyle = "red";
    ctx.moveTo(startX, 0);
    ctx.lineTo(startX, canvas.height);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.setLineDash([0, 0]);
    ctx.strokeStyle = "black";
    ctx.lineWidth = 10;
    ctx.arc(startX, 100, 50, 0, 2 * Math.PI);
    ctx.stroke();
    startX += 70;
  }
 
}
