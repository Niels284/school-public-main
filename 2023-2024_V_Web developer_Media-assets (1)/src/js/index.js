// insert dataset.json (fetch async)
function getDataSet(page) {
  fetch("../dataset.json")
    .then((response) => response.json())
    .then((dataset) => {
      switch (page) {
        case "shop":
          getAssortment(dataset);
          break;
        case "configuration1":
          getContent(dataset);
          getConfiguration1(dataset);
          break;
        case "configuration2":
          getContent(dataset);
          getConfiguration2(dataset);
          break;
        case "succes":
          getSuccesPage();
          break;
        default:
          console.log(`Sorry, we didn't found the ${page}.`);
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      throw error;
    });
}

// Sends data to server and gets response
function sendDataToServer() {
  const cart = JSON.parse(localStorage.getItem("cart"));

  // Creates an object with the data to send the server
  // If the value is 0, value will be 1 or we get an error from the server
  let dataToSend = {};
  if (cart.symbol < 1 && cart.colour >= 1) {
    dataToSend = {
      productType: parseInt(cart.id),
      symbol: 1,
      colour: parseInt(cart.colour),
    };
  } else if (cart.symbol >= 1 && cart.colour < 1) {
    dataToSend = {
      productType: parseInt(cart.id),
      symbol: parseInt(cart.symbol),
      colour: 1,
    };
  } else if (cart.symbol < 1 && cart.colour < 1) {
    dataToSend = {
      productType: parseInt(cart.id),
      symbol: 1,
      colour: 1,
    };
  } else {
    dataToSend = {
      productType: parseInt(cart.id),
      symbol: parseInt(cart.symbol),
      colour: parseInt(cart.colour),
    };
  }

  console.log(dataToSend);

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
        console.log("Bestelling succesvol verstuurd");
        localStorage.removeItem("cart");
        localStorage.setItem("page", "succes");
        window.location.href = "index.html";
      } else {
        console.error("Server response: Error - " + data.error);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// When the DOM is loaded, this function will run
window.addEventListener("DOMContentLoaded", () => {
  const page = localStorage.getItem("page");
  switch (page) {
    case "shop":
      getDataSet("shop");
      break;
    case "configuration1":
      getDataSet("configuration1");
      break;
    case "configuration2":
      getDataSet("configuration2");
      break;
    case "succes":
      getDataSet("succes");
      break;
    default:
      getDataSet("shop");
  }
  document
    .querySelector("nav > ul > li:nth-child(1)")
    .addEventListener("click", () => {
      localStorage.setItem("page", "shop");
      localStorage.removeItem("cart");
      window.location.href = "index.html";
    });
});

// GENERATES SHOP PAGE
function getAssortment(dataset) {
  // defeaul changes at configuration 1 page
  document.querySelector(".configuration").style.display = "none";
  document.querySelector("#back3").style.display = "none";

  console.log("Welcome to the shop");

  const assortment = dataset;
  assortment.products.forEach((products) => {
    document.querySelector(".products").innerHTML += `
    <div class="product">
        <div class="image">
            <img class="productLayer" data-product="" src="../img/products/${products.name}.png" alt="${products.name}" />
        </div>
        <h3>${products.name}</h3>
        <button data-productid="${products.id}">configurate product</button>
    </div>
    `;
  });

  // Your other code can go here, and it will execute after the async operation is done.
  const buttons = document.querySelectorAll(".product > button");
  buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
      // object vullen met product data en omzetten in json
      const productid = e.target.dataset.productid;
      let cart = {
        id: productid,
        name: dataset.products[productid - 1].name,
        price: dataset.products[productid - 1].price,
        totalPrice: dataset.products[productid - 1].price,
        symbol: "0",
        colour: "0",
      };
      localStorage.setItem("cart", JSON.stringify(cart));
      localStorage.setItem("page", "configuration1");
      window.location.href = "index.html";
    });
  });
}

// GETS DEFAULT CONTENT FOR CONFIGURATION PAGES

function getContent(dataset) {
  // gets cart item from localStorage
  const product = JSON.parse(localStorage.getItem("cart"));
  let colorName = "";

  // gives product img data/values
  if (product.colour > 0) {
    colorName = `-${getObjectById(dataset.colours, product.colour).name}`;
    document.querySelector("#productColor").innerHTML = `Kleur: ${
      getObjectById(dataset.colours, product.colour).name
    }`;
  } else {
    colorName = "";
    document.querySelector("#productColor").innerHTML = `Kleur: wit`;
  }

  // product image
  const productImg = document.querySelector("#productImg");
  productImg.src = `../img/products/${product.name}${colorName}.png`;
  productImg.alt = `${product.name}-${colorName}`;

  // product symbol
  if (product.symbol > 0) {
    const symbolName = getObjectById(dataset.symbols, product.symbol).name;
    symbolLayer.src = `../img/symbols/symbol-${symbolName}.png`;
    symbolLayer.alt = `${symbolName}`;
    document.querySelector(
      "#productSymbol"
    ).innerHTML = `Symbool: ${symbolName}`;
  } else {
    symbolLayer.src = ``;
    symbolLayer.alt = ``;
    document.querySelector("#productSymbol").innerHTML = `Symbool: leeg`;
  }

  document.querySelector(".image").dataset.productid = `${product.id}`;

  // product description
  updateTotalPrice(dataset);
  document.querySelector("#productName").innerHTML = product.name;
}

// CONFIGURATION PAGE 1

function getConfiguration1(dataset) {
  console.log("Welcome to the configuration page 1");

  // gets cart item from localStorage
  const product = JSON.parse(localStorage.getItem("cart"));

  // defeaul changes at configuration 1 page
  document.querySelector(".symbolForm").style.display = "block";
  document.querySelector("#nextStep").style.display = "block";
  document.querySelector(".colorForm").style.display = "none";
  document.querySelector("#order").style.display = "none";
  document.querySelector("#back1").style.display = "block";
  document.querySelector("#back2").style.display = "none";
  document.querySelector("#back3").style.display = "none";

  // gives product symbol data/values (configuration)
  if (product.symbol > 0) {
    const symbolName = getObjectById(dataset.symbols, product.symbol).name;
    symbolIcon.src = `../img/symbols/symbol-${symbolName}.png`;
    symbolIcon.alt = `${symbolName}`;
  } else {
    symbolIcon.src = ``;
    symbolIcon.alt = ``;
  }

  // change product symbol by clicking on arrow
  document
    .querySelector(".arrow.right.symbol")
    .addEventListener("click", () => {
      changeId(1, "symbol", dataset);
    });
  document.querySelector(".arrow.left.symbol").addEventListener("click", () => {
    changeId(-1, "symbol", dataset);
  });

  // gives button an eventlistener
  document.querySelector("#nextStep").addEventListener("click", () => {
    localStorage.setItem("page", "configuration2");
    window.location.href = "index.html";
  });

  document.querySelector("#back1").addEventListener("click", () => {
    localStorage.setItem("page", "shop");
    localStorage.removeItem("cart");
    window.location.href = "index.html";
  });
}

// CONFIGURATION PAGE 2

function getConfiguration2(dataset) {
  console.log("Welcome to the configuration page 2");

  // gets cart item from localStorage
  const product = JSON.parse(localStorage.getItem("cart"));

  // defeaul changes at configuration 1 page
  document.querySelector(".symbolForm").style.display = "none";
  document.querySelector("#nextStep").style.display = "none";
  document.querySelector(".colorForm").style.display = "block";
  document.querySelector("#order").style.display = "block";
  document.querySelector("#back1").style.display = "none";
  document.querySelector("#back2").style.display = "block";
  document.querySelector("#back3").style.display = "none";

  // gives product color data/values (configuration)
  const colorIcon = document.querySelector("#colorIcon");
  if (product.colour > 0) {
    colorName = getObjectById(dataset.colours, product.colour).name;
    colorIcon.dataset.color = colorName;
  } else {
    colorIcon.dataset.color = 0;
  }

  // change product color by clicking on arrow (configuration)
  document.querySelector(".arrow.right.color").addEventListener("click", () => {
    changeId(1, "colour", dataset);
  });
  document.querySelector(".arrow.left.color").addEventListener("click", () => {
    changeId(-1, "colour", dataset);
  });

  // gives button an eventlistener
  document.querySelector("#order").addEventListener("click", () => {
    document.querySelector(".configuration").style.display = "none";
    sendDataToServer();
  });

  document.querySelector("#back2").addEventListener("click", () => {
    localStorage.setItem("page", "configuration1");
    window.location.href = "index.html";
  });
}

function getSuccesPage() {
  const selectedItems = document.querySelectorAll(
    ".image, #productName, #productPrice, .productSettings, #back1, #nextStep, #back2, #order"
  );
  selectedItems.forEach((item) => {
    item.style.display = "none";
  });

  document.querySelector("#back3").style.display = "flex";

  document.querySelector("#back3").addEventListener("click", () => {
    localStorage.setItem("page", "shop");
    window.location.href = "index.html";
  });
}

// FUNCTION / CALCULATIONS

// select object by type - value (example: type = symbol/color, productid = 1) and returns the object
function getObjectById(type, id) {
  for (let i = 0; i < type.length; i++) {
    if (type[i].id === id) {
      return type[i];
    }
  }
  console.error("no object found");
  return null;
}

function changeId(int, type, dataset) {
  let cart = JSON.parse(localStorage.getItem("cart"));
  switch (type) {
    case "symbol":
      cart.symbol = parseInt(cart.symbol) + int;
      cart.symbol = cart.symbol < 0 ? 9 : cart.symbol;
      cart.symbol = cart.symbol > 9 ? 0 : cart.symbol;
      localStorage.setItem("cart", JSON.stringify(cart));
      updateTotalPrice(dataset);

      // gives product symbol data/values (configuration)
      const symbolIcon = document.querySelector("#symbolIcon");
      const symbolLayer = document.querySelector("#symbolLayer");
      if (cart.symbol > 0) {
        const symbolName = getObjectById(dataset.symbols, cart.symbol).name;
        symbolIcon.src = `../img/symbols/symbol-${symbolName}.png`;
        symbolIcon.alt = `${symbolName}`;
        symbolLayer.src = `../img/symbols/symbol-${symbolName}.png`;
        symbolLayer.alt = `${symbolName}`;
        document.querySelector(
          "#productSymbol"
        ).innerHTML = `Symbool: ${symbolName}`;
      } else {
        symbolIcon.src = ``;
        symbolIcon.alt = ``;
        symbolLayer.src = ``;
        symbolLayer.alt = ``;
        document.querySelector("#productSymbol").innerHTML = `Symbool: leeg`;
      }
      break;
    case "colour":
      cart.colour = parseInt(cart.colour) + int;
      cart.colour = cart.colour < 0 ? 4 : cart.colour;
      cart.colour = cart.colour > 4 ? 0 : cart.colour;
      localStorage.setItem("cart", JSON.stringify(cart));
      updateTotalPrice(dataset);

      let colorName = "";

      // gives product color data/values (configuration)
      const colorIcon = document.querySelector("#colorIcon");
      if (cart.colour > 0) {
        colorName = getObjectById(dataset.colours, cart.colour).name;
        colorIcon.dataset.color = colorName;

        colorName = `-${getObjectById(dataset.colours, cart.colour).name}`;
        document.querySelector("#productColor").innerHTML = `Kleur: ${
          getObjectById(dataset.colours, cart.colour).name
        }`;
      } else {
        colorIcon.dataset.color = 0;
        colorName = "";
        document.querySelector("#productColor").innerHTML = `Kleur: wit`;
      }

      // product image
      const productImg = document.querySelector("#productImg");
      productImg.src = `../img/products/${cart.name}${colorName}.png`;
      productImg.alt = `${cart.name}-${colorName}`;
      break;
    default:
      console.log("no type found");
  }
}

function updateTotalPrice(dataset) {
  const cart = JSON.parse(localStorage.getItem("cart"));
  const productPrice = cart.price;
  const colorPrice =
    cart.colour > 0
      ? parseInt(getObjectById(dataset.colours, cart.colour).price_add)
      : 0;
  const totalPrice = (
    Math.round((productPrice + colorPrice) * 100) / 100
  ).toFixed(2);

  cart.totalPrice = totalPrice;
  localStorage.setItem("cart", JSON.stringify(cart));
  document.querySelector(
    "#productPrice"
  ).innerHTML = `Totaalprijs €${totalPrice}`;
}
