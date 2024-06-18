$(document).foundation();

$(document).ready(function() {
    // Initially hide the navbar
    $('#navbar').addClass('hidden');

    // When scrolling, show the navbar if scrolled past the welcome section
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
        var welcomeHeight = $('#welcome').outerHeight();

        if (scrollTop > welcomeHeight) {
            $('#navbar').removeClass('hidden');
        } else {
            $('#navbar').addClass('hidden');
        }
    });
});