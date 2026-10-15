document.querySelector("#btn1").addEventListener("click", createTask);

const ulist = document.querySelector("#ulist");
const inputData = document.querySelector("#textInput");
let width = parseInt(
  document.querySelector("#textInput").style.width.slice(0, 3),
);

let i = 0;

function createTask() {
  const li1 = document.createElement("li");
  li1.textContent = inputData.value;

  ulist.appendChild(li1);
  //   console.log("creating task!");
}
