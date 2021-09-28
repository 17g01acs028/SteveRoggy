@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Sender Price</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sender_prices.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Sender Price</h3>
      </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sender_prices.update',$sender_price->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
         <div class="form-group">
            <label for="client_id">Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id">
              <option value=""></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" {{ $sender_price->client_id == $cl->id ? 'selected' : old('client_id') }} >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="sender_id">Sender Name</label>
            <select class="form-control select2" style="width: 100%;" name="sender_id", id="sender_id">
              <option value=""></option>
              @foreach ($senders as $cl)
              <option value="{{$cl->id}}" {{ $sender_price->sender_id == $cl->id ? 'selected' : old('sender_id') }} >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price per SMS</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Price per SMS"
            value = "{{ $sender_price->price ? : old('price') }}">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Description"
            value = "{{ $sender_price->description ? : old('description') }}">
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>

</div>


@endsection
