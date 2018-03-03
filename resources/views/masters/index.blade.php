@extends('layouts.admin')

@section('content')

    <a href="{{ route('masters.create') }}" class="btn btn-info">Create A New Master</a>

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
                @foreach($masters as $master)
                    <tr>
                        <td>{{ $master['name'] }}</td>
                        <td>{{ $master['email'] }}</td>
                        <td>
                            <a href="{{ route('masters.edit', $master['id']) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('masters.destroy', $master['id']) }}" class="btn btn-danger">Delete</a>

                            <form method="POST" action="{{ route('masters.destroy', $master['id']) }}">
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
