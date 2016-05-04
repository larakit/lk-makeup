$(document).ready(function () {
    function refr(){
        document.location.href = $('.page-selector').val()
        +'?theme=' + $('.theme-selector.active').attr('data-value')
        +'&breakpoint=' + $('.breakpoint-selector.active').attr('data-value')
        ;
    }
    $('.disp-select').on('change', refr);
    $('.disp-btn').on('click', function(){
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        refr();
    });
    $('.js-frame')
        .on('click', function () {
            $('.js-frame').removeClass('js-current');
            $(this).addClass('js-current');
        })
        .first()
        .trigger('click');

    $('.js-size')
        .on('click', function () {
            var $this = $(this),
                w = parseInt($this.attr('data-w')),
                w_w = $(window).width(),
                $frame = $('iframe'),
                $size_btns = $('.js-size');
            if ($this.hasClass('js-current')) {
                return false;
            }
            if (!isNaN(w) && w > 0) {
                $frame.css('width', w);
            } else {
                $frame.css('width', w_w);
            }
            $size_btns.removeClass('js-current');
            $this.addClass('js-current');
            return false;
        });

    $('.js-size:first').trigger('click');

});

