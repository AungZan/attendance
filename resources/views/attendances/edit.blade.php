@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('attendances.update', $attendance['id']) }}">
        @csrf

        <input type="hidden" name="_method" value="PATCH">

        <input type="hidden" name="id" value="{{ $attendance['id'] }}">

        <input type="hidden" name="user_id" value="{{ $attendance['user_id'] }}">

        <div class="row">
            <label class="col-md-3 col-form-label">Name</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" value="{{ $attendance['user']['name'] }}" disabled>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Origin Check In Time</label>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::date('inDate', $attendance['startDate'], ['class' => 'form-control', 'format' => 'Y-m-d']) }}
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('inDate'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('inDate') }}</strong>
                    </p>
                @endif
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::time('origin_in_time', $attendance['originInTime'], ['class' => 'form-control']) }}
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('origin_in_time'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('origin_in_time') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Origin Check Out Time</label>
            <div class="col-md-3">
                <div class="form-group">
                    {{
                        Form::date('outDate', !empty($attendance['endDate'])? $attendance['endDate'] : '', ['class' => 'form-control'])
                    }}
                    <i class="form-group__bar"></i>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{
                        Form::time('origin_out_time', !empty($attendance['originOutTime'])? $attendance['originOutTime'] : '', ['class' => 'form-control'])
                    }}
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Check In Time</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="in" value="{{ date('Y/m/d H:i', strtotime($attendance['in'])) }}" disabled>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Check Out Time</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="out" value="{{ !empty($attendance['out'])? date('Y/m/d H:i', strtotime($attendance['out'])) : '' }}" disabled>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Working Time</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="normal" value="{{ $attendance['normal'] }}" disabled>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Overtime</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="overtime" value="{{ $attendance['overtime'] }}" disabled>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection