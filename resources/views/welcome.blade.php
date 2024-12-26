<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinktech - The NextGEN RO</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Body and page styling */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #ff7e5f, #feb47b); /* Beautiful gradient background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
    text-align: center;
    overflow: hidden;
}

/* Container styling */
.container {
    position: relative;
    display: inline-block;
}

/* Typing text effect */
#typed-text {
    font-size: 3rem;
    font-weight: bold;
    letter-spacing: 2px;
    border-right: 4px solid #fff;
    padding-right: 10px;
    animation: typing 4s steps(20) 1s infinite, blink 0.75s step-end infinite;
}

/* Typing animation */
@keyframes typing {
    0% {
        width: 0;
    }
    100% {
        width: 100%;
    }
}

/* Cursor blinking effect */
@keyframes blink {
    50% {
        border-color: transparent;
    }
}

</style>
<body>
    <div class="container">
        <h1 id="typed-text"></h1>
    </div>

    <script>
        // Define the text you want to display
const text = "Drinktech - The NextGEN RO";
let index = 0;
const speed = 150;  // Typing speed in milliseconds

// Function to type the text one character at a time
function typeText() {
    const typedTextElement = document.getElementById("typed-text");

    // Add one character at a time
    typedTextElement.innerHTML = text.substring(0, index);

    index++;

    // If the entire text has been typed, restart from the beginning
    if (index > text.length) {
        index = 0;
    }

    // Call the typeText function every 'speed' milliseconds
    setTimeout(typeText, speed);
}

// Start typing the text
typeText();

    </script>
</body>
</html>
