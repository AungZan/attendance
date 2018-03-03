@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <label class="col-md-2 col-form-label">Name</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control {{$errors->has('name')? 'is-invalid' : ''}}" name="name" placeholder="e.g David" value="{{ old('name') }}" required>
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
                    <input type="email" class="form-control {{$errors->has('email')? 'is-invalid' : ''}}" name="email" placeholder="e.g abc@gmail.com" value="{{ old('email') }}" required>
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
            <label class="col-md-2 col-form-label">Profile Picture</label>

            <div class="col-md-5">
                <div class="not-shown" id="frame">
                    <img src="" class="img">
                </div>

                <div class="form-group">
                    <input type="file" name="image" class="form-control imageUpload" accept="image/*" onchange="readImageUpload(this);">
                </div>

                @if($errors->has('image'))
                    <p class="validation-fails">
                        <strong>{{ $errors->first('image') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-md-2 col-form-label">Password</label>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="password" class="form-control {{$errors->has('password')? 'is-invalid' : ''}}" name="password" value="{{ old('password') }}" required>
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
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
@endsection