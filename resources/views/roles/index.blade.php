@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">Role Management
                  @can('role-create')
                  <a class="btn btn-success ml-5" href="{{ route('roles.create') }}"> Create New Role</a>
                  @endcan
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered">
             <tr>
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>
             </tr>
               @foreach ($roles as $key => $role)
               <tr>
                   <td>{{ ++$i }}</td>
                   <td>{{ $role->name }}</td>
                   <td>
                       <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                       @can('role-edit')
                           <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                       @endcan
                       @can('role-delete')
                           {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                               {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                           {!! Form::close() !!}
                       @endcan
                   </td>
               </tr>
               @endforeach
           </table>


           {!! $roles->render() !!}
        </div>

       </div>
     </div>
   </div>
 </div>
</body>

@endsection
