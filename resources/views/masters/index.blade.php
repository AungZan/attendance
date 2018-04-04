@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-8">
            <a href="{{ route('masters.create') }}" class="btn btn-info">Create A New Master</a>
        </div>

        <div class="col-4">
            <form class="search" method="GET" action="{{ route('masters.index') }}">
                <div class="row">
                    <div class="results__search">
                        <input type="text" name="search">
                    </div>
                    <button class="btn btn-light btn--icon-text" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

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
                            <a href="{{ route('masters.edit', $master['id']) }}" class="btn btn-primary positionButton">Edit</a>
                            <a href="{{ route('masters.destroy', $master['id']) }}" class="btn btn-danger positionButton">Delete</a>

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

    <div class="row justify-content-around">
        <div class="col-3">
            {{ $masters->links() }}
        </div>
    </div>
@endsection
