<div class="mt-5 card">
    <div class="card-header">


       <div class="row">
           <div class="col-lg-12 margin-tb">
               <div class="pull-left">
                   <a data-toggle="modal" data-target="#surveyAdd" class="float-right text-white rounded btn btn-primary pull-left">
                       <i class="fas fa-plus"></i>
                       Add New Survey
                   </a>
               </div>
               <div class="pull-right">
                   <a class="btn btn-primary" href="{{ route('survey.index') }}"> Back</a>
               </div>
           </div>
       </div>

    </div>
    <div class="card-body">
      <table class="table table-bordered data-table">
           <thead>
               <tr>
                   <th width="5%">Id</th>
                   <th>client ID</th>
                   <th>name</th>
                   <th>desciption</th>
                   <th>finish Message</th>
                   <th>session Lifespan</th>
                   <th>Created at</th>
                   <th width="15%">Action</th>
               </tr>
           </thead>
           <tbody>
               @foreach ($surveyJoin as $surveys )
                   <tr>
                       <td>{{ $surveys->id }}</td>
                       <td>{{ $surveys->clientName }}</td>
                       <td>{{ $surveys->name }}</td>
                       <td>{{ $surveys-> description}}</td>
                       <td>{{ $surveys->finish_message }}</td>
                       <td>{{ $surveys->session_lifespan }}</td>
                       <td>{{ $surveys->created_at }}</td>
                       <td width="120">
                        {!! Form::open(['route' => ['survey.destroy', $surveys->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('survey.show', [$surveys->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('survey.edit', [$surveys->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                   </tr>
               @endforeach
           </tbody>
       </table>
   </div>

  </div>
