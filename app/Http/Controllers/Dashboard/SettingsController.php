<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
{
    public function editShippingMethods($type)
    {
        if ($type === 'free')
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = Setting::where('key', 'outer_label')->first();

        elseif ($type === 'inner')
            $shippingMethod = Setting::where('key', 'local_label')->first();
        else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

        return view('dashboard.settings.shippings.edit', compact('shippingMethod'));
    }

    public function updateShippingMethods(ShippingRequest $request, $id)
    {
        try {

            $shepping_method = Setting::find($id);
            DB::beginTransaction();
            $shepping_method->update(['plain_value' => $request->plain_value]);
            $shepping_method->value = $request->value;
            $shepping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاولة فيما بعد ']);

        }

    }
}
