@extends('layouts.admin')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
        @csrf

        <div class="row">
            <label class="col-md-3 col-form-label">Company ID</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control {{$errors->has('company_name')? 'is-invalid' : ''}}" name="company_name" placeholder="e.g MMC" value="{{ old('company_name') }}" required>
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('company_name'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('company_name') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-3 col-form-label">Company Name</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control {{$errors->has('name')? 'is-invalid' : ''}}" name="name" placeholder="e.g Max Myanmar Construction Co. Ltd" value="{{ old('name') }}" required>
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('name'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('name') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group text-center">
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
@endsection