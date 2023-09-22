// ------------------------------------------------------
// Het game-object om de status van de game in op te slaan
// ------------------------------------------------------

// ------------------------------------------------------------------------------------------------------------------------------
// TODO: Vul het game-object hieronder aan met de property 'players' en geef deze als value een array met de  speler-objecten
// ------------------------------------------------------------------------------------------------------------------------------

const game = {
  // Hier aanvullen
  players: [
    {
      name: "Jean-Pierre",
      lives: 3,
      medikit: false
    },
    {
      name: "Ely van Weert",
      lives: 2,
      medikit: true
    }
  ]
};

// Main
console.log("Alle spelers:");
show(game.players);

console.log("Speler 2 verliest een leven:");
removeLive(game.players[1]);
show(game.players);

console.log("Speler1 vindt een medikit:");
toggleMedikit(game.players[0]);
show(game.players);

console.log(
  "Heeft speler 1 een medikit?",
  hasMedikit(game.players[0]) ? "Ja" : "Nee"
);
console.log(
  "Heeft speler 2 een medikit?",
  hasMedikit(game.players[1]) ? "Ja" : "Nee"
);
