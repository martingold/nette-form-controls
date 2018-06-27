$(function() {

    // RadioButton
    $('.form-group input[checked]').parent().addClass('active');

    // DatePicker and DateRange
    $('input.datepicker, .input-daterange').datepicker({
        format: 'd.m.yyyy',
        language: 'cs'
    });

    // Wysiwyg
    $('.wysiwyg').trumbowyg({
        'lang': 'cs'
    });

})