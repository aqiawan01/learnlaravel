@extends('admin/layout/master')
@section('page-title')
  Manage brand
@endsection
@section('main-content')
  <section class="content">
      
      <!-- /.row -->
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
                <a id="activeAllStatus" url="{{ route('brand.statusActive')}}" class="btn btn-danger btn-xm"><i class="fa fa-eye"></i></a>
                <a id="deactiveAllStatus" url="{{ route('brand.statusDeactive')}}" class="btn btn-danger btn-xm"><i class="fa fa-eye-slash"></i></a>
                <a id="deleteAll" url="{{ route('brand.deleteAll')}}" class="btn btn-danger btn-xm"><i class="fa fa-trash"></i></a>
                <a href="/admin/brand/create" class="btn btn-default btn-xm"><i class="fa fa-plus"></i></a>  
          </h3>
          <div class="box-tools">
            <form method="get" action="/admin/brand">
            <div class="input-group input-group-sm" style="width: 250px;">
              <input type="text" name="s" class="form-control pull-right" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @if($brands)
          <table class="table table-bordered">
            <thead style="background-color: #F8F8F8;">
              <tr>
                <th width="4%"><input type="checkbox" name="" id="checkAll"></th>
                <th width="30%">Title</th>
                
                <th width="15%">Category</th>
                <th width="20%">brand Image</th>
                <th width="10%">Status</th>
                <th width="10%">Manage</th>
              </tr>
            </thead>
            @foreach($brands as $brand)
            <tr>
              <td><input type="checkbox" name="statusAll[]" value="{{ $brand->id }}" id="" class="checkSingle"></td>
              <td>{{ $brand->title }}</td>
              
              <td>Image</td>
              <td>@if($brand->brand_img == 'No image found')
                <img src="/assets/admin/dist/img/no-img.png" width="100" height="100" class="img-thumbnail" alt="NO image found">
                @else
                <img src="/uploads/{{ $brand->brand_img}}" width="100" height="100" class="img-thumbnail" alt="{{ $brand->title}}">
                @endif
              </td>
              <td>
               
                <form method="post" action="/admin/brand/{{ $brand->id }}/status">
                  @csrf
                @method('put')
                @if($brand->status == 'DEACTIVE')
                <button class="btn btn-danger btn-sm singleStatus"><i class="fa fa-thumbs-down"></i></button>
                @else
                <button class="btn btn-info btn-sm singleStatus"><i class="fa fa-thumbs-up"></i></button>
                @endif
                </form>
                
              </td>
              <td>
                
                <form method="post" action="/admin/brand/{{ $brand->id }}">
                @csrf
                @method('delete')
                
                  <a href="/admin/brand/{{ $brand->id}}/edit" class="btn btn-info btn-flat btn-sm"> <i class="fa fa-edit"></i></a>
                
                  <button class="btn btn-danger btn-flat btn-sm singleDelete"> <i class="fa fa-trash-o"></i></button>
                </form>
                
              </td>
            </tr>
            @endforeach
        </table>
        </div>
        <!-- /.box-body -->
          <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    <span style="display:block;font-size:15px;line-height:34px;margin:20px 0;">
                        Showing {{($brands->currentpage()-1)*$brands->perpage()+1}} to {{$brands->currentpage()*$brands->perpage()}} of {{$brands->total()}} entries</span>
                </div>
              <div class="col-sm-6 text-right">
                  <!-- <ul class="pagination">
				      <li class="paginate_button previous"><a href="#" >Previous</a></li>
				      <li class="paginate_button active"><a href="#" >1</a></li>
				      <li class="paginate_button "><a href="#">2</a></li>
				      <li class="paginate_button "><a href="#" >3</a></li>
				      <li class="paginate_button "><a href="#">4</a></li>
				      <li class="paginate_button "><a href="#">5</a></li>
				      <li class="paginate_button "><a href="#">6</a></li>
				      <li class="paginate_button next"><a href="#" >Next</a></li>
				    </ul> -->
				    {{ $brands->links()}}
              </div>
            </div>
        </div>
            @else
              <div class="alert alert-danger">
              	No Record Found!
              </div>
            @endif
      </div>
        <!-- /.box-body -->
      </div>


    </section>
@endsection
@section('scripts')
 <script>
    $(document).ready(function() {
        $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        //SINGLE STATUS 
        $(".singleStatus").on('click', function(event) {
             event.preventDefault(); //disable your link functionality

            var self = $(this);
            var url = self.closest('form').attr('action');

            self.html('<img src="/assets/admin/dist/img/progress.gif">');

            $.ajax({
                url: url,
                type: 'PUT',
            })
            .done(function(data) {
               if (data == 'ACTIVE') {
                self.closest('form').find('button').removeClass('btn-danger');
                self.closest('form').find('button').addClass('btn-info');
                self.html('<i class="fa fa-thumbs-up"></i>');
               } 
               else  {
                self.closest('form').find('button').removeClass('btn-info');
                self.closest('form').find('button').addClass('btn-danger');
                self.html('<i class="fa fa-thumbs-down"></i>');

               }
            })
            .fail(function() {
                alert("opps! something Went Wrong.")
            })
            .always(function() {
                console.log("complete");
            });
        });

    //SINGLE DELETE
        $(".singleDelete").on('click', function(event) {
            event.preventDefault();
            var self = $(this);
            var url = self.closest('form').attr('action');
            if (confirm('Are you sure you want to delete this')) 
            {
                $.ajax({
                    url: url,
                    type: 'delete',
                })
                .done(function(data) {
                    console.log(data)
                    // alert("sds")
                    if (data == 'true') 
                    {
                        self.closest('tr').css('background-color', 'red').fadeOut('slow');
                        self.remove();
                    }
                })
                .fail(function(err) {
                    console.log("err ===== ",err)

                    alert("Opps! Something went wrong.");
                })
                .always(function() {
                    console.log("complete");
                });
            }
        });
        //ACTIVE ALL STATUS
        $("#activeAllStatus").on('click', function(event) {
            event.preventDefault();

            var statusAllValue = [];

            $("input[name='statusAll[]']:checked").each(function(index, el) {
                statusAllValue.push($(this).val());
            });

            $.ajax({
                url: $("#activeAllStatus").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data) {
                $.each(data, function(index, val) {
                    $("input[value='"+val.id+"']")
                    .closest('tr')
                    .find('.singleStatus')
                    .removeClass('btn-danger')
                    .addClass('btn-info')
                    .html('<i class="fa fa-thumbs-up"></i>')
                });
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            

        });
       // DEACTIVE ALL STATUS
        $("#deactiveAllStatus").on('click', function(event) {
            event.preventDefault();

            var statusAllValue = [];

            $("input[name='statusAll[]']:checked").each(function(index, el) {
                statusAllValue.push($(this).val());
            });

            $.ajax({
                url: $("#deactiveAllStatus").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data) {
                $.each(data, function(index, val) {
                    $("input[value='"+val.id+"']")
                    .closest('tr')
                    .find('.singleStatus')
                    .removeClass('btn-info')
                    .addClass('btn-danger')
                    .html('<i class="fa fa-thumbs-down"></i>')
                });
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            

        });
        // DELETE ALL
        $("#deleteAll").on('click', function(event) {
            event.preventDefault();

            var statusAllValue = [];

            $("input[name='statusAll[]']:checked").each(function(index, el) {
                statusAllValue.push($(this).val());
            });

            $.ajax({
                url: $("#deleteAll").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data) {
                location.reload(true);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            

        });

        
    });
 </script>
@endsection