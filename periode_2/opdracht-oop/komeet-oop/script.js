// functie wat een random getal teruggeeft tussen min en max
const randomInt = (min, max) => Math.floor(Math.random() * max) + min;

// generen van een komeet met random values
function generateKomeet() {
  const komeet = Object.create(komeetPrototype);
  komeet.diameter = randomInt(10, 200);
  komeet.snelheid = randomInt(10, 200);
  komeet.x = randomInt(0, 400);
  komeet.y = randomInt(0, 400);
  komeet.vector = [randomInt(10, 90), randomInt(10, 90)];
  return komeet;
}

// class
const komeetPrototype = {
  writeOnCanvas: function (context) {
    context.beginPath();
    context.arc(this.x, this.y, this.diameter / 2, 0, 2 * Math.PI);
    context.fillStyle = "brown";
    context.fill();
    context.stroke();
  },
};

// Haal het canvas op en de context voor tekenen
const canvas = document.getElementById("kometenCanvas");
const context = canvas.getContext("2d");

// Aanmaken van kometen
const komeet1 = generateKomeet();
const komeet2 = generateKomeet();

console.log(komeet1);

// Teken de kometen op het canvas
komeet1.writeOnCanvas(context);
komeet2.writeOnCanvas(context);
