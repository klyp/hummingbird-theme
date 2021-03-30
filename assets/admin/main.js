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
                        if (response == 1) {
                            alert('All revisions have been purged!');
                        } else {
                            alert('Something went wrong, please contact your administrator.');
                        }
                    }
                });
            } else {
                return;
            }
        });
    });
})(jQuery);
