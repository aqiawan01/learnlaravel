@extends('admin/layout/master')
@section('page-title')
  Create product
@endsection
@section('main-content')
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <!-- form start -->
      <form name="formCreate" id="formCreate" method="post" action="/admin/product" enctype="multipart/form-data">
        @csrf
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
            <input type="hidden" id="spec_count" name="spec_count" value="2">
                <div class="col-xs-6">
                  <div class="form-group">
                      <label>Category <span class="text text-red">*</span></label>
                      <select class="form-control" name="category_id" id="category_id" style="width: 100%;">
                        <option value="none">-- Select category --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                         @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>sub_category <span class="text text-red">*</span></label>
                      <select class="form-control" name="sub_category_id" id="sub_category_id" style="width: 100%;">
                        <option value=""></option>
                       
                      </select>
                    </div>
                 <div class="form-group">
                    <label for="title">Title <span class="text text-red">*</span></label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                    </div>
 
                    <div class="form-group">
                    <label for="slug">Slug <span class="text text-red">*</span></label>
                      <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug">
                    </div>
                    

                    <div class="form-group">
                      <label for="availability">Availability <span class="text text-red">*</span></label>
                      <input type="text" class="form-control" name="availability" id="availability" placeholder="Availability">
                    </div>
                    <div class="form-group">
                  <label for="price">Price: <span class="text text-red">*</span></label> 
                  <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                 </div>

                 <div class="form-group">
                  <label for="price">Rating <span class="text text-red">*</span></label> 
                  <input type="text" class="form-control" name="rating" id="rating" placeholder="rating">
                 </div>
                  <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" class="form-control" name="publisher" id="publisher" placeholder="Publisher">
                  </div>
                  <div class="form-group">
                    <label>Country of Publisher <span class="text text-red">*</span></label>
                    <select class="form-control select2" name="country_of_publisher" id="country_of_publisher" style="width: 100%;">
                      <option value="none">-- Select country --</option>
                      @foreach($countries as $country )
                      <option value="{{ $country->id }}"> {{ $country->name }} </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="ISBN">
                  </div>

                    <div class="form-group">
                      <label for="isbn_10">ISBN-10</label>
                      <input type="text" class="form-control" name="isbn_10" id="isbn_10" placeholder="ISBN-10">
                    </div>
                    <div class="form-group">
                      <label for="audience">Audience</label>
                      <input type="text" class="form-control" name="audience" id="audience" placeholder="Audience">
                    </div>

                    <div class="form-group">
                      <label>Recomended</label>
                      <select class="form-control" name="recommended" id="recommended" style="width: 100%;">
                        <option value="none">-- Select Recomended --</option>
                        <option value="yes">Recomended</option>
                        <option value="no">Not Recomended</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="product_img">product Image</label>
                      <input type="file" class="form-control" name="product_img" id="product_img" >
                      <small class="label label-warning">Cover Photo will be uploaded</small>
                    </div>
                </div>
                 
                <div class="col-xs-6">
                  
                    <div class="form-group">
                      <label for="description">Description <span class="text text-red">*</span></label>
                      <textarea class="form-control" name="description" rows="5" id="description" placeholder="Description"></textarea>
                    </div>
                    <h3>PRODUCT SPECIFICATION</h3>
                    <hr>

                    <div id='TextBoxesGroup'>
                    <div id="TextBoxDiv1 col-md-12">
                      <div class="col-md-6">
                      <label>Title : </label><input type='textbox' name="spec_title1" id='spec_title1' class="form-control" >
                      </div>
                      <div class="col-md-6" >
                      <label>Description : </label><input type='textbox' name="spec_desc1" id='spec_desc1' class="form-control" >
                      </div>
                    </div>
                  </div>
                  <br>
                    <input type='button' class="btn btn-success" value='Add More' id='addButton'>
                    <input type='button' class="btn btn-danger" value='Remove Button' id='removeButton'>
                    <input type='button' class="btn btn-primary" value='Get TextBox Value' id='getButtonValue'>

                     
                </div>
            </div>

              <!-- row end -->

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/admin/product" class="btn btn-danger">Cancel</a>
          </div>
      </div>
      <!-- /.box -->
     </form>
      <!-- form end -->

    </section>
@endsection
@section('ecxtra-scripts')
<script>
 $(document).ready(function () { 
            $('#category_id').on('change',function(e){
            console.log(e);
            var category_id = e.target.value;
            //console.log(category_id);
            //ajax
            $.get('/admin/ajax-subcat?category_id='+ category_id,function(data){
                //success data
               //console.log(data);
                var subcat =  $('#sub_category_id').empty();
                $.each(data['subcategories'],function(create,subcatObj){
                    var option = $('<option/>', {id:create, value:subcatObj});
                    // console.log(subcatObj);
                    subcat.append('<option value ="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });
    });


 $(document).ready(function(){

    var counter = 2;
    
    $("#addButton").click(function () {
        
  if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
  }   
    
  var newTextBoxDiv = $(document.createElement('div'))
       .attr("id", 'TextBoxDiv' + counter);
                
  newTextBoxDiv.after().html('<div class="col-md-6"><label>title #'+ counter + ' : </label>' +
        '<input type="text" name="spec_title' + counter + 
        '" id="spec_title' + counter + '" value="" class="form-control"></div><div class="col-md-6"><label>description #'+ counter + ' : </label>' +
        '<input type="text" name="spec_desc' + counter + 
        '" id="spec_desc' + counter + '" value="" class="form-control"></div>');
            
  newTextBoxDiv.appendTo("#TextBoxesGroup");

  counter++;
        $('#spec_count').val(counter);
     });

     $("#removeButton").click(function () {
  if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
        
  counter--;
  $('#spec_count').val(counter);
      
        $("#TextBoxDiv" + counter).remove();
      
     });
    
     $("#getButtonValue").click(function () {
    
  var msg = '';
  for(i=1; i<counter; i++){
      msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
  }
        alert(msg);
     });
  });
</script>


<!-- <script >
$(document).ready(function () {
$('#category_id').on('change',function(e) {
var cat_id = e.target.value;
$.ajax({
url:"",
type:"POST",
data: {
cat_id: cat_id
},
success:function (data) {
$('#sub_category_id').empty();
$.each(data.subcategories[0].subcategories,function(index,sub_category_id){
$('#sub_category_id').append('<option value="'+sub_category_id.id+'">'+sub_category_id.name+'</option>');
})
}
})
});
});

</script> -->
@endsection