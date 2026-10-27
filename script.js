document.querySelector("#btn1").addEventListener("click", createTask);

const parentDiv = document.createElement("div");
document.body.appendChild(parentDiv);
parentDiv.classList.add("parentDiv");

const div1 = document.createElement("div");
const para1 = document.createElement("p");
const div2 = document.createElement("div");
const img1 = document.createElement("img");
const img2 = document.createElement("img");

function createTask() {
  const inputData = document.querySelector("#textInput");
  para1.textContent = inputData.value;

  div1.appendChild(para1);
  parentDiv.appendChild(div1);

  img1.src = "./icons/check.svg";
  img1.classList.add("img1");
  img2.src = "./icons/delete.svg";
  img2.classList.add("img2");

  div2.appendChild(img1);
  div2.appendChild(img2);
  parentDiv.appendChild(div2);
}

img1.addEventListener("click", taskCompleted);
// document.querySelector(".img1").addEventListener("click", taskDeleted);

function taskCompleted() {
  const x = document.querySelector("p");
  x.classList.toggle("strikethrough-text");
}
