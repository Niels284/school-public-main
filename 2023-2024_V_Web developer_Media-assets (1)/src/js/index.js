let static_dataset = null;

// When the DOM is loaded, this function will run
$(document).ready(async () => {
  try {
    static_dataset = await getDataSet();
    const current_page = localStorage.getItem("current_page");
    if (current_page === null) {
      localStorage.setItem("current_page", "shop");
    }
    loadPage(current_page);
  } catch (error) {
    console.error(error);
  }

  // Give buttons an eventlistener

  // gives buttons for configuration 1 page an eventlistener
  $(".arrow.right.symbol").click(() => {
    changeId(1, "symbol");
  });
  $(".arrow.left.symbol").click(() => {
    changeId(-1, "symbol");
  });
  $("#nextStep").click(() => {
    changePage("configuration2");
  });
  $("#back1, nav > ul > li:nth-child(1)").click(() => {
    localStorage.removeItem("cart");
    changePage("shop");
  });

  // gives buttons for configuration 2 page an eventlistener
  $(".arrow.right.color").click(() => {
    changeId(1, "colour");
  });
  $(".arrow.left.color").click(() => {
    changeId(-1, "colour");
  });

  // gives button an eventlistener
  $("#order").click(() => {
    sendDataToServer();
  });
  $("#back2").click(() => {
    changePage("configuration1");
  });
  // gives buttons for succes page an eventlistener
  $("#back3").click(() => {
    changePage("shop");
  });
});

// insert dataset.json to static_dataset (fetch async)
async function getDataSet() {
  try {
    const res = await fetch("../dataset.json");
    if (!res.ok) {
      throw new Error("Failed to fetch dataset");
    }
    const data = await res.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}

// Sends data to server and gets response
function sendDataToServer() {
  const cart = JSON.parse(localStorage.getItem("cart"));

  let dataToSend = {
    productType: parseInt(cart.id),
    symbol: parseInt(cart.symbol),
    colour: parseInt(cart.colour),
  };

  // Send data in JSON-format to the request body
  fetch("https://skills.canvasaccept.com/orders", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then((res) => {
      if (!res.ok) {
        throw new Error("Network response was not ok");
      }
      return res.json();
    })
    .then((data) => {
      if (data.success === true) {
        console.log("Bestelling is succesvol geplaatst!");
        localStorage.removeItem("cart");
        changePage("succes");
      } else {
        console.error("Server response: Error - " + data.error);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// CONTENT LOADING FUNCTIONS
function loadPage(current_page) {
  $(".active").removeClass("active");
  $("#back3").removeAttr("style");
  switch (current_page) {
    case "shop":
      getAssortment();
      break;
    case "configuration1":
      getDefaultContent();
      getConfiguration1();
      break;
    case "configuration2":
      getDefaultContent();
      getConfiguration2();
      break;
    case "succes":
      getSuccesPage();
      break;
    default:
      console.error("no page found");
  }
}

// GETS DEFAULT CONTENT FOR CONFIGURATION PAGES

// GENERATES SHOP PAGE
function getAssortment() {
  $(".productContainer").addClass("active");
  if ($(".products").children().length == 0) {
    static_dataset.products.forEach((product) => {
      $(".products").append(`
      <div class="product">
          <div class="image">
              <img class="productLayer" data-product="" src="../img/products/${product.name}.png" alt="${product.name}" />
          </div>
          <h3>${product.name}</h3>
          <button data-productid="${product.id}" class="configurate">configurate product</button>
      </div>
      `);
    });
    $(".configurate").each(function () {
      $(this).click(function (e) {
        // fill object with values
        const productid = e.target.dataset.productid;
        let cart = {
          id: productid,
          name: static_dataset.products[productid - 1].name,
          price: static_dataset.products[productid - 1].price,
          totalPrice: static_dataset.products[productid - 1].price,
          symbol: "1",
          colour: "1",
        };
        localStorage.setItem("cart", JSON.stringify(cart));
        changePage("configuration1");
      });
    });
  }
}

// DEFAULT CONTENT FOR CONFIGURATION PAGES
function getDefaultContent() {
  // gets cart item from localStorage
  const product = JSON.parse(localStorage.getItem("cart"));
  const root = "../img/";
  const colorObject = getObjectById(static_dataset.colours, product.colour);
  const symbolObject = getObjectById(static_dataset.symbols, product.symbol);

  $(".image").attr("data-productid", product.id);

  // product image
  $("#productImg").attr(
    "src",
    `${root}products/${product.name}-${colorObject.name}.png`
  );
  $("#productImg").attr("alt", `${product.name}`);

  // product symbol
  $("#symbolLayer").attr(
    "src",
    `${root}symbols/symbol-${symbolObject.name}.png`
  );
  $("#productSymbol").html(`Symbool: ${symbolObject.name}`);

  // product description
  updateTotalPrice();
  $("#productColor").html(`Kleur: ${colorObject.name}`);
  $("#productName").html(product.name);
}

// CONFIGURATION PAGE 1

function getConfiguration1() {
  const product = JSON.parse(localStorage.getItem("cart"));

  // defeaul changes at configuration 1 page
  $(".configurationContainer, .symbolForm, #nextStep, #back1").addClass(
    "active"
  );

  // gives product symbol data/values (configuration)
  const symbolName = getObjectById(static_dataset.symbols, product.symbol).name;
  $("#symbolIcon").attr("src", `../img/symbols/symbol-${symbolName}.png`);
  $("#symbolIcon").attr("alt", `${symbolName}`);
}

// CONFIGURATION PAGE 2

function getConfiguration2() {
  // gets cart item from localStorage
  const product = JSON.parse(localStorage.getItem("cart"));

  // defeaul changes at configuration 1 page
  $(".configurationContainer, .colorForm, #order, #back2").addClass("active");

  // gives product color data/values (configuration)
  $("#colorIcon").attr(
    "data-color",
    getObjectById(static_dataset.colours, product.colour).name
  );
}

// SUCCES PAGE 2

function getSuccesPage() {
  $(".configurationContainer").addClass("active");
  $("#back3").css("display", "flex");
}

// FUNCTIONS / CALCULATIONS

// change page
function changePage(new_page) {
  localStorage.setItem("current_page", new_page);
  loadPage(new_page);
}

// select object by type - value (example: type = symbol/color, productid = 1) and returns the object
function getObjectById(type, id) {
  const elements = type;
  for (const element of elements) {
    if (element.id == id) {
      return element;
    }
  }
  console.error("Geen object gevonden");
  return null;
}

// change id of type in localStorage("cart") and reloads dynamicly the page
function changeId(int, type) {
  let cart = JSON.parse(localStorage.getItem("cart"));
  switch (type) {
    case "symbol":
      cart.symbol = parseInt(cart.symbol) + int;
      cart.symbol =
        cart.symbol <= 0 ? static_dataset.symbols.length : cart.symbol;
      cart.symbol =
        cart.symbol > static_dataset.symbols.length ? 1 : cart.symbol;
      localStorage.setItem("cart", JSON.stringify(cart));
      loadPage("configuration1");
      break;
    case "colour":
      cart.colour = parseInt(cart.colour) + int;
      cart.colour =
        cart.colour <= 0 ? static_dataset.colours.length : cart.colour;
      cart.colour =
        cart.colour > static_dataset.colours.length ? 1 : cart.colour;
      localStorage.setItem("cart", JSON.stringify(cart));
      loadPage("configuration2");
      break;
    default:
      console.log("no type found");
  }
}

// this function will automatically update the totalprice
function updateTotalPrice() {
  const cart = JSON.parse(localStorage.getItem("cart"));
  const productPrice = cart.price;
  const colorPrice =
    cart.colour > 0
      ? parseInt(getObjectById(static_dataset.colours, cart.colour).price_add)
      : 0;
  const totalPrice = (
    Math.round((productPrice + colorPrice) * 100) / 100
  ).toFixed(2);

  cart.totalPrice = totalPrice;
  localStorage.setItem("cart", JSON.stringify(cart));
  $("#productPrice").html(`Totaalprijs €${totalPrice}`);
}
