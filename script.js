document.querySelector("#add-task-btn").addEventListener("click", createTask);

const taskContainer = document.querySelector(".task-container");

function createTask() {
  const taskDiv = document.createElement("div");
  const pTag = document.createElement("p");
  const iconDiv = document.createElement("div");
  const img1 = document.createElement("img");
  const img2 = document.createElement("img");

  const inputData = document.querySelector("#textInput");
  pTag.textContent = inputData.value;

  img1.src = "./icons/check.svg";
  img1.classList.add("img1");
  img2.src = "./icons/delete.svg";
  img2.classList.add("img2");

  taskContainer.appendChild(taskDiv);
  taskDiv.appendChild(pTag);
  taskDiv.appendChild(iconDiv);
  iconDiv.appendChild(img1);
  iconDiv.appendChild(img2);
  taskDiv.classList.add("task");

  img1.addEventListener("click", taskCompleted);
  function taskCompleted() {
    pTag.classList.toggle("strikethrough-text");
  }
}

// document.querySelector(".img1").addEventListener("click", taskDeleted);
