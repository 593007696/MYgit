$(function() {
    $("#button").bind("click", function() {

        var service_flg;
        var service_name;

        service_flg = $("#service_flg").val();

        service_name = $("#service_name").val();

        re = new RegExp(service_flg);

        re2 = new RegExp(service_name);

        $("#myTable tbody tr").each(function() {
            var txt = $(this).find("td").text();
            if (txt.match(re) != null) {

                if (txt.match(re2) != null) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).hide();
            }
        });
    });

});