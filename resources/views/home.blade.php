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
                    <form class="edit-event__form">

                        <div class="row">
                            <label class="col-md-3 col-form-label">IN</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            :
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
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
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            :
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="edit-event__id">
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-link" data-calendar="update">Update</button>
                    <button class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
