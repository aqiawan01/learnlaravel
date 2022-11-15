@extends('admin/layout/master')
@section('page-title')
  Edit Category
@endsection
@section('main-content')
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <!-- form start -->
      <form name="formEdit" id="formEdit" method="post" action="/admin/category/{{ $category->id }}">
        @csrf
        @method('put')
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <!-- row start -->
          <div class="row"> 
                <div class="col-xs-6">
                  
                  <div class="form-group">
                    <label for="title">name <span class="text text-red">*</span></label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{ $category->name }}">
                    </div>

                    <div class="form-group">
                    <label for="slug">Slug <span class="text text-red">*</span></label>
                      <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug" value="{{ $category->slug }}">
                    </div>
                    <div class="form-group">
                    <label>Select parent category*</label>
                        <select type="text" name="parent_id" class="form-control">
                            <option value="">None</option>
                                @if($categories)
                                  @foreach($categories as $category)
                                      <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                               @endif
                                    </select>
                  </div>
                    <div class="form-group">
                      <label for="category_img">category Image <span class="text text-red">*</span></label>
                      <input type="file" name="category_img" class="form-control" id="category_img">
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter ...">{{ $category->description }}</textarea>
                     </div>
                </div>
            </div>
              <!-- row end -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/admin/category" class="btn btn-danger">Cancel</a>
          </div>
      </div>
      <!-- /.box -->
      </form>
      <!-- form end -->

    </section>
    @endsection