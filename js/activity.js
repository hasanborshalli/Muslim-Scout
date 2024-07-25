var today = new Date().toISOString().split("T")[0];
document.getElementById("date").setAttribute("min", today);
const newActivity = document.getElementById("new-activity");
const editActivity = document.getElementById("edit-activity");
const requestActivityBlock = document.getElementById("request-activityBlock");
const requestedActivitiesBlock = document.getElementById(
    "requested-activitiesBlock"
);
const title = document.getElementById("title");
const description = document.getElementById("description");
const activitylocation = document.getElementById("location");
const group = document.getElementById("group");
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
const h1 = document.querySelector(".edit-activity h1");
function addActivityShow() {
    if (newActivity.style.display == "block") {
        newActivity.style.display = "none";
    } else {
        newActivity.style.display = "block";
        requestedActivitiesBlock.style.display = "none";
        editActivity.style.display = "none";
    }
}
function requestActivityShow() {
    if (requestActivityBlock.style.display == "block") {
        requestActivityBlock.style.display = "none";
    } else {
        requestActivityBlock.style.display = "block";
    }
}
function requestedActivitiesShow() {
    if (requestedActivitiesBlock.style.display == "flex") {
        requestedActivitiesBlock.style.display = "none";
    } else {
        requestedActivitiesBlock.style.display = "flex";
        newActivity.style.display = "none";
        editActivity.style.display = "none";
    }
}
function acceptActivity(id) {
    var tr = document.getElementById(id);
    var data = tr.querySelectorAll("td");
    addActivityShow();
    title.value = data[0].textContent;
    description.value = data[1].textContent;
    activitylocation.value = data[2].textContent;
    for (var i = 0; i < group.options.length; i++) {
        if (group.options[i].textContent == data[4].textContent) {
            group.selectedIndex = i;
            break;
        }
    }
}
function rejectActivity(id, title, name, email) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to reject " + title + "?";
    confirm.style.display = "block";
    yes.style.display = "none";
    yes2.style.display = "block";
    yes2.onclick = function () {
        window.location.href =
            "delete.php?todel=" + id + "&toname=" + name + "&email=" + email;
    };
}
function deleteActivity(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to delete " + title + "?";
    confirm.style.display = "block";
    yes.id = id;
    yes.style.display = "block";
    yes2.style.display = "none";
}
function decline() {
    confirm.style.display = "none";
}
function EditActivity(
    id,
    title,
    date,
    time,
    description,
    location,
    gathering,
    group
) {
    if (editActivity.style.display == "block") {
        editActivity.style.display = "none";
    } else {
        editActivity.style.display = "block";
        h1.textContent = "Editing " + title + " Activity";
        newActivity.style.display = "none";
        requestActivityBlock.style.display = "none";
        requestedActivitiesBlock.style.display = "none";
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
