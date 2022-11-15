@extends('admin/layout/master')
@section('page-title')
    Create User
@endsection
@section('main-content')
<section class="content">
        <div class="box">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <!-- <div class="pull-left">
            <h2>Create New User</h2>
        </div> -->
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('user.index') }}"> Back</a>
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

<form name="formCreate" id="formCreate" method="get" action="{{ route('user.store') }}" enctype="multipart/form-data">
      	@csrf

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles" id="" class="form-control">
			    <option value="">Select a role</option>
			    @foreach($roles as $role)
			        <option value="{{ $role->id }}">{{ $role->name }}</option>
			    @endforeach
			</select>
            
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