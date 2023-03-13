export class Point {
  constructor(xPos, yPos, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.arc(this.xPos, this.yPos, this.lineWidth / 2, 0, 2 * Math.PI);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.stroke();
    ctx.restore();
  }

  drawPreview(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.arc(this.xPos, this.yPos, this.lineWidth / 2, 0, 2 * Math.PI);
    ctx.globalAlpha = 0.5;
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    ctx.restore();
  }
}

export class Circle {
  radius = 0;
  constructor(xPos, yPos, xEnd, yEnd, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.xEnd = xEnd;
    this.yEnd = yEnd;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.save();
    this.radius = Math.sqrt(
      Math.pow(this.xEnd - this.xPos, 2) + Math.pow(this.yEnd - this.yPos, 2)
    );
    ctx.beginPath();
    ctx.arc(this.xPos, this.yPos, this.radius, 0, 2 * Math.PI);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.stroke();
    ctx.restore();
  }

  drawPreview(ctx) {
    this.radius = Math.sqrt(
      Math.pow(this.xEnd - this.xPos, 2) + Math.pow(this.yEnd - this.yPos, 2)
    );
    ctx.save();
    ctx.beginPath();
    ctx.setLineDash([10, 5]);
    ctx.arc(this.xPos, this.yPos, this.radius, 0, 2 * Math.PI);
    ctx.globalAlpha = 0.5;
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    ctx.restore();
  }
}

export class Rectangle {
  constructor(xPos, yPos, xEnd, yEnd, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.xEnd = xEnd;
    this.yEnd = yEnd;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.rect(
      this.xPos,
      this.yPos,
      this.xEnd - this.xPos,
      this.yEnd - this.yPos
    );
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.stroke();
    ctx.restore();
  }

  drawPreview(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.setLineDash([10, 5]);
    ctx.rect(
      this.xPos,
      this.yPos,
      this.xEnd - this.xPos,
      this.yEnd - this.yPos
    );
    ctx.globalAlpha = 0.5;
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    ctx.restore();
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
    ctx.save();
    ctx.beginPath();
    ctx.moveTo(this.xPos, this.yPos);
    ctx.lineTo(this.xEnd, this.yEnd);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.stroke();
    ctx.restore();
  }

  drawPreview(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.setLineDash([10, 5]);
    ctx.moveTo(this.xPos, this.yPos);
    ctx.lineTo(this.xEnd, this.yEnd);
    ctx.globalAlpha = 0.5;
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    ctx.restore();
  }
}

export class Triangle {
  constructor(xPos, yPos, xEnd, yEnd, color, lineWidth) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.xEnd = xEnd;
    this.yEnd = yEnd;
    this.color = color;
    this.lineWidth = lineWidth;
  }

  draw(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.moveTo(this.xPos, this.yPos);
    ctx.lineTo(this.xEnd, this.yEnd);
    ctx.lineTo(this.xPos, this.yEnd);
    ctx.lineTo(this.xPos, this.yPos);
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.stroke();
    ctx.restore();
  }

  drawPreview(ctx) {
    ctx.save();
    ctx.beginPath();
    ctx.setLineDash([10, 5]);
    ctx.moveTo(this.xPos, this.yPos);
    ctx.lineTo(this.xEnd, this.yEnd);
    ctx.lineTo(this.xPos, this.yEnd);
    ctx.lineTo(this.xPos, this.yPos);
    ctx.globalAlpha = 0.5;
    ctx.strokeStyle = this.color;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    ctx.restore();
  }
}
