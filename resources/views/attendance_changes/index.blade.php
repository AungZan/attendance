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
    </div>

    <div class="table-responsive position">
        <table class="table table-hover" id="productTable">
            <thead>
                <th>Name</th>
                <th>Changed In</th>
                <th>Changed Out</th>
                <th>Origin In</th>
                <th>Origin Out</th>
                <th>Actions</th>
            </thead>

            <tbody>
                @foreach($changes as $change)
                    <tr class="{{ ($change['status'] == 2)? 'bg-color':'' }}">
                        <td>{{ $change['attendance']['user']['name'] }}</td>
                        <td>{{ date('H:i', strtotime($change['origin_in'])) }}</td>
                        <td>{{ date('H:i', strtotime($change['origin_out'])) }}</td>
                        <td>{{ date('H:i', strtotime($change['attendance']['originInTime'])) }}</td>
                        <td>{{ date('H:i', strtotime($change['attendance']['originOutTime'])) }}</td>
                        <td>
                            @if($change['status'] == 0)
                                <a href="{{ route('attendance_changes.approve', $change['id']) }}" class="btn btn-success" id="accept">
                                    Accept
                                </a>
                                <a href="{{ route('attendance_changes.decline', $change['id']) }}" class="btn btn-danger"> Decline </a>

                                <form method="POST" action="{{ route('attendance_changes.decline', $change['id']) }}" id="declineForm">
                                    @csrf
                                    <input type="hidden" name="_method" value="PATCH">
                                </form>

                                <form method="POST" action="{{ route('attendance_changes.approve', $change['id']) }}" id="acceptForm">
                                    @csrf
                                    <input type="hidden" name="_method" value="PATCH">
                                </form>

                            @elseif($change['status'] == 2)
                                <a href="{{ route('attendance_changes.revoke', $change['id']) }}" class="btn btn-info" id="revoke">
                                    Revoke Decline
                                </a>

                                <form method="POST" action="{{ route('attendance_changes.revoke', $change['id']) }}" id="revokeForm">
                                    @csrf
                                    <input type="hidden" name="_method" value="PATCH">
                                </form>

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection