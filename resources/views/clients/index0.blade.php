@extends('clients.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>My Laravel App</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('clients.create') }}"> Create New Client</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Client Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Account Type</th>
            <th>Account Balance</th>
            <th>Account Status</th>
            <th>HTTP Dlr Url</th>
            <th>HTTP Method</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($clients as $client)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $client->clientName }}</td>
            <td>{{ $client->clientAddress }}</td>
            <td>{{ $client->mobileNo }}</td>
            <td>{{ $client->accType }}</td>
            <td>{{ $client->accBalance }}</td>
            <td>{{ $client->accStatus }}</td>
            <td>{{ $client->httpDlrUrl }}</td>
            <td>{{ $client->dlrHttpMethod }}</td>
            <td>
                <form action="{{ route('clients.destroy',$client->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('clients.show',$client->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('clients.edit',$client->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $clients->links() !!}

@endsection
