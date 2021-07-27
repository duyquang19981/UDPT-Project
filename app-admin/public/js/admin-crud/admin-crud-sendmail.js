$(document).ready(function() {


    $(".deleteButton").on("click", function() {
        const td = $(this).closest('tr').find('td');
        $("input#id_email").val(td[0].innerHTML);
    });

});