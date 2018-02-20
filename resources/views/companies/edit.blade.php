@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('companies.update', $company['id']) }}" class="form-horizontal">
        @csrf

        <input name="_method" type="hidden" value="PATCH">
        <input name="id" type="hidden" value="{{ $company['id'] }}">

        <div class="row">
            <label class="col-md-3 col-form-label">Company ID</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control {{$errors->has('company_name')? 'is-invalid' : ''}}" name="company_name" placeholder="e.g MMC" value="{{ $company['company_name'] }}" required>
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
                    <input type="text" class="form-control {{$errors->has('name')? 'is-invalid' : ''}}" name="name" placeholder="e.g Max Myanmar Construction Co. Ltd" value="{{ $company['name'] }}" required>
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