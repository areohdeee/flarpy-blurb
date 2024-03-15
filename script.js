const bird = document.getElementById("bird");
const pipeTop = document.getElementById("pipeTop");
const pipeBottom = document.getElementById("pipeBottom");
let birdTop = 200;
let gravity = 2;
let pipeLeft = 400;
let pipeHeight = Math.random() * (window.innerHeight - 200) + 50; // viewable area height

document.addEventListener("keydown", flap);

function flap() {
  birdTop -= 50;
  bird.style.top = birdTop + "px";
}

function gameLoop() {
  birdTop += gravity;
  bird.style.top = birdTop + "px";

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
    gameOver();
  }

  requestAnimationFrame(gameLoop);
}

function gameOver() {
  //alert("Game Over!");
  birdTop = 200;
  bird.style.top = birdTop + "px";
}

gameLoop();
