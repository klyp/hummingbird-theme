(function($)
{
    'use strict';
    $(function()
    {
        $('#klyp-purge-revisions').on('click', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to purge ALL revisions?\nWARNING YOU CANNOT UNDO THIS ACTION')) {
                var nonce = $(this).data('nonce'),
                    adminUrl = $(this).data('admin-url');

                $.ajax({
                    type: 'post',
                    url: adminUrl,
                    data: {
                        action: 'klyp_clean_up_revisions',
                        nonce: nonce
                    },
                    success: function(response) {
                        alert(response.data.message);
                    }
                });
            } else {
                return;
            }
        });

        $(document).on('click', '.hb-log__data', function() {           
            // var theContent = JSON.parse($(this).parent().find('.klyp-modal .klyp-modal__content--log').html());
            var theContent = $(this).parent().find('.klyp-modal .klyp-modal__content--log').html();
            // $(this).parent().find('.klyp-modal .klyp-modal__content--log').html(JSON.stringify(theContent, null, '\t'));
            $(this).parent().find('.klyp-modal .klyp-modal__content--log').html(theContent);
            $(this).parent().find('.klyp-modal').toggleClass('show');
        });

        $('.klyp-modal').on('click', function() {
            $(this).removeClass('show');
        });
    });
})(jQuery);
