<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.subcategories.index', compact('categories'));
    }

    public function create()
    {
        $categories  = Category::parent()->orderBy('id','DESC')->get();

        return view('dashboard.subcategories.create',compact('categories'));
    }

    public function store(MainCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم ادخال قسم جديد بنجاح']);

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }
    }

    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذاالقسم غير موجود']);
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update($id, MainCategoryRequest $request)
    {
        try {
            $category = Category::find($id);
            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذاالقسم غير موجود']);
            $category->delete();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم المسح بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }

    }
}
