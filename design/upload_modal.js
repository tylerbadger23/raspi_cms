
var upload_modal = document.getElementById("uploadModal");

// Get the button that opens the modal
var upload_btn = document.getElementById("upload-file-btn");

// Get the <span> element that closes the modal
var close = document.getElementById("close");

var hideBar = document.getElementById("logo");

// When the user clicks on the button, open the modal
upload_btn.onclick = function() {
  upload_modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
close.onclick = function() {
  upload_modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == upload_modal) {
    upload_modal.style.display = "none";
  }
}