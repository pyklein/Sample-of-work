function loading(str) {
    document.getElementById("loading").style.visibility = str;
    document.getElementById("grise").style.visibility = str;

    if (str == "visible") {
        document.body.style.cursor = 'wait';
        $("#grise").stop(true, true).delay(1).slideDown(1);
    }
    else {
        document.body.style.cursor = 'default';
        $("#grise").stop(true, true).delay(1).slideUp(1);
    }

}