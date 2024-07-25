const header = document.getElementById("header");
const addbookform = document.getElementById("addbookform");
const addnewform = document.getElementById("addnewform");
const deleteBookform = document.getElementById("deletebookform");
const deletenewform = document.getElementById("deletenewform");
const editnewform = document.getElementById("editnewform");
const starteditnew = document.getElementById("startEditNew");
const editbookform = document.getElementById("editbookform");
const starteditbook = document.getElementById("startEditBook");
const confirm = document.getElementById("confirm");
const confirmHeader = document.getElementById("confirm-header");
const yes = document.getElementById("yes");
const yes2 = document.getElementById("yes2");
const titleEdit = document.getElementById("titleEdit");
const descriptionEdit = document.getElementById("descriptionEdit");
const photoEdit = document.getElementById("photoEdit");
const photoEdit2 = document.getElementById("photo");
const idEdit = document.getElementById("idEdit");
const titleEditBook = document.getElementById("titleEditBook");
const linkeditBook = document.getElementById("linkEditBook");
const idEditBook = document.getElementById("idEditBook");
const searchBooks = document.getElementById("searchBooks");
const books = document.querySelectorAll("#BookappList li");
const searchNews = document.getElementById("searchNews");
const news = document.querySelectorAll("#NewappList li");
function addbookformShow() {
    header.innerHTML = "<p>Add Books</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "flex";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function addnewformShow() {
    header.innerHTML = "<p>Add News</p>";
    addnewform.style.display = "flex";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function deletebookformShow() {
    header.innerHTML = "<p>Delete Books</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "block";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function editnewformShow() {
    header.innerHTML = "<p>Edit News</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "block";
    editbookform.style.display = "none";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function editbookformShow() {
    header.innerHTML = "<p>Edit Books</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "block";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function deleteBook(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to delete " + title + "?";
    confirm.style.display = "block";
    yes2.style.display = "none";
    yes.style.display = "block";
    yes.id = id;
}
function decline() {
    confirm.style.display = "none";
}
function accept() {
    window.location.href = "deletebook.php?id=" + yes.id;
}
function accept2() {
    window.location.href = "deletenew.php?id=" + yes2.id;
}
function deletenewformShow() {
    header.innerHTML = "<p>Delete News</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "block";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditbook.style.display = "none";
    starteditnew.style.display = "none";
}
function deleteNew(id, title) {
    confirmHeader.innerHTML =
        "⚠️Are you sure you want to delete " + title + "?";
    confirm.style.display = "block";
    yes.style.display = "none";
    yes2.style.display = "block";
    yes2.id = id;
}
function startEditNew(id, title, description, photo) {
    header.innerHTML = "<p>Editing " + title + "</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditnew.style.display = "flex";
    starteditbook.style.display = "none";
    titleEdit.value = title;
    descriptionEdit.value = description;
    photoEdit2.src = photo;
    photoEdit2.style.display = "block";
    idEdit.value = id;
}
function startEditBook(title, link, id) {
    header.innerHTML = "<p>Editing " + title + "</p>";
    addnewform.style.display = "none";
    addbookform.style.display = "none";
    deleteBookform.style.display = "none";
    deletenewform.style.display = "none";
    editnewform.style.display = "none";
    editbookform.style.display = "none";
    starteditnew.style.display = "none";
    starteditbook.style.display = "flex";
    titleEditBook.value = title;
    linkEditBook.value = link;
    idEditBook.value = id;
}
function searchBook() {
    let searchText = searchBooks.value.toLowerCase();

    books.forEach((book) => {
        let bookName = book.textContent.toLowerCase();
        if (bookName.includes(searchText)) {
            book.style.display = "list-item";
        } else {
            book.style.display = "none";
        }
    });
}
function searchNew() {
    let searchText = searchNews.value.toLowerCase();

    news.forEach((onenew) => {
        let onenewName = onenew.textContent.toLowerCase();
        if (onenewName.includes(searchText)) {
            onenew.style.display = "list-item";
        } else {
            onenew.style.display = "none";
        }
    });
}
