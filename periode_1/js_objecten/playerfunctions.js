// ---------------------------------------------------
// De functions om de status van spelers aan te passen
// ---------------------------------------------------

/**
 * Function expression show
 * Laat status van alle players zien
 * @param players (een array van player-objecten)
 */
function show(players) {
  for (const player of players) {
    console.log(player);
  }
}

// ------------------------------------------------------------------------
// TODO: Werk hieronder de andere functies uit zoals ze zijn beschreven
// ------------------------------------------------------------------------

/**
 * Function expression removeLive (dus geen function declaration of arrow function)
 * Verlaagt het aantal levens in het player-object met 1
 * @param player (een player-object wordt als parameter doorgegeven)
 */
// Hier dus de function expression
const removeLive = function (player) {
  if (player && typeof player === "object") {
    player.lives--;
  }
};

/**
 * Function expression toggleMedikit (dus geen function declaration of arrow function)
 * Zet de property medikit in het player-object op false als deze true is, en op true als deze false is
 * @param player (een player-object wordt als parameter doorgegeven)
 */
// Hier dus de function expression
const toggleMedikit = function (player) {
  if (player.medikit === true && player && typeof player === "object") {
    player.medikit = false;
  }
};

/**
 * Function expression hasMedikit (dus geen function declaration of arrow function)
 * Geeft true terug als player een medikit heeft, anders false
 * @param player (een player-object wordt als parameter doorgegeven)
 * @returns {boolean}
 */
// Hier dus de function expression
const hasMedikit = function (player) {
  return player.medikit === true && player && typeof player === "object";
};
