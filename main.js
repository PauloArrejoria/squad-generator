const generateSquadBtn = document.getElementById("generate-squad");

document.addEventListener("DOMContentLoaded", function () {
  console.log("main.js ready");
});

generateSquadBtn.addEventListener("click", function () {
  console.log("click");
  generateSquad();
});

function generateSquad() {
  const xhr = new XMLHttpRequest();

  var data = new FormData();

  data.append("action", "generateSquad");
  data.append("lineup", document.getElementById("lineup").value);

  xhr.open("POST", "inc/players.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(JSON.parse(xhr.responseText));
    }
  };

  xhr.send(data);
}
