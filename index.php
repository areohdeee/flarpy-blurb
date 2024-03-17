<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <title>Flarpy Blurb 1.3</title>
  </head>
  <body>
    <div id="gameContainer">
      <div id="bird"></div>
      <div class="pipe" id="pipeTop"></div>
      <div class="pipe" id="pipeBottom"></div>
      <div id="tooltip" class="tooltip">Ouch!</div>
    </div>
    <script>
      const bird = document.getElementById("bird");
      const pipeTop = document.getElementById("pipeTop");
      const pipeBottom = document.getElementById("pipeBottom");
      const tooltip = document.getElementById("tooltip");
      let birdTop = 200;
      let gravity = 2;
      let pipeLeft = 400;
      let pipeHeight = Math.random() * (window.innerHeight - 200) + 50; // viewable area height

      document.addEventListener("keydown", flap);
      document.addEventListener("touchstart", handleTouchStart);

      let touchStartX = 0;
      let touchStartY = 0;

      function flap() {
        birdTop -= 50;
        bird.style.top = birdTop + "px";
        updateTooltipPosition();
      }

      function handleTouchStart(event) {
        if (event.touches.length === 1) {
          const touch = event.touches[0];
          touchStartX = touch.clientX;
          touchStartY = touch.clientY;
        }
      }

      document.addEventListener(
        "touchmove",
        function (event) {
          if (event.touches.length === 1) {
            event.preventDefault();
          }
        },
        { passive: false }
      );

      document.addEventListener("touchend", function (event) {
        if (event.changedTouches.length === 1) {
          const touch = event.changedTouches[0];
          const distX = touch.clientX - touchStartX;
          const distY = touch.clientY - touchStartY;
          if (Math.abs(distX) < 10 && Math.abs(distY) < 10) {
            flap();
          }
        }
      });

      function updateTooltipPosition() {
        tooltip.style.top = birdTop + "px";
        tooltip.style.left = bird.offsetLeft + bird.offsetWidth + 10 + "px"; // Adjust as needed
      }

      function gameLoop() {
        birdTop += gravity;
        bird.style.top = birdTop + "px";
        updateTooltipPosition();

        pipeLeft -= 5;
        pipeTop.style.left = pipeBottom.style.left = pipeLeft + "px";

        if (pipeLeft <= -50) {
          pipeLeft = window.innerWidth; // viewable area width
          pipeHeight = Math.random() * (window.innerHeight - 200) + 50; // viewable area height
        }

        pipeTop.style.height = pipeHeight + "px";
        pipeBottom.style.height = window.innerHeight - pipeHeight - 100 + "px"; // height of bottom pipe

        if (birdTop <= 0 || birdTop >= window.innerHeight - 30) {
          gameOver();
        }

        // collision
        if (
          (birdTop <= pipeHeight ||
            birdTop + 30 >= window.innerHeight - pipeHeight - 100) &&
          pipeLeft <= 90 &&
          pipeLeft + 50 >= 50
        ) {
          console.log("Collision detected!"); // Check if collision is detected
          showTooltip();
          gameOver();
        }

        requestAnimationFrame(gameLoop);
      }

      function showTooltip() {
        console.log("Showing tooltip..."); // Check if the function is called
        tooltip.style.visibility = "visible";
        setTimeout(() => {
          tooltip.style.visibility = "hidden";
        }, 400); // Hide the tooltip after 2 seconds
      }

      function gameOver() {
        showTooltip();
        //alert("Game Over!");
        birdTop = 200;
        bird.style.top = birdTop + "px";
      }

      gameLoop();
    </script>
    <style>
      body,
      html {
        margin: 0;
        padding: 0;
        overflow: hidden;
        width: 100%;
        height: 100%;
      }

      #gameContainer {
        position: relative;
        width: 100%;
        height: 100%;
      }

      #bird {
        position: absolute;
        top: 50%;
        left: 50px;
        width: 40px;
        height: 30px;
        background-color: #c6ab12;
        border-radius: 50%;
        transition: top 0.3s;
      }

      .pipe {
        position: absolute;
        width: 50px;
        background-color: #56aa67;
      }

      #pipeTop {
        top: 0;
      }

      #pipeBottom {
        bottom: 0;
      }

      .tooltip {
        position: absolute;
        background-color: #ffffff;
        border: 2px solid #000;
        padding: 10px;
        border-radius: 10px;
        visibility: hidden;
      }
    </style>
  </body>
</html>
