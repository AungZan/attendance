@extends('layouts.master')

@section('content')
    <a href="{{ route('attendances.create') }}" class="btn btn-info">Create A New Attendance</a>

    <div class="table-responsive position">
        <table class="table table-hover" id="productTable">
            <thead>
                <tr>
                    <th>Name</th>
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