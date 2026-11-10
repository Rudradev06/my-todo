const addTaskBtn = document.querySelector("#add-task-btn");
const taskContainer = document.querySelector(".task-container");
const inputData = document.querySelector("#textInput");

addTaskBtn.addEventListener("click", createTask);

document.addEventListener("DOMContentLoaded", loadTasks);

async function loadTasks() {
  try {
    const response = await fetch("api.php", {
      method: "GET",
    });

    if (!response.ok) {
      throw new Error(`HTTP error: ${response.status}`);
    }

    const data = await response.json();

    console.log("Tasks from database:", data);

    if (data.success) {
      data.tasks.forEach((task) => {
        addTaskToUI(task);
      });
    } else {
      console.error(data.error);
    }
  } catch (error) {
    console.error("Failed to load tasks:", error);
  }
}

async function createTask() {
  const taskTitle = inputData.value;

  try {
    const response = await sendPostRequest(taskTitle);

    console.log(response);

    if (response.success) {
      addTaskToUI(response.task);
      inputData.value = "";
    } else {
      console.error(response.error);
    }
  } catch (error) {
    console.error("Request failed:", error);
  }
}

function addTaskToUI(task) {
  const taskDiv = document.createElement("div");
  const pTag = document.createElement("p");
  const iconDiv = document.createElement("div");

  const img1 = document.createElement("img");
  const img2 = document.createElement("img");

  pTag.textContent = task.title;

  img1.src = "./icons/check.svg";
  img1.classList.add("img1");
  img2.src = "./icons/delete.svg";
  img2.classList.add("img2");

  taskDiv.classList.add("task");

  taskContainer.appendChild(taskDiv);
  taskDiv.appendChild(pTag);
  taskDiv.appendChild(iconDiv);
  iconDiv.appendChild(img1);
  iconDiv.appendChild(img2);

  img1.addEventListener("click", function () {
    const completed = img1.dataset.completed === "true";
    if (!completed) {
      img1.src = "./icons/check-fill.svg";
      taskDiv.style.backgroundColor = "#4ed44e";
      pTag.classList.add("strikethrough-text");
      img1.dataset.completed = "true";
    } else {
      img1.src = "./icons/check.svg";
      taskDiv.style.backgroundColor = "white";
      pTag.classList.remove("strikethrough-text");
      img1.dataset.completed = "false";
    }
  });

  img2.addEventListener("click", () => {
    deleteTask(task.id, taskDiv);
  });
}

async function sendPostRequest(taskTitle) {
  const payload = {
    task_title: taskTitle,
  };

  const response = await fetch("api.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    throw new Error(`HTTP error: ${response.status}`);
  }

  return await response.json();
}

async function deleteTask(taskId, taskDiv) {
  try {
    const response = await fetch("api.php", {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: taskId }),
    });

    if (!response.ok) {
      console.error("Failed to delete task from database");
    }

    const data = await response.json();
    console.log("Delete response:", data);
    if (data.success) {
      taskDiv.remove();
    } else {
      console.error(data.error);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
