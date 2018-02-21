@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('masters.update', $master['id']) }}" class="form-horizontal">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="{{ $master['id'] }}">

        <div class="row">
            <label class="col-md-2 col-form-label">Company Name</label>

            <div class="col-sm-5">
                <div class="form-group">
                    <div class="select">
                        <select class="form-control" name="company_id">
                            @foreach($companies as $company => $key)
                                <option value="{{ $key }}" {{ ($key == $master['company_id'])? 'selected': '' }}>
                                    {{ $company }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Name</label>

            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" value="{{ $master['name'] }}" placeholder="e.g John Smith">
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('name'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('name') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Email</label>

            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" name="email" class="form-control" value="{{ $master['email'] }}" placeholder="e.g abc@mail.com">
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('email'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('email') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Password</label>

            <div class="col-md-5">
                <div class="form-group">
                    <input type="password" name="password" class="form-control">
                    <i class="form-group__bar"></i>
                </div>

                @if($errors->has('password'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('password') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group text-center">
            <a href="{{ route('masters.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection