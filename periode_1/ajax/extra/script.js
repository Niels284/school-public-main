$(document).ready(function () {
  $("#postcode").on("keyup", getResponse);
  $("#huisnummer").on("keyup", getResponse);

  async function getResponse() {
    if (
      $("#postcode").val().length >= 1 &&
      $("#huisnummer").val().length >= 1
    ) {
      $.ajax({
        method: "POST",
        url: "./ajax.php",
        data: {
          zipcode: $("#postcode").val(),
          housenumber: $("#huisnummer").val(),
        },
        success: function (response) {
          $("#adres").val(response.address);
          $("#plaats").val(response.city);
        },
      });
    } else {
      $("#adres").val("");
      $("#plaats").val("");
    }
  }
});
