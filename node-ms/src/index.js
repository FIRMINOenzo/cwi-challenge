const express = require("express");
const app = express();
const port = process.env.PORT ? Number(process.env.PORT) : 3000;

app.get("/", (_req, res) => {
  res.send({ message: "I'm running with Node.js and Express!" });
});

app.listen(port, () => {
  console.log(`Node Microservice listening on port ${port}`);
});
