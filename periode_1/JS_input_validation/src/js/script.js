$(document).ready(function () {
  Parsley.options.maxlength = 50;
  Parsley.options.minlength = 1;
  $("#emailaddress").on("input", function () {
    const pattern = new RegExp(/^(\+)?[\w.]+@\w+\.\w+/gim);
    if (pattern.test(this.value)) {
      $("#emailaddress-error").addClass("is-valid");
      $("#emailaddress-error").text("E-mailaddress is valid");
    } else {
      $("#emailaddress-error").removeClass("is-valid");
      $("#emailaddress-error").text("E-mailaddress is not valid");
    }
  });
});
