$(document).ready(function() {

    // data tables
    $('#productTable').dataTable({
        sFilter: false,
        bFilter: false,
        bLengthChange: false
    });

    // change theme
    $('#change-theme').on('click', function() {
console.log($(this).attr('data-sa-value'));
    });

    // destroy form submit
    $('.btn-danger').on('click', function(event) {
        event.preventDefault();
        $(this).next().submit();
    });

    // admin logout form submit
    $('#logout').on('click', function(e) {
        e.preventDefault();
        $('#admin').submit();
    });

    // user side attendance form submit
    $('#update').on('click', function(e) {
        e.preventDefault();
        var id = $(this).parents('.modal-content').children().find('.edit-event__id').val();
        $('#attendanceUpdate').attr('action', '/home/' + id);
        $('#attendanceUpdate').submit();
    });

    // select2 for attendance add
    $('select2').select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    // date picker for attendance index
    if($('.date-picker')[0]) {
        $('.date-picker').flatpickr({
            enableTime: false,
            nextArrow: '<i class="zmdi zmdi-long-arrow-right" />',
            prevArrow: '<i class="zmdi zmdi-long-arrow-left" />',
            onChange: function(dateObj, dateStr) {

                oldURL = window.location.href;

                if (oldURL.indexOf('=') == -1) {
                    newURL = oldURL + '?date=' + dateStr;
                } else {
                    oldURL = oldURL.split('=')[0];
                    newURL = oldURL + '=' + dateStr;
                }

                window.history.pushState('obj', 'Attendance System', newURL);
                location.reload();
            }
        });
    }
});

// show uploaded image show form.
function readImageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.img').attr('src', e.target.result);
            $('#frame').removeClass('not-shown').addClass('img-frame');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
