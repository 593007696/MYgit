$(document).ready(function() {
    $("#B_year").change(function() {
        var value = $("#B_year").val();
        var birthday = new Date(value);
        var today = new Date();
        var age = Math.floor((today - birthday) / (365.25 * 24 * 60 * 60 * 1000));
        if (isNaN(age)) {
            // will set 0 when value will be NaN
            age = 0;
        } else {
            age = age;
        }
        $('#age').val(age);
    });
});