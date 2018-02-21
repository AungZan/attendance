@extends('layouts.admin')

@section('content')

    <a href="{{ route('companies.create') }}" class="btn btn-info">Create A New Company</a>
    <div class="table-responsive position">
        <table class="table table-hover" id="productTable">
            <thead>
                <tr>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company['company_name'] }}</td>
                        <td>{{ $company['name'] }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company['id']) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('companies.destroy', $company['id']) }}" id="deleteCom" class="btn btn-danger">Delete</a>

                            <form method="POST" action="{{ route('companies.destroy', $company['id']) }}" id="company" style="display: none;">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
