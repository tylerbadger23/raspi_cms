let cancelBtn = document.getElementById("close_trigger");
let sumbitFormBtn = document.getElementById("submit-btn");

let state = false; // state is uysed to check if submit has started request
let cancelCompleted = null;

sumbitFormBtn.addEventListener("click" , function() {
    $state = true;
});

if(state == true) {
    console.log("state true");
}

cancelBtn.addEventListener("click", function() {
    if(state == false) {
        //ignore request to cazncel and cancel like normal
        console.log("canceled request to server submit modal upload file.");
    } else {
        try {
            window.location.reload();
        } catch {
            window.location.href = window.location.href; // if first reload fails then reload twice again
        }// reload page
    }

});
