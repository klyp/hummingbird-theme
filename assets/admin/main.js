(function($) {
    'use strict';
    $(function() {
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

        $('#klyp-purge-logs').on('click', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to purge logs that are older than specified days?\nWARNING YOU CANNOT UNDO THIS ACTION')) {
                var nonce = $(this).data('nonce'),
                    adminUrl = $(this).data('admin-url');

                $.ajax({
                    type: 'post',
                    url: adminUrl,
                    data: {
                        action: 'klyp_clean_up_logs',
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

        $('.klyp-modal__open').on('click', function(e) {
            e.preventDefault();
            $('.klyp-modal').addClass('active');
        });

        $('.klyp-modal__close').on('click', function(e) {
            e.preventDefault();
            $('.klyp-modal').removeClass('active');
        });

        $('.klyp-import-components').on('click', function(e) {
            e.preventDefault();
            
            var target = $(this).data('target');

            $('#klyp-import-page-id').val(target);
        });
    });
})(jQuery);
