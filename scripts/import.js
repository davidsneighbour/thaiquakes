/* eslint-disable no-console */
/* eslint-disable @typescript-eslint/no-var-requires */
const fs = require("fs");
const https = require("https");

const file = fs.createWriteStream("temp/data.txt");

let countChunks = 0;

https.get("https://www.tmd.go.th/en/xml/earthquake_eng.php", (response) => {
  let responseBody = "";

  response.on("data", function responseOnData(chunk) {
    countChunks += 1;
    responseBody += chunk;
  });
  response.on("end", function responseOnEnd() {
    file.write(responseBody);
    file.end();
    console.log(`Finished after ${countChunks} chunk(s)`);

    const parser = new DOMParser();
    const document = parser.parseFromString(body, "application/xml");
    // print the name of the root element or error message
    const errorNode = document.querySelector("parsererror");
    if (errorNode) {
      console.log("error while parsing");
    } else {
      console.log(document.documentElement.nodeName);
    }



  });
});
