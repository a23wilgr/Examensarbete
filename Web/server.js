const express = require("express");

const app = express();

const path = require("path");

app.get("/", (req, res) => {
    res.sendFile(
        path.join(__dirname, "index.html")
    );
});

app.get("/search", (req, res) => {

    const word = req.query.q;

    res.json({
        message: "Search worked",
        word: word
    });

});

app.listen(3000, () => {
    console.log("Server running on port 3000");
});