//pokaze edit reviewa
function showEdit(id) {
    document.getElementById("review-view-" + id).style.display = "none";
    document.getElementById("review-edit-" + id).style.display = "block";
}

//skrije edit reviewsa
function hideEdit(id) {
    document.getElementById("review-edit-" + id).style.display = "none";
    document.getElementById("review-view-" + id).style.display = "block";
}

//da se povečuje velikost text area z vsebino
function autoGrow(textarea) {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}

//da se spremeni preview posterja live
function previewPoster() {
    let preview = document.getElementById("image_preview");
    let url = document.getElementById("url").value;
    
    preview.onerror = function () {
        this.onerror = null;
        // Preberemo pot, ki smo jo pripravili v HTML-ju - relativna od assests urlja
        this.src = this.getAttribute("data-default");
    };
    preview.src = url;
}