@extends('admin/layout/master')
@section('page-title')
    Manage Author
@endsection
@section('main-content')

<section class="content">
        <div class="box">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('role.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


<form name="formEdit" id="formEdit" method="post" action="{{ route('role.update', $role->id) }}"  enctype="multipart/form-data">
        @csrf
        @method('get')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{ $role->name }}"
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <!-- <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                {{ $value->name }}</label> -->
                <ul><input type="checkbox" name="permissions[]" value="{{ $value->id }}" {{ in_array($value->id,$rolePermissions) ? 'checked' : 'null' }}> {{$value->name}}</ul> 
            <br/>
            @endforeach

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
</div>
</section>
@endsection