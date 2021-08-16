<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
class ProfileController extends Controller
{
    public function uploadProfile(ProfileRequest $request){
       
        $data= $request->all();
        $fp = fopen('file.csv', 'a+');
        $educationBackgrounds = [];
        foreach($data['educationBackgrounds'] as $key=>$value){
            $educationBackgrounds[] = implode('-',$value);
        }
        unset($data['avatar']);
        if(count($educationBackgrounds))
            $data['educationBackgrounds'] =  json_encode($educationBackgrounds);
        else
           $data['educationBackgrounds'] = ''; 
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
        //if($row>1){
            return response()->json($response);
        //}
        
    }
}
