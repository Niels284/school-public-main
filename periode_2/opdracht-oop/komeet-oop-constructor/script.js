class Komeet {
  constructor() {
    // generen van een komeet met random values
    this.diameter = randomInt(10, 200);
    this.snelheid = randomInt(10, 200);
    this.x = randomInt(0, 400);
    this.y = randomInt(0, 400);
    this.vector = [randomInt(10, 90), randomInt(10, 90)];
  }

  writeOnCanvas(context) {
    context.beginPath();
    context.arc(this.x, this.y, this.diameter / 2, 0, 2 * Math.PI);
    context.fillStyle = "brown";
    context.fill();
    context.stroke();
  }
}

// functie wat een random getal teruggeeft tussen min en max
const randomInt = (min, max) => Math.floor(Math.random() * max) + min;

// Haal het canvas op en de context voor tekenen
const canvas = document.getElementById("kometenCanvas");
const context = canvas.getContext("2d");

// Aanmaken van kometen
const komeet1 = new Komeet();
const komeet2 = new Komeet();
console.log(komeet1);

// Teken de kometen op het canvas
komeet1.writeOnCanvas(context);
komeet2.writeOnCanvas(context);
