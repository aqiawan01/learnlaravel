@extends('admin/layout/master')
@section('page-title')
    Manage User
@endsection
@section('main-content')

<section class="content">
        <div class="box">
            <div class="box-header with-border">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users List</h2>
        </div>
       @can('user-create')
        <div class="pull-right">
            <a class="btn btn-success" href="/admin/user/create"> Create New User</a>
        </div>
       @endcan
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
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-light">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <!-- <a class="btn btn-info" href="{{ route('user.show',$user->id) }}">Show</a> -->
       @can('user-edit')
       <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}">Edit</a>
       @endcan
       @can('user-delete')
        {!! Form::open(['method' => 'GET','route' => ['user.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
        @endcan
       
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}



</div>
</section>
@endsection