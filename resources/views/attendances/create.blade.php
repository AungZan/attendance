@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('attendances.store') }}">
        @csrf

        <div class="row">
            <label class="col-md-3 col-form-label">Name</label>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="select">
                        <select class="form-control select2" name="user_id">
                            @foreach($staffs as $key => $staff)
                                <option value="{{ $key }}">{{ $staff }}</option>
                            @endforeach
                        </select>
                    </div>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Origin Check In Time</label>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::date('inDate', '', ['class' => 'form-control', 'required' => true]) }}
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
                    {{ Form::time('origin_in_time', '', ['class' => 'form-control', 'required' => true]) }}
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
                    {{ Form::date('outDate', '', ['class' => 'form-control']) }}
                    <i class="form-group__bar"></i>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{ Form::time('origin_out_time', '', ['class' => 'form-control']) }}
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>
@endsection

