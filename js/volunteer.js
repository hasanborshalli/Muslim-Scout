var today = new Date().toISOString().split("T")[0];
document.getElementById("date").setAttribute("min", today);
const requestWorkBlock = document.getElementById("request-workBlock");
const requestedWorksBlock = document.getElementById("requested-WorksBlock");
const addWorkBlock = document.getElementById("new-work");
const editWork = document.getElementById("edit-work");
const title = document.getElementById("title");
const description = document.getElementById("description");
const worklocation = document.getElementById("location");
const titleEdit = document.getElementById("titleEdit");
const descriptionEdit = document.getElementById("descriptionEdit");
const dateEdit = document.getElementById("dateEdit");
const timeEdit = document.getElementById("timeEdit");
const locationEdit = document.getElementById("locationEdit");
const groupEdit = document.getElementById("groupEdit");
const gatheringEdit = document.getElementById("gatheringEdit");
const idEdit = document.getElementById("idEdit");
const confirm = document.getElementById("confirm");
const confirmHeader = document.getElementById("confirm-header");
const yes = document.getElementById("yes");
const yes2 = document.getElementById("yes2");
const yes3 = document.getElementById("yes3");
const h1 = editWork.querySelector("h1");
function requestWorkShow() {
    if (requestWorkBlock.style.display == "block") {
        requestWorkBlock.style.display = "none";
    } else {
        requestWorkBlock.style.display = "block";
    }
}
function requestedWorkShow() {
    if (requestedWorksBlock.style.display == "flex") {
        requestedWorksBlock.style.display = "none";
    } else {
        requestedWorksBlock.style.display = "flex";
        addWorkBlock.style.display = "none";
        editWork.style.display = "none";
    }
}
function addWorkShow() {
    if (addWorkBlock.style.display == "block") {
        addWorkBlock.style.display = "none";
    } else {
        addWorkBlock.style.display = "block";
        requestedWorksBlock.style.display = "none";
        editWork.style.display = "none";
    }
}
function acceptWork(id) {
    var tr = document.getElementById(id);
    var data = tr.querySelectorAll("td");
    addWorkShow();
    title.value = data[0].textContent;
    description.value = data[1].textContent;
    worklocation.value = data[2].textContent;
}
function deleteRegisteredWork(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to unregister " + title + "?";
    confirm.style.display = "block";
    yes.style.display = "none";
    yes2.style.display = "block";
    yes3.style.display = "none";
    yes2.id = id;
}
function registerWork(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to register " + title + "?";
    confirm.style.display = "block";
    yes2.style.display = "none";
    yes.style.display = "none";
    yes3.style.display = "block";
    yes3.id = id;
}
function deleteWork(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to delete " + title + "?";
    confirm.style.display = "block";
    yes2.style.display = "none";
    yes.style.display = "block";
    yes3.style.display = "none";
    yes.id = id;
}
function decline() {
    confirm.style.display = "none";
}
function EditWork(
    id,
    title,
    date,
    time,
    description,
    location,
    gathering,
    group
) {
    if (editWork.style.display == "block") {
        editWork.style.display = "none";
    } else {
        editWork.style.display = "block";
        h1.textContent = "Editing " + title + " Work";
        addWorkBlock.style.display = "none";
        requestWorkBlock.style.display = "none";
        requestedWorksBlock.style.display = "none";
    }
    titleEdit.value = title;
    descriptionEdit.value = description;
    dateEdit.value = date;
    timeEdit.value = time;
    locationEdit.value = location;
    gatheringEdit.value = gathering;
    idEdit.value = id;
    for (var i = 0; i < groupEdit.options.length; i++) {
        if (groupEdit.options[i].textContent == group) {
            groupEdit.selectedIndex = i;
            break;
        }
    }
}
function showRegisteredDiv(id) {
    const div = document.getElementById("registered-" + id);
    if (div.style.display == "flex") {
        div.style.display = "none";
    } else {
        div.style.display = "flex";
    }
}
