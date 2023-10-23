// URL en opties voor de fetch
const url = "https://www.dennisvanriet.nl/RESTAPI_PROMISES/";
const options = {
  Accept: "text/plain, text/html, application/json",
};

// fetch url en accept headers
fetch(url, options)
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response is niet ok");
    } else {
      const contentType = response.headers.get("Content-Type");
      if (
        contentType.includes("text/plain") ||
        contentType.includes("text/html") ||
        contentType.includes("application/json")
      ) {
        return response.text();
      } else {
        throw new Error("Onverwacht formaat ontvangen");
      }
    }
  })
  .catch((error) => {
    console.error("Fout bij het ophalen van gegevens:", error);
  });

// ophalen van gegevens
async function getData(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Fout bij het ophalen van gegevens:", error);
  }
}

// data in een lijst zetten
async function listData(data) {
  const ol = document.createElement("ol");
  for (let obj of data) {
    const li = document.createElement("li");
    li.innerText = obj.title;
    ol.appendChild(li);
  }
  return ol;
}

// data in de DOM (body) verwerken
async function addToDOM(element) {
  document.body.appendChild(element);
}

// ophalen van data, verwerken en in de DOM zetten
getData("https://jsonplaceholder.typicode.com/todos")
  .then((d) => listData(d))
  .then((f) => addToDOM(f));
