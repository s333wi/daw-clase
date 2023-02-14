export class Circle {
  constructor(xPos, yPos, radius, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.radius = radius;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.beginPath();
    ctx.arc(this.xPos, this.yPos, this.radius, 0, 2 * Math.PI);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
  }
}

export class Rectangle {
  constructor(xPos, yPos, width, height, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.width = width;
    this.height = height;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.beginPath();
    ctx.rect(this.xPos, this.yPos, this.width, this.height);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
  }
}

export class Line {
  constructor(xPos, yPos, xEnd, yEnd, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.xEnd = xEnd;
    this.yEnd = yEnd;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.beginPath();
    ctx.moveTo(this.xPos, this.yPos);
    ctx.lineTo(this.xEnd, this.yEnd);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
  }
}

export class Point {
  constructor(xPos, yPos, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.beginPath();
    ctx.arc(this.xPos, this.yPos, this.lineWidth / 2, 0, 2 * Math.PI);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
  }
}
