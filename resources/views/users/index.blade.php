@extends('layouts.master')

@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-info">Create New Staff</a>

    <div class="table-responsive position">
        <table class="table table-hover" id="productTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('users.destroy', $user['id']) }}" class="btn btn-danger">Delete</a>

                            <form method="POST" action="{{ route('users.destroy', $user['id']) }}">
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