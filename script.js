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
    if (img1.src.endsWith("/icons/check.svg")) {
      img1.src = "./icons/check-fill.svg";
      taskDiv.style.backgroundColor = "#4ed44e";
    } else {
      img1.src = "./icons/check.svg";
      taskDiv.style.backgroundColor = "white";
    }
    pTag.classList.toggle("strikethrough-text");
  }

  img2.addEventListener("click", taskDeleted);
  function taskDeleted() {
    taskContainer.removeChild(taskDiv);
  }
}
