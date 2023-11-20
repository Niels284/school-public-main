export class Komeet {
  // export class Komeet
  constructor(x, y, width, height, fps) {
    // aanmaken van object
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
    this.fps = fps;
    this.c = canvas.getContext("2d");
    this.c.fillRect(this.x, this.y, this.width, this.height);
  }

  moveRight = () => {
    // tekenen van object (updaten)
    this.x++;
    this.c.fillRect(this.x, this.y, this.width, this.height);
  };

  animate = () => {
    // berekenen van object (renderen)
    this.then = Date.now();
    this.interval = 1000;
    const render = () => {
      this.now = Date.now();
      this.difference = this.now - this.then;
      if (this.difference > this.interval / this.fps) {
        this.moveRight();
        this.then = this.now;
      }
      requestAnimationFrame(render);
    };
    render();
  };
}
