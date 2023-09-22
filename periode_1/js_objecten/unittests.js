// ------------------------------------------------------
// Unit tests (niet veranderen, deze geven aan of je code correct is of niet in het console venster)
// Er wordt gebruik gemaakt van de Chai-library
// ------------------------------------------------------

// Unit tests voor game.js
const should = chai.should();
let expected;
let actual;

// Controleer of de functies bestaan
game.should.be.a('object');

// Object game zou een property players moeten hebben met een array
chai.expect(expected).to.equal(actual);
chai.expect(game).to.have.property('players').that.is.a('array');

// Prop players zou twee spelers moeten hebben
chai.expect(game.players).to.have.lengthOf(2);


// Unit tests voor playerfunctions.js
// Controleer of de functies bestaan
removeLive.should.be.a('function');
toggleMedikit.should.be.a('function');
hasMedikit.should.be.a('function');

// Function removeLive zou 1 leven van player1 af moeten halen
expected = player1.lives - 1;
removeLive(player1);
actual = player1.lives;
chai.expect(expected).to.equal(actual);

// Function toggleMedikit zou de medikit van player2 op false moeten zetten als true en anders om
expected = !player2.medikit;
toggleMedikit(player2);
actual = player2.medikit;
chai.expect(expected).to.equal(actual);

// Function hasMedikit zou de status van de medikit van player2 moeten geven
expected = player2.medikit;
actual = hasMedikit(player2);
chai.expect(expected).to.equal(actual);

