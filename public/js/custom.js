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

    $('select2').select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    // Calendar Script
    // var date = new Date();
    // var m = date.getMonth();
    // var y = date.getFullYear();

    // //Calendar Next
    // $('body').on('click', '.actions__calender-next', function (e) {
    //     e.preventDefault();
    //     $('.calendar').fullCalendar('next');
    // });

    // //Calendar Prev
    // $('body').on('click', '.actions__calender-prev', function (e) {
    //     e.preventDefault();
    //     $('.calendar').fullCalendar('prev');
    // });

    // $('.calendar').fullCalendar({
    //     header: {
    //         right: '',
    //         center: '',
    //         left: ''
    //     },
    //     buttonIcons: {
    //         prev: 'calendar__prev',
    //         next: 'calendar__next'
    //     },
    //     theme: false,
    //     selectable: true,
    //     selectHelper: true,
    //     editable: true,
    //     events: data,

    //     viewRender: function (view) {
    //         var calendarDate = $('.calendar').fullCalendar('getDate');
    //         var calendarMonth = calendarDate.month();

    //         //Set data attribute for header. This is used to switch header images using css
    //         $('.calendar .fc-toolbar').attr('data-calendar-month', calendarMonth);

    //         //Set title in page header
    //         $('.content__title--calendar > h1').html(view.title);
    //     },

    //     eventClick: function (event, element) {
    //         $('#edit-event').modal('show');
    //         $('.edit-event__id').val(event.id);
    //         $('.edit-event__inHours').val(event.inHours);
    //         $('.edit-event__inMinutes').val(event.inMinutes);

    //         if ((event.outHours).length) {
    //             $('.edit-event__outHours').val(event.outHours);
    //             $('.edit-event__outMinutes').val(event.outMinutes);
    //         }
    //     }
    // });

    // //Update an Event
    // $('body').on('click', '[data-calendar]', function(){
    //     var calendarAction = $(this).data('calendar');
    //     var currentId = $('.edit-event__id').val();
    //     var currentTitle = $('.edit-event__title').val();
    //     var currentDesc = $('.edit-event__description').val();
    //     var currentEvent = $('.calendar').fullCalendar('clientEvents', currentId);

    //     //Update
    //     if(calendarAction === 'update') {
    //         if (currentTitle != '') {
    //             currentEvent[0].title = currentTitle;
    //             currentEvent[0].description = currentDesc;

    //             $('.calendar').fullCalendar('updateEvent', currentEvent[0]);
    //             $('#edit-event').modal('hide');
    //         }
    //         else {
    //             $('.edit-event__title').closest('.form-group').addClass('has-error');
    //             $('.edit-event__title').focus();
    //         }
    //     }
    // });
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
