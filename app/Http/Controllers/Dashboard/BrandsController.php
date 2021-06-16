<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');

    }

    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $fileName = "";
            if ($request->hasFile('photo')) {
                $fileName = uploadImage('brands', $request->photo);
            }
            $brand = Brand::create($request->except('_token','id', 'photo'));
            $brand->name = $request->name;
            $brand->photo = $fileName;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم ادخال ماركة تجارية جديدة بنجاح']);

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجودة']);
        return view('dashboard.brands.edit', compact('brand'));
    }

    public function update($id, BrandRequest $request)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand)
                return redirect()->back()->with(['error' => 'هذه الماركة غير موجودة ']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            DB::beginTransaction();
            if ($request->hasFile('photo')) {
                $fileName = uploadImage('brands', $request->photo);
            }
            Brand::where('id', $id)->update(['photo' => $fileName]);
            $brand->update($request->all());
            $brand->name = $request->name;
            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }
    }
    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجودة']);
            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => 'تم المسح بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }

    }

}
