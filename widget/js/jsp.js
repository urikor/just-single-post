/**
 * Posts choosing auto-complete script.
 */

(function ($) {
    $(document).ready(function () {
        var $document = $(document);
        $document.ajaxComplete(function(event, request, settings) {
            if (settings.data.indexOf('JSP_Widget') !== -1) {
                var $auto_text = $('.posts-choose');
                $auto_text.on('input', function(){
                    setTimeout(function(){
                        var data = {
                            'action': 'auto_post',
                            'choose_post': $auto_text.val()
                        };
                        jQuery.post(ajax_object.ajax_url, data, function(response) {
                            var $posts_replace = $('.posts-replace');
                            $posts_replace.addClass('border');
                            $posts_replace.html(response);
                            $('.posts-replace li').on('click', function(){
                                $auto_text.val($(this).data('id'));
                                $posts_replace.html('');
                                $posts_replace.removeClass('border');
                            });
                        });
                    }, 800);
                });
            }
        });
    });
})(jQuery);

