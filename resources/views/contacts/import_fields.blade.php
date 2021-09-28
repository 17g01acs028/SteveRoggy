@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Parse contacts</h2>
        </div>
        <div class="pull-right">
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <div class="card card-primary">

      <div class="card-header">
        <h3 class="card-title">Parse CSV</h3>
      </div>

      <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
            {{ csrf_field() }}
            <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
            <input type="hidden" name="path" value="{{ $path}}" />

            <table class="table">
              <thead>
                <th>phonenumber</th>
                <th>name</th>
                <th>field_1</th>
                <th>field_2</th>
                <th>field_3</th>
              </thead>
              <tbody>
                @foreach ($csv_data as $row)
                    <tr>
                    @foreach ($row as $key => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                    </tr>
                @endforeach
                <tr>
                    <!-- @foreach ($csv_data[0] as $key => $value)
                        <td>
                            <select name="fields[{{ $key }}]">
                                @foreach (config('app.db_fields')  as $db_field)
                                    <option value="{{ $loop->index }}">{{ $db_field }}</option>
                                @endforeach
                            </select>
                        </td>
                    @endforeach -->
                </tr>
              </tbody>

            </table>
            <div class="form-group">
              <label for="group_id">Select Group to Import to</label>
              <select class="form-control select2" style="width: 100%;" name="group_id", id="group_id">
                <option></option>
                @foreach ($groups as $cl)
                <option value="{{$cl->id}}" >{{ $cl->name }}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Import Data
            </button>
        </form>
      </div>
  </div>

  </div>

</div>


@endsection
