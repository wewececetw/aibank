<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoiSettings;

class RoiSettingsController extends Controller
{
    public function index(){
        $data = RoiSettings::all();
        return view('Back_End.roi_settings.roi_settings_panel',[
            'data' => $data
        ]);
    }

    public function roi_settings_edit(RoiSettings $roi_settings)
    {
        return view('Back_End.roi_settings.roi_settings_edit',[
            'roi_settings' => $roi_settings
        ]);
    }

    public function roi_settings_update(Request $req)
    {
        try {
            $id = $req->roi_settings_id;
            $data = $req->all()['roi_settings'];
            $model = RoiSettings::find($id);
            $model->name = $data['name'];
            $model->description = $data['description'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            // return redirect('/admin/roi_settings')->with('updateSuccess',true);

            $data = RoiSettings::all();
            return view('Back_End.roi_settings.roi_settings_panel',[
                'data' => $data,
                'updateSuccess' => true,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            // return redirect('/admin/roi_settings')->with('updateFail',true);
            return view('Back_End.roi_settings.roi_settings_panel',[
                'data' => $data,
                'updateFail' => true,
            ]);
        }
    }


}
