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

    // Calendar Script
    var date = new Date();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('.calendar').fullCalendar({
        header: {
            right: '',
            center: '',
            left: ''
        },
        buttonIcons: {
            prev: 'calendar__prev',
            next: 'calendar__next'
        },
        theme: false,
        selectable: true,
        selectHelper: true,
        editable: true,
        events: [
            {
                id: 2,
                title: 'IN : 8:00 \n OUT : 17:00',
                title1: '8:00',
                title2: '17:00',
                start: new Date(y, m, 10),
                allDay: true,
            },
        ],

        viewRender: function (view) {
            var calendarDate = $('.calendar').fullCalendar('getDate');
            var calendarMonth = calendarDate.month();

            //Set data attribute for header. This is used to switch header images using css
            $('.calendar .fc-toolbar').attr('data-calendar-month', calendarMonth);

            //Set title in page header
            $('.content__title--calendar > h1').html(view.title);
        },

        eventClick: function (event, element) {
            $('#edit-event').modal('show');
            $('.edit-event__id').val(event.id);
            $('.edit-event__title1').val(event.title1);
            $('.edit-event__title2').val(event.title2);
            // $('.edit-event__description').val(event.description);
        }
    });

    //Update/Delete an Event
    $('body').on('click', '[data-calendar]', function(){
        var calendarAction = $(this).data('calendar');
        var currentId = $('.edit-event__id').val();
        var currentTitle = $('.edit-event__title').val();
        var currentDesc = $('.edit-event__description').val();
        var currentEvent = $('.calendar').fullCalendar('clientEvents', currentId);

        //Update
        if(calendarAction === 'update') {
            if (currentTitle != '') {
                currentEvent[0].title = currentTitle;
                currentEvent[0].description = currentDesc;

                $('.calendar').fullCalendar('updateEvent', currentEvent[0]);
                $('#edit-event').modal('hide');
            }
            else {
                $('.edit-event__title').closest('.form-group').addClass('has-error');
                $('.edit-event__title').focus();
            }
        }
    });

    //Calendar Next
    $('body').on('click', '.actions__calender-next', function (e) {
        e.preventDefault();
        $('.calendar').fullCalendar('next');
    });

    //Calendar Prev
    $('body').on('click', '.actions__calender-prev', function (e) {
        e.preventDefault();
        $('.calendar').fullCalendar('prev');
    });

});

// show uploaded image show form.
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.img').attr('src', e.target.result);
            $('#frame').removeClass('not-shown').addClass('img-frame');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
