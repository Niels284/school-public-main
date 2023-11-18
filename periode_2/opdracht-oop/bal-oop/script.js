class Bal {
  constructor() {
    // Maakt een nieuwe bal aan met random waardes
    this.doorsnee = randomInt(10, 100);
    this.x = randomInt(0, 200);
    this.y = randomInt(0, 200);
  }

  draw() {
    // Tekent de bal op het scherm
    const svgContainer = document.getElementById("balCanvas");
    const balElement = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "circle"
    );
    balElement.setAttribute("cx", this.x);
    balElement.setAttribute("cy", this.y);
    balElement.setAttribute("r", this.doorsnee / 2);
    balElement.setAttribute("fill", "brown"); // Kleur van de bal
    svgContainer.appendChild(balElement);
  }
}

// functie wat een random getal teruggeeft tussen min en max
const randomInt = (min, max) => Math.floor(Math.random() * max) + min;

// Maakt een nieuwe bal aan
const b1 = new Bal();

// Teken de bal op het scherm doormiddel van de draw() functie
b1.draw();
