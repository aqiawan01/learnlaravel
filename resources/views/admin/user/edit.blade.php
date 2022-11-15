@extends('admin/layout/master')
@section('page-title')
    Manage user
@endsection
@section('main-content')

<section class="content">
        <div class="box">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit  User</h2>
        </div>
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


<form name="formEdit" id="formEdit" method="post" action="{{ route('user.update', $user->id) }}"  enctype="multipart/form-data">
        @csrf
        @method('get')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
             <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{ $user->name }}">
        </div>
        
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
             <input type="email" name="email" class="form-control" id="email" placeholder="email" value="{{ $user->email }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
             <input type="password" name="password" class="form-control" id="password" placeholder="password" value="{{ $user->password }}">
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles" id="" class="form-control">
                <option value="">Select a role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"{{ in_array($role->name,$userRole) ? 'selected' : '' }}>{{ $role->name }}</option>
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