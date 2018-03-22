@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('settings.update', $setting->id) }}">
        @csrf

        <input type="hidden" name="_method" value="PATCH">

        <div class="row">
            <label class="col-md-2 col-form-label">Check In Time</label>

            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::time('check_in', $setting->check_in, ['class' => 'form-control', 'required' => true]) }}
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('check_in'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('check_in') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Check Out Time</label>

            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::time('check_out', $setting->check_out, ['class' => 'form-control', 'required' => true]) }}
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('check_out'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('check_out') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Working Hours</label>

            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="working_hours" class="form-control" value="{{ $setting->working_hours }}" required>
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('working_hours'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('working_hours') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Break Hours</label>

            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="break_time" class="form-control" value="{{ $setting->break_time }}" required>
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('break_time'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('break_time') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Round Time</label>

            <div class="col-md-2">
                <div class="form-group">
                    <div class="select">
                        <select class="form-control" name="round_time">
                            @foreach($roundTimes as $val)
                                <option value="{{ $val }}" {{ ($val == $setting['round_time'])? 'selected':'' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <a href="" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection