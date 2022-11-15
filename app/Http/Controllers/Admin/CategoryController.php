<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	public function index()
    {
        
        $categories = Category::where('parent_id', '=', null)->latest()->paginate(50);
        return view('admin/category/index')->with(compact('categories'));
        
    }

    public function create(Request $request)
    {
         $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        if($request->method()=='GET')
        {
            return view('admin/category/create', compact('categories'));
        }

        if($request->method()=='POST')
        {
            $validator = $request->validate([
                'name'      => 'required',
                'slug'      => 'required|unique:categories',
                'parent_id' => 'nullable|numeric'
            ]);

            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' =>$request->parent_id,
                'category_img' => 'No Image Found!',
                'description' => $request->description,
                'status' => 'DEACTIVE'
            ]);

            return redirect()->back()->with('success', 'Category has been created successfully.');
        }

    
    }


    public function store(Request $request)
    {
        
        Category::create([
            'name' => request()->get('name'),
            'slug' => request()->get('slug'),
            'parent_id' =>request()->get('parent_id'),
            'category_img' => 'NO Image found!',
            'description' => request()->get('description'),
            'status' => 'DEACTIVE',
       ]);

       return redirect()->to('/admin/category');
    }

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
         
        
        $category = Category::find($id);
        
        return view('admin/category/edit')->with(compact('category', 'categories'));
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
         

        $category =Category::find($id);
        $category->update([
            'name' => request()->get('name'),
            'slug' => request()->get('slug'),
            'category_img' => 'NO Image found!',
            'description' => request()->get('description'),
            'status' => 'DEACTIVE',
        ]);

        return redirect()->to('admin/category');
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
            $category = Category::find($id); //column name must be category_id.
            $category->delete();
           return 'true';
        }
        
    }

     public function status(Request $request, $id)
    {
        if ($request->ajax()) {
            $category = Category::find($id);
        $newStatus = ($category->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
        $category->update([
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
                Category::where('id', $value)->update([ 'status' => 'ACTIVE']);
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }

    public function statusDeactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Category::where('id', $value)->update([ 'status' => 'DEACTIVE']);
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }

    public function deleteAll(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Category::where('id', $value)->delete();
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }
}
