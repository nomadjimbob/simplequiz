

jQuery().ready(function () {
    jQuery('.simplequiz_reveal').on('click', function (event) {
        event.preventDefault();

        jQuery('input[type="radio"][name^="simplequiz_group_"]').each(function() {
            if (jQuery(this).is(':checked')) {
                var score = jQuery(this).data('score');
                var groupName = jQuery(this).attr('name').substring('simplequiz_group_'.length);

                jQuery('.simplequiz_reveal[data-group='+groupName+'] .simplequiz_reveal_value').text(score);
            }
        });

        jQuery('.simplequiz_reveal .simplequiz_reveal_value').each(function() {
            if (!jQuery.trim(jQuery(this).text())) {
                jQuery(this).text("No value selected");
            }
        });
    });
});
