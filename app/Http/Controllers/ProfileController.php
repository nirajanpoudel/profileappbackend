<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\FileUpload;
class ProfileController extends Controller
{
    public function uploadProfile(ProfileRequest $request){
        $data= $request->all();
        $data['avatar'] = '';
        if($request->hasFile('avatar')){
            $data['avatar'] = FileUpload::upload($request->file('avatar'))
                ->storeAs(('avatars'));
        }

        $fp = fopen('file.csv', 'a+');         
        fputcsv($fp, $data);
        fclose($fp);
    }

    public function listProfiles(Request $request){
        $row = 0;
        $response = [];
        if (($handle = fopen("file.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                if($row==0){
                    $column = ($data);
                }else{
                    for ($c=0; $c < $num; $c++) {
                        $r= $data[$c];
                    }
                    $response[] = array_combine($column,$data);
                }
                $row++;
            }
            fclose($handle);
        }

        foreach ($response as $key => $value) {
            // dd($value)
            $value["avatar"] = url($value["avatar"]);
            // dd($response);
        }

        $response = array_map(function($value){
            if($value["avatar"])
                $value["avatar"]= url("storage/".$value["avatar"]);
            return $value;
        },$response);


            return response()->json($response);
        
    }
}
