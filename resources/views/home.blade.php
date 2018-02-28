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
            <div class="modal-content bg-color">
                <div class="modal-body">
                    <form class="edit-event__form" method="POST" id="attendanceUpdate">
                        @csrf

                        <input name="_method" type="hidden" value="PATCH">
                        <div class="row">
                            <label class="col-md-3 col-form-label">IN</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control edit-event__inHours" name="inHours">
                                            @foreach($hours as $keyH => $hour)
                                                <option {{ $keyH }}> {{ $hour }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            :
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control edit-event__inMinutes" name="inMinutes">
                                            @foreach($minutes as $keyM => $minute)
                                                <option {{ $keyM }}> {{ $minute }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">OUT</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control edit-event__outHours" name="outHours">
                                            @foreach($hours as $keyH => $hour)
                                                <option {{ $keyH }}> {{ $hour }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            :
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control edit-event__outMinutes" name="outMinutes">
                                            @foreach($minutes as $keyM => $minute)
                                                <option {{ $keyM }}> {{ $minute }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="edit-event__id" name="id">
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('home.update', 1) }}" class="btn btn-link" id="update">Update</a>
                    <button class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- set attendance list to javascript variable -->
    <script type="text/javascript">
        var data = <?php echo json_encode($attendances); ?>;
    </script>
@endsection
