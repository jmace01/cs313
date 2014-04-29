function showPopup(content) {
    document.getElementById("backdrop").style.display = 'block';
    document.getElementById("popup").style.display = 'block';
    document.getElementById("popup").innerHTML = content;
}

function hidePopup() {
    document.getElementById("backdrop").style.display = 'none';
    document.getElementById("popup").style.display = 'none';
}
