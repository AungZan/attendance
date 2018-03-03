@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('users.update', $user['id']) }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="{{ $user['id'] }}">

        <div class="row">
            <label class="col-md-2 col-form-label">Name</label>

            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" value="{{ $user['name'] }}" placeholder="e.g David">
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
                    <input type="email" name="email" class="form-control" value="{{ $user['email'] }}" placeholder="e.g abc@mail.com">
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

            @php
                if(empty($user['image'])) {
                    $imageClass = 'not-shown';
                } else {
                    $imageClass = 'img-frame';
                }
            @endphp

            <div class="col-md-5">
                <div class="{{ $imageClass }}" id="frame">
                    <img src="/img/staff/{{ $user['image'] }}" class="img">
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
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection