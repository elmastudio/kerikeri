jQuery(document).ready(function($) {
    $('#colorpicker1').hide();
    $('#colorpicker1').farbtastic('#link-color');

    $('#link-color').click(function() {
        $('#colorpicker1').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker1').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker2').hide();
    $('#colorpicker2').farbtastic('#widgetbackground-color');

    $('#widgetbackground-color').click(function() {
        $('#colorpicker2').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker2').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker3').hide();
    $('#colorpicker3').farbtastic('#hover-color');

    $('#hover-color').click(function() {
        $('#colorpicker3').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker3').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker4').hide();
    $('#colorpicker4').farbtastic('#topborder-color');

    $('#topborder-color').click(function() {
        $('#colorpicker4').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker4').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});