$(document).ready(function () {
  fetch("./nav.json")
    .then((response) => response.json())
    .then((data) => {
      let nav = "";
      data.forEach((item) => {
        nav += `
            <li class="nav-item">
                <a class="nav-link" href="${item.url}">${item.title}</a>
            </li>
            `;
      });
      $("body").append(nav);
    });
});
