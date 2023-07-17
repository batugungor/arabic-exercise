window.onload = function () {
    setTimeout(function () {
        document.getElementById("fadein").remove();
    }, 1000);
};

$(window).on('load', function () {
    $("#loader-wrapper").fadeOut(700);
});
