<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Country;
use App\ProductSpecification;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    	
        $products = Product::latest()->paginate(50);
        return view('admin/product/index')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$countries = Country::all();
        $categories = Category::where('parent_id',  null)->get();
        $products = Product::latest()->paginate(50);
        return view('admin/product/create')->with(compact( 'categories', 'countries'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->all());
      // if($request->spec_count > 0 ){
      // 	$spec_title = $request->spec_title4;
      // 	foreach ($variable as $key => $value) {
      // 		# code...
      // 	}
      // 	dd($spec_title);
      // }


        // $this->validate(request(), [
        // 	'title' => 'required',
        // 	'slug' => 'required',
        // 	'category' => 'required',
        // 	'author ' => 'required',
        // 	'availability ' => 'required',
        // 	'price ' => 'required',
        // 	'country_of_publisher' => 'required',
        // 	'dscription  ' => 'required',
        //   ]);

        // $fileName = null;https://www.youtube.com/
        if (request()->hasFile('product_img')) 
        {
            $file = request()->file('product_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getclientOriginalExtension();
            $file->move('./uploads/', $fileName);
        }

       $product = new Product();
		  $product->category_id = $request->input('category_id');
		  $product->sub_category_id = $request->input('sub_category_id');
		  $product->title = $request->input('title');
		  $product->slug = $request->input('slug');
		  $product->availability = $request->input('availability');
		  $product->price = $request->input('price');
		  $product->rating = $request->input('rating');
		  $product->publisher = $request->input('publisher');
		  $product->country_of_publisher = $request->input('country_of_publisher');
		  $product->isbn = $request->input('isbn');
		  $product->isbn_10 = $request->input('isbn_10');
		  $product->audience = $request->input('audience');
		  $product->recommended = $request->input('recommended');
		  $product->product_img = $fileName;
		  $product->description = $request->input('description');
		  $product->status = 'DEACTIVE';
	      $product->save();

        // Product::create([
        // 	'category_id' => request()->get('category_id'),
        //     'sub_category_id' => request()->get('sub_category_id'),
        //     'title' => request()->get('title'),
        //     'slug' => request()->get('slug'),
        //     'availability' => request()->get('availability'),
        //     'price' => request()->get('price'),
        //     'rating' => request()->get('rating'),
        //     'publisher' => request()->get('publisher'),
        //     'countrty_of_publisher' => request()->get('countrty_of_publisher'),
        //     'isbn' => request()->get('isbn'),
        //     'isbn_10' => request()->get('isbn_10'),
        //     'audience' => request()->get('audience'),
        //     'recommended' => request()->get('recommended'),
        //     'product_img' => $fileName,
        //     'description' => request()->get('description'),
        //     'status' => 'DEACTIVE', 
        // ]);

        $count = $request->spec_count;
    	$all_spec = [];
      for ($i=1; $i < $count; $i++) {
    	$all_spec[] = [
    		'title' => $request->input('spec_title'.$i),
    		'description' => $request->input('spec_desc'.$i)
    	]; 
		  $specification = new ProductSpecification();
		  $specification->product_id = $product->id;
		  $specification->title = $request->input('spec_title'.$i);
	      $specification->description = $request->input('spec_desc'.$i);
	      $specification->save();
    }

         return redirect()->to('/admin/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = Category::where('parent_id',  null)->get();
        $subcategories = Category::all();
        $Product = Product::with('specification')->find($id);

        $countries = Country::all();
        // $subcategory = ProductSpecification::with('products')->where($id , 'product_id')->get();

        
        return view('admin/product/edit')->with(compact('Product', 'countries', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $Product = Product::find($id);
        $specification = ProductSpecification::where('product_id', $id)->delete();
     
        $currentImage = $Product->product_img;
   
         $fileName =  null;
        if (request()->hasFile('product_img')) 
        {
            $file = request()->file('product_img');
            $fileName = md5($file->getClientOriginalName()) . time() . '.' . $file->getclientOriginalExtension();
            $file->move('./uploads', $fileName);
        }
 
        $Product->update([
            'category_id' => request()->get('category_id'),
            'sub_category_id' => request()->get('sub_category_id'),
            'title' => request()->get('title'),
            'slug' => request()->get('slug'),
            'availability' => request()->get('availability'),
            'price' => request()->get('price'),
            'rating' => request()->get('rating'),
            'publisher' => request()->get('publisher'),
            'countrty_of_publisher' => request()->get('countrty_of_publisher'),
            'isbn' => request()->get('isbn'),
            'isbn_10' => request()->get('isbn_10'),
            'audience' => request()->get('audience'),
            'product_img' => ($fileName) ? $fileName :  $currentImage,
            'recommended' => request()->get('recommended'),
            'description' => request()->get('description'),
          
        ]);

        if ($fileName) {
            File::delete('./uploads/' . $currentImage);
        }
        
        $count = $request->spec_count;
        $all_spec = [];
      for ($i=1; $i < $count; $i++) {
        $all_spec[] = [
            'title' => $request->input('spec_title'.$i),
            'description' => $request->input('spec_desc'.$i)
        ]; 
          $specification = new ProductSpecification();
          $specification->product_id = $id;
          $specification->title = $request->input('spec_title'.$i);
          $specification->description = $request->input('spec_desc'.$i);
          $specification->save();
    } 
       

        return redirect()->to('admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       

        if ($request->ajax()) {
             $Product = Product::find($id); //column name must be Product_id.
             $Product->delete();
             $specification = ProductSpecification::where('product_id', $id)->delete();
           return 'true'; 
        }
       
    }

    public function status(Request $request, $id)
    {
        sleep(1);
        if ($request->ajax()) {
          $Product = Product::find($id);
          $newStatus = ($Product->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
          $Product->update([
             'status' => $newStatus
          ]);

         return $newStatus;
        }
        
    }

     public function statusActive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Product::where('id', $value)->update([ 'status' => 'ACTIVE']);
            }
            $record = Product::find($request->statusAll);
            return $record;
        }
    }

    public function statusDeactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Product::where('id', $value)->update([ 'status' => 'DEACTIVE']);
            }
            $record = Product::find($request->statusAll);
            return $record;
        }
    }

    public function deleteAll(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Product::where('id', $value)->delete();
            }
            $record = Product::find($request->statusAll);
            return $record;
        }
    }

}
