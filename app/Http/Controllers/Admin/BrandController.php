<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    	
        $brands = Brand::latest()->paginate(50);
        return view('admin/brand/index')->with(compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      

        return view('admin/brand/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
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

        $fileName = null;
        if (request()->hasFile('brand_img')) 
        {
            $file = request()->file('brand_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getclientOriginalExtension();
            $file->move('./uploads/', $fileName);
        }

       

        Brand::create([
        	
            'title' => request()->get('title'),
            'slug' => request()->get('slug'),
            'brand_img' => $fileName,
            'description' => request()->get('description'),
            'status' => 'DEACTIVE', 
        ]);

         return redirect()->to('/admin/brand');
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
       

        $brand = Brand::find($id);
        return view('admin/brand/edit')->with(compact('brand'));
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
       

        $brand = Brand::find($id); 
        $currentImage = $brand->brand_img;
        $currentImage_1 = $brand->brand_upload;
        

         $fileName =  null;
        if (request()->hasFile('brand_img')) 
        {
            $file = request()->file('brand_img');
            $fileName = md5($file->getClientOriginalName()) . time() . '.' . $file->getclientOriginalExtension();
            $file->move('./uploads', $fileName);
        }


        

        $brand->update([
            'title' => request()->get('title'),
            'slug' => request()->get('slug'),
            'brand_img' => ($fileName) ? $fileName :  $currentImage,
            'description' => request()->get('description'),
          
        ]);

        if ($fileName) {
            File::delete('./uploads/' . $currentImage);
        }

        if ($fileName_1) {
            File::delete('./uploads/' . $currentImage_1);
        }
        return redirect()->to('admin/brand');
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
             $brand = Brand::find($id); //column name must be brand_id.
             $brand->delete();
           return 'true'; 
        }
       
    }

    public function status(Request $request, $id)
    {
        sleep(1);
        if ($request->ajax()) {
          $brand = Brand::find($id);
          $newStatus = ($brand->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
          $brand->update([
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
                Brand::where('id', $value)->update([ 'status' => 'ACTIVE']);
            }
            $record = Brand::find($request->statusAll);
            return $record;
        }
    }

    public function statusDeactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Brand::where('id', $value)->update([ 'status' => 'DEACTIVE']);
            }
            $record = Brand::find($request->statusAll);
            return $record;
        }
    }

    public function deleteAll(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Brand::where('id', $value)->delete();
            }
            $record = Brand::find($request->statusAll);
            return $record;
        }
    }
}
