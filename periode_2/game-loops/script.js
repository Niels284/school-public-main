import { Komeet } from "./komeet.mjs"; // Komeet class importeren

$(document).ready(function () {
  // Na laden van pagina, code uitvoeren
  const canvas = document.querySelector("canvas");

  // pakt de gehele breedte en hoogte van het scherm
  canvas.width = innerWidth;
  canvas.height = innerHeight;

  const komeet1 = new Komeet(100, 100, 100, 100, 1); // x, y, width, height, fps (1 fps)
  const komeet2 = new Komeet(100, 300, 100, 100, 60); // x, y, width, height, fps (60 fps)

  // start de animatie van de kometen
  komeet1.animate();
  komeet2.animate();
});
