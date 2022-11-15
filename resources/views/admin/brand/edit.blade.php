@extends('admin/layout/master')
@section('page-title')
  Create brand
@endsection
@section('main-content')
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <!-- form start -->
      <form name="formEdit" id="formEdit" method="post" action="/admin/brand/{{ $brand->id }}" enctype="multipart/form-data">
        @csrf
        @method('put')
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div>
            @endif 
          <!-- row start -->
          <div class="row"> 
                <div class="col-xs-6">
                  
                 <div class="form-group">
                    <label for="title">Title <span class="text text-red">*</span></label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{{ $brand->title }}">
                    </div>
                    <div class="form-group">
                    <label for="slug">Slug <span class="text text-red">*</span></label>
                      <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug"value="{{ $brand->slug }}">
                    </div>            
                    <div class="form-group">
                      <label for="brand_img">brand Image</label>
                      <input type="file" class="form-control" name="brand_img" id="brand_img" >
                      <small class="label label-warning">Cover Photo will be uploaded</small>
                    </div>
                    <div class="form-group">
                      <label for="description">Description <span class="text text-red">*</span></label>
                      <textarea class="form-control" name="description" rows="5" id="description" placeholder="Description">{{ $brand->description }}</textarea>
                    </div>
                     
                </div>
            </div>

              <!-- row end -->

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/admin/brand" class="btn btn-danger">Cancel</a>
          </div>
      </div>
      <!-- /.box -->
     </form>
      <!-- form end -->

    </section>
@endsection