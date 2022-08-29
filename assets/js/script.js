function volumeToggle(button){
    var muted = $(".previewVideo").prop("muted");//select previewvideo class in video tag.
    $(".previewVideo").prop("muted",!muted);// unmute if muted.

    $(button).find("i").toggleClass("fa-solid fa-volume-xmark");//remove muted icon from class list
    $(button).find("i").toggleClass("fa-solid fa-volume-high");//switch icon to volume up
}

function previewHasEnded(){
    $(".previewVideo").toggle();// will show when the page loads and hide after video ends.
    $(".previewImage").toggle();// is hidden when the page loads, will togglr when the video ends.
}

function goBack(){
    window.history.back();
}

function startHideTimer(){
    var timeout = null;

    $(document).on("mousemove",()=>{// when the user moves the mouse on the page.
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(()=>{
            $(".watchNav").fadeOut();
        },2000);
    })
}

function initVideo(){
    startHideTimer();
}