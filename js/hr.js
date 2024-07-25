const pass = document.getElementById("password");
var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
var password = "";
for (var i = 0; i < 10; i++) {
    var randomIndex = Math.floor(Math.random() * chars.length);
    password += chars[randomIndex];
}
pass.value = password;

const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const age = document.getElementById("age");
const gender = document.getElementById("gender");
const male = document.getElementById("male");
const female = document.getElementById("female");
const header = document.getElementById("header");
const adduserForm = document.getElementById("adduserform");
const appForm = document.getElementById("appform");
const edituserform = document.getElementById("edituserform");
const photo = document.getElementById("photo");
const photo2 = document.getElementById("photo2");
const group = document.getElementById("group");
const troop = document.getElementById("troop");
const role = document.getElementById("role");
const address = document.getElementById("address");
const deleteuserform = document.getElementById("deleteuserform");
const confirm = document.getElementById("confirm");
const confirmHeader = document.getElementById("confirm-header");
const yes = document.getElementById("yes");
const districtFilter = document.getElementById("district-filter");
const troopFilter = document.getElementById("troop-filter");
const groupFilter = document.getElementById("group-filter");
const userList = document.querySelector(".edituserform ol");
const starteditform = document.getElementById("starteditform");
const fnameEdit = document.getElementById("fnameEdit");
const lnameEdit = document.getElementById("lnameEdit");
const emailEdit = document.getElementById("emailEdit");
const phoneEdit = document.getElementById("phoneEdit");
const ageEdit = document.getElementById("ageEdit");
const idEdit = document.getElementById("idEdit");
const maleEdit = document.getElementById("maleEdit");
const femaleEdit = document.getElementById("femaleEdit");
const photo2Edit = document.getElementById("photo2Edit");
const districtEdit = document.getElementById("districtEdit");
const troopEdit = document.getElementById("troopEdit");
const groupEdit = document.getElementById("groupEdit");
const roleEdit = document.getElementById("roleEdit");
const users = userList.querySelectorAll("li");
const search = document.getElementById("search");
const imgpoints = document.getElementById("imgpoints");
const imgpointsP = imgpoints.querySelectorAll("p");
function capitalizeFirstLetter(input) {
    return input.charAt(0).toUpperCase() + input.slice(1);
}
fname.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
lname.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
lnameEdit.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
fnameEdit.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
function appformshow() {
    header.innerHTML = "<p>Application Forms</p>";
    adduserForm.style.display = "none";
    appForm.style.display = "block";
    edituserform.style.display = "none";
    deleteuserform.style.display = "none";
    starteditform.style.display = "none";
}
function editformshow() {
    header.innerHTML = "<p>Edit User</p>";
    adduserForm.style.display = "none";
    appForm.style.display = "none";
    edituserform.style.display = "block";
    deleteuserform.style.display = "none";
    starteditform.style.display = "none";
}
function addformshow() {
    header.innerHTML = "<p>Add Users</p>";
    adduserForm.style.display = "block";
    appForm.style.display = "none";
    edituserform.style.display = "none";
    deleteuserform.style.display = "none";
    starteditform.style.display = "none";
    fname.value = "";
    lname.value = "";
    email.value = "";
    phone.value = "";
    address.value = "";
    address.style.display = "none";
    photo2.src = "";
    photo2.style.display = "none";
    male.checked = false;
    age.value = "";
    photo.style.display = "block";
}
function deleteformshow() {
    header.innerHTML = "<p>Delete User</p>";
    adduserForm.style.display = "none";
    appForm.style.display = "none";
    edituserform.style.display = "none";
    deleteuserform.style.display = "block";
    starteditform.style.display = "none";
}
let troopData = [
    [
        "Al Iman, Zarif",
        "Al Hassan Bin Ali, Aramoun",
        "Ali Ben Abi Taleb, Mar Elias",
        "Al Markaz Al Isleme, Aishe Bakkar",
        "Khaled Bin ALWalid, Sakiyat AlJanzir",
        "All",
    ],
    [
        "Al Manara, Hammara",
        "Khaled Bin AlWalid, Majdel Anjar",
        "Taalabaya, Taalabaya",
        "All",
    ],
    [
        "Al Iman, Daraya",
        "Al Farouk bin Omar AlKhattab, Ketermaya",
        "Al Iman, Barja",
        "Al Amin, Sibline",
        "All",
    ],
    [
        "Osama Bin Zayd, Saida",
        "Al Houssein Bin Ali, Ain EL Helwe",
        "Roukaya Bint AL Rassoul, AL hlayliya",
        "Al Sultan Mohamad Al Fatih, Abra",
        "All",
    ],
    [
        "Hamza Bin Abed AlMotaleb, Tripoli",
        "Salah Eddine AlAyoubi, Al Koura",
        "Omar Bin AlKhattab, AL Biddawi",
        "All",
    ],
    [
        "Hamza Bin Abed ALMottaleb , AL Hibariya",
        "Abou Taleb, Kfarchouba",
        "Osman bin Affan, Helta",
        "All",
    ],
];
function fillTroop(districtId, troopId) {
    let d = document.querySelector("#" + districtId);
    let t = document.querySelector("#" + troopId);
    let dselected = -1;
    dselected = d.options[d.selectedIndex].value;
    t.innerHTML = "<option selected disabled>Select Troop</option>";
    if (dselected < 0) return;
    for (let i = 0; i < troopData[dselected].length; i++) {
        let opt = document.createElement("option");
        opt.textContent = troopData[dselected][i];
        t.appendChild(opt);
    }
}
districtFilter.addEventListener("change", function () {
    fillTroop("district-filter", "troop-filter");
});
function addThis(id) {
    header.innerHTML = "<p>Add Users</p>";
    adduserForm.style.display = "block";
    appForm.style.display = "none";
    edituserform.style.display = "none";
    const li = document.getElementById(id);
    const data = li.querySelectorAll("span");

    email.value = data[0].textContent;
    phone.value = data[1].textContent;
    age.value = data[2].textContent;
    if (data[3].textContent == "male") {
        male.checked = true;
    } else {
        female.checked = true;
    }
    fname.value = data[4].textContent;
    lname.value = data[5].textContent;
    photo.style.display = "none";
    photo2.src = data[6].textContent;
    photo2.style.display = "block";
    address.style.display = "flex";
    address.value = data[7].textContent;
}
function updateOption(districtId, troopId, groupId, roleId) {
    const districtSelect = document.getElementById(districtId);
    const troopSelect = document.getElementById(troopId);
    const groupSelect = document.getElementById(groupId);
    const roleSelect = document.getElementById(roleId);
    const allOptionGroup = document.createElement("option");
    allOptionGroup.textContent = "All";
    allOptionGroup.value = "All";
    const allOptionTroop = document.createElement("option");
    allOptionTroop.textContent = "All";
    allOptionTroop.value = "All";
    const allOptionDistrict = document.createElement("option");
    allOptionDistrict.textContent = "All";
    allOptionDistrict.value = "All";

    if (roleSelect.value == "Troop Leader") {
        const optionsTroop = troopSelect.querySelectorAll("option");
        for (var i = 0; i < optionsTroop.length; i++) {
            if (optionsTroop[i].value === "All") {
                troopSelect.removeChild(optionsTroop[i]);
                troopSelect.selectedIndex = 0;
            }
        }
        const optionsDistrict = districtSelect.querySelectorAll("option");
        for (var i = 0; i < optionsDistrict.length; i++) {
            if (optionsDistrict[i].value === "All") {
                districtSelect.removeChild(optionsDistrict[i]);
                districtSelect.selectedIndex = 0;
            }
        }
        groupSelect.add(allOptionGroup);
        groupSelect.value = "All";
    } else if (roleSelect.value == "Commander") {
        const optionsDistrict = districtSelect.querySelectorAll("option");
        for (var i = 0; i < optionsDistrict.length; i++) {
            if (optionsDistrict[i].value === "All") {
                districtSelect.removeChild(optionsDistrict[i]);
                districtSelect.selectedIndex = 0;
            }
        }
        groupSelect.add(allOptionGroup);
        groupSelect.value = "All";
        troopSelect.add(allOptionTroop);
        troopSelect.value = "All";
    } else if (roleSelect.value == "Hr" || roleSelect.value == "It") {
        groupSelect.add(allOptionGroup);
        groupSelect.value = "All";
        troopSelect.add(allOptionTroop);
        troopSelect.value = "All";
        districtSelect.add(allOptionDistrict);
        districtSelect.value = "All";
    } else if (roleSelect.value == "Scout" || roleSelect.value == "Leader") {
        const optionsTroop = troopSelect.querySelectorAll("option");
        for (var i = 0; i < optionsTroop.length; i++) {
            if (optionsTroop[i].value === "All") {
                troopSelect.removeChild(optionsTroop[i]);
                troopSelect.selectedIndex = 0;
            }
        }
        const optionsDistrict = districtSelect.querySelectorAll("option");
        for (var i = 0; i < optionsDistrict.length; i++) {
            if (optionsDistrict[i].value === "All") {
                districtSelect.removeChild(optionsDistrict[i]);
                districtSelect.selectedIndex = 0;
            }
        }
        const optionsGroup = groupSelect.querySelectorAll("option");
        for (var i = 0; i < optionsGroup.length; i++) {
            if (optionsGroup[i].value === "All") {
                groupSelect.removeChild(optionsGroup[i]);
                groupSelect.selectedIndex = 0;
            }
        }
    }
}
function deleteUser(id, firstname, lastname) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to delete " + firstname + " " + lastname + "?";
    confirm.style.display = "block";
    yes.id = id;
}
function decline() {
    confirm.style.display = "none";
}
function accept() {
    window.location.href = "deleteuser.php?id=" + yes.id;
}
function filter() {
    users.forEach((user) => {
        var data = user.querySelectorAll("span");
        if (
            (data[0].textContent === "All" ||
                districtFilter.selectedOptions[0].textContent === "All" ||
                districtFilter.selectedOptions[0].textContent ===
                    "Select District" ||
                districtFilter.selectedOptions[0].textContent ===
                    data[0].textContent) &&
            (data[1].textContent === "All" ||
                troopFilter.selectedOptions[0].textContent === "All" ||
                troopFilter.selectedOptions[0].textContent === "Select Troop" ||
                troopFilter.selectedOptions[0].textContent ==
                    data[1].textContent) &&
            (data[2].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "Select Group" ||
                groupFilter.selectedOptions[0].textContent ===
                    data[2].textContent)
        ) {
            user.style.display = "list-item";
        } else {
            user.style.display = "none";
        }
    });
}
function startEdit(
    fname,
    lname,
    id,
    email,
    phone,
    age,
    gender,
    photo,
    points,
    registerDate
) {
    header.innerHTML = "<p>Edit " + fname + " " + lname + "</p>";
    edituserform.style.display = "none";
    starteditform.style.display = "block";
    fnameEdit.value = fname;
    lnameEdit.value = lname;
    emailEdit.value = email;
    phoneEdit.value = phone;
    ageEdit.value = age;
    idEdit.value = id;
    photo2Edit.src = photo;
    photo2Edit.style.display = "block";
    if (gender === "male") {
        maleEdit.checked = true;
    } else if (gender === "female") {
        femaleEdit.checked = true;
    }
    const li = document.getElementById(id);
    const data = li.querySelectorAll("span");
    for (var i = 0; i < districtEdit.options.length; i++) {
        if (districtEdit.options[i].textContent == data[0].textContent) {
            districtEdit.selectedIndex = i;
            fillTroop("districtEdit", "troopEdit");
            break;
        }
    }
    for (var i = 0; i < troopEdit.options.length; i++) {
        if (troopEdit.options[i].textContent == data[1].textContent) {
            troopEdit.selectedIndex = i;
            break;
        }
    }
    for (var i = 0; i < groupEdit.options.length; i++) {
        if (groupEdit.options[i].textContent == data[2].textContent) {
            groupEdit.selectedIndex = i;
            break;
        }
    }
    for (var i = 0; i < roleEdit.options.length; i++) {
        if (roleEdit.options[i].textContent == data[3].textContent) {
            roleEdit.selectedIndex = i;
            break;
        }
    }
    imgpointsP[0].textContent = "Joind Since: " + registerDate;
    imgpointsP[1].textContent = "Points: " + points;
    if (data[3].textContent == "Scout") {
        if (points >= 10) {
            imgpointsP[2].textContent = "Medals: 🎗️";
        }
        if (points >= 20) {
            imgpointsP[2].textContent = "Medals: 🎗️🏅";
        }
        if (points >= 30) {
            imgpointsP[2].textContent = "Medals: 🎗️🏅🥇";
        }
        if (points >= 40) {
            imgpointsP[2].textContent = "Medals: 🎗️🏅🥇🥉";
        }
        if (points >= 50) {
            imgpointsP[2].textContent = "Medals: 🎗️🏅🥇🥉🎖️";
        }
    } else if (data[3].textContent == "Leader") {
        imgpointsP[2].textContent = "Medals: 🎗️🏅🥇🥉🎖️🏵️";
    } else if (data[3].textContent == "Troop Leader") {
        imgpointsP[2].textContent = "Medals: 🎗️🏅🥇🥉🎖️🏵️🛡️";
    } else if (data[3].textContent == "Commander") {
        imgpointsP[2].textContent = "Medals: 🎗️🏅🥇🥉🎖️🏵️🛡️⚜️";
    } else if (data[3].textContent == "Hr") {
        imgpointsP[2].textContent = "";
        imgpointsP[1].textContent = "";
    } else if (data[3].textContent == "It") {
        imgpointsP[2].textContent = "";
        imgpointsP[1].textContent = "";
    }
}
function searchUser() {
    let searchText = search.value.toLowerCase();
    users.forEach((user) => {
        let userName = user.textContent.toLowerCase();
        if (userName.includes(searchText)) {
            user.style.display = "list-item";
        } else {
            user.style.display = "none";
        }
    });
}
