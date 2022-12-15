//grab the canvas from the DOM
var canvas = document.getElementById("myCanvas");

//get the context of the canvas
var ctx = canvas.getContext("2d");
let startX = canvas.width / 2 - 105;
console.log(canvas.width);
if (ctx) {
     //Draw a line vertically in the middle of the canvas
  ctx.beginPath();
  ctx.lineWidth = 1;
  ctx.setLineDash([10, 10]);
  ctx.strokeStyle = "red";
  ctx.moveTo(canvas.width / 2, 0);
  ctx.lineTo(canvas.width / 2, canvas.height);
  ctx.stroke();

  //Draw a line horizontally in the middle of the canvas
  ctx.lineWidth = 0;
  ctx.beginPath();
  ctx.moveTo(0, canvas.height / 2);
  ctx.lineTo(canvas.width, canvas.height / 2);
  ctx.stroke();

  //Draw 4 circles in a line concatenated and overlap with some space between like the audi logo
  for (let i = 0; i < 4; i++) {
    //Draw a vertical line in the middle of the circle
    ctx.beginPath();
    ctx.lineWidth = 1;
    ctx.setLineDash([10, 10]);
    ctx.strokeStyle = "red";
    ctx.moveTo(startX, 50);
    ctx.lineTo(startX, 150);
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
