$(document).ready(function(){
    // Calendar Script
    var date = new Date();
    var m = date.getMonth();
    var y = date.getFullYear();

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
        events: data,

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
            $('.edit-event__userId').val(event.user_id);
            $('.edit-event__startDate').val(event.startDate);
            $('.edit-event__originInTime').val(event.originInTime);
            $('.edit-event__in').val(event.in);

            if ((event.endDate).length) {
                $('.edit-event__endDate').val(event.endDate);
                $('.edit-event__originOutTime').val(event.originOutTime);
                $('.edit-event__out').val(event.out);
            }
        }
    });

    //Update an Event
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
});