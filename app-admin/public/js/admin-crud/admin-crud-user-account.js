$(document).ready(function() {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $(".changestatus").on("click", function() {
        const td = $(this).closest('tr').find('td');
        const _id = td[0].innerHTML;
        const stutus = td[4].innerHTML;
        const user_input_id = $('#user_input_id');
        const status = $('#status');
        user_input_id[0].value = _id;
        status[0].value = stutus;
    });


});