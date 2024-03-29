$(document).ready(function () {

    // function to detect element is viewable on viewport
    $.fn.isOnScreen = function(){
        var win = $(window);
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();
        
        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
        
        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };

    $(window).bind('load scroll', function() {
        if ($('.klypComponents').length) {
            $('.klypComponents').each(function() {
                let theComponent = $(this);
                
                if ($(this).isOnScreen() == true && ! $(this).hasClass('loaded')) {
                    $.ajax({
                        type: 'post',
                        url: $(this).data('ajax'),
                        data: {
                            action: 'klyp_load_component',
                            data: $(this).data('component'),
                            nonce: $(this).data('nonce'),
                        },
                        beforeSend: function () {
                            theComponent.addClass('loaded');
                        },
                        success: function (response) {
                            theComponent.replaceWith(response);
                        },
                        error: function () {
                            theComponent.removeClass('loaded');
                        }
                    });

                    // remove preloader
                    if ($('.site-preloader').length) {
                        $('.site-preloader').remove();
                    }
                }
            })
        }

        // contact form 7 fixes
        if ($('form.wpcf7-form:not(.initialized)').length) {
            $('form.wpcf7-form:not(.initialized)').each(function() {
                var action = $(this).attr('action');
                action = action.substring(action.indexOf('#'));
                $(this).attr('action', action);
                $(this).addClass('initialized');
                
                wpcf7.init($(this)[0]);
            });
        }
    });
});
