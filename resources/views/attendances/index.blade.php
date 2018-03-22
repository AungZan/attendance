@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                <div class="form-group">
                    <input type="text" class="form-control date-picker" placeholder="{{ $date }}">
                </div>
            </div>
        </div>

        <div class="col-md-8 text-right">
            <a href="{{ route('attendances.create') }}" class="btn btn-info">Create A New Attendance</a>
        </div>
    </div>

    <div class="table-responsive position">
        <table class="table table-hover" id="productTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Origin Check In</th>
                    <th>Origin Check Out</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance['user']['name'] }}</td>
                        <td>{{ date('H:i', strtotime($attendance['origin_in'])) }}</td>
                        <td>
                            {{
                                (!empty($attendance['origin_out']))? date('H:i', strtotime($attendance['origin_out'])) : ''
                            }}
                        </td>
                        <td>{{ date('H:i', strtotime($attendance['in'])) }}</td>
                        <td>
                            {{
                                (!empty($attendance['out']))? date('H:i', strtotime($attendance['out'])) : ''
                            }}
                        </td>
                        <td>
                            <a href="{{ route('attendances.edit', $attendance['id']) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('attendances.destroy', $attendance['id']) }}" class="btn btn-danger">Delete</a>

                            <form method="POST" action="{{ route('attendances.destroy', $attendance['id']) }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection