<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class  TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');

    }

    public function store(TagRequest $request)
    {


        DB::beginTransaction();
        $tag = Tag::create(['slug' => $request->slug]);
        $tag->name = $request->name;
        $tag->save();
        DB::commit();
        return redirect()->route('admin.tags')->with(['success' => 'تم الاضافة بنجاح']);


    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا العنصر غير موجود']);
        return view('dashboard.tags.edit', compact('tag'));
    }

    public function update($id, TagRequest $request)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->back()->with(['error' => 'هذا العنصر غير موجود ']);


            else

                DB::beginTransaction();

            $tag->update($request->except(['_token', 'id']));
            $tag->name = $request->name;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }


    }

    public function destroy($id)
    {
        try {
        $tag = Tag::find($id);
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا العنصر غير موجود']);
        $tag->translation->delete();
        $tag->delete();
        return redirect()->route('admin.tags')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }

    }

}
