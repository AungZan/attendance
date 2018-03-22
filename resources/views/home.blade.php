@extends('layouts.user')

@section('content')
    <header class="content__title content__title--calendar">

        <h1>Calendar</h1>

        <div class="actions actions--calendar">
            <a href="" class="actions__item actions__calender-prev"><i class="zmdi zmdi-long-arrow-left"></i></a>
            <a href="" class="actions__item actions__calender-next"><i class="zmdi zmdi-long-arrow-right"></i></a>
        </div>
    </header>

    <div class="calendar card"></div>

    <!-- Edit event -->
    <div class="modal fade" id="edit-event" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="edit-event__form" method="POST" id="attendanceUpdate">
                        @csrf

                        <input name="_method" type="hidden" value="PATCH">

                        <input type="hidden" class="edit-event__id" name="id">
                        <input type="hidden" class="edit-event__userId" name="user_id">

                        <div class="row">
                            <label class="col-md-3 col-form-label">IN</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{
                                        Form::date('inDate', '', [
                                            'class' => 'form-control edit-event__startDate',
                                            'name' => 'inDate'
                                        ])
                                    }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{
                                        Form::time('origin_in_time', '', [
                                            'class' => 'form-control edit-event__originInTime',
                                            'name' => 'origin_in_time'
                                        ])
                                    }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">OUT</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{
                                        Form::date('outDate', '', [
                                            'class' => 'form-control edit-event__endDate',
                                            'name' => 'outDate'
                                        ])
                                    }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{
                                        Form::time('origin_out_time', '', [
                                            'class' => 'form-control edit-event__originOutTime',
                                            'name' => 'origin_out_time'
                                        ])
                                    }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">ROUND IN</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="in" class="form-control edit-event__in" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">ROUND OUT</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="out" class="form-control edit-event__out" disabled>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-link" data-dismiss="modal">Close</button>
                    <a href="{{ route('home.update', 1) }}" class="btn btn-link" id="update">Update</a>
                </div>
            </div>
        </div>
    </div>

    <!-- set attendance list to javascript variable -->
    <script type="text/javascript">
        var data = <?php echo json_encode($attendances); ?>;
    </script>
@endsection
