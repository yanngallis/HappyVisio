$(function () {
    var stickyElement = $(".sticky"), stickyClass = "sticky-pin", stickyPos = 64, stickyHeight;

    stickyElement.after('<div class="jumps-prevent"></div>');

    function jumpsPrevent() {
        stickyHeight = stickyElement.innerHeight();
        stickyElement.css({"margin-bottom":"-" + stickyHeight + "px"});
        stickyElement.next().css({"padding-top": + stickyHeight + "px"});
    };

    jumpsPrevent();

    $(window).on('resize', function(){
        jumpsPrevent();
    });

    function stickerFn() {
        var winTop = $(this).scrollTop();
        winTop >= stickyPos ? stickyElement.addClass(stickyClass) : stickyElement.removeClass(stickyClass);
    };

    stickerFn();

    $(window).on('scroll', function(){
        stickerFn();
    });

});

$(function () {
    $('.app-sidebar').on('scroll', function() {
        var s = $(".app-sidebar .ps__rail-y");
        if(s[0]?.style.top.split('px')[0] <= 60) {
            $('.app-sidebar').removeClass('sidebar-scroll')
        } else {
            $('.app-sidebar').addClass('sidebar-scroll')
        }
    })
});