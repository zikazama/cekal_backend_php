<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MakananModel;

class ApiController extends Controller
{
    public function cek_kalori(Request $request)
    {
        $file = $request->file('file');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'uploads';
        $cek = $file->move(public_path($tujuan_upload), $nama_file);
        //return response($cek,200);
        $hasil = json_decode($this->vireg("https://backend.yukija.tech/uploads/$nama_file"));
        $keyword = $hasil->images[0]->classifiers[0]->classes[0]->class ?? 'Non-food';
        //$keywords = explode(' ',$keyword);
        $makanan = new \App\Models\MakananModel;
        if($keyword == 'Non-food'){
            $data['data'] = array(
                array(
                    'nama' => 'Gambar Tak Terbaca',
                    'kalori' => 'Tak Terbaca'
                )
            );
        } else {
            $data['data'] = $makanan->cari($keyword);
            if(count($data['data']) == 0){
                $data['data'] = array(
                    array(
                        'nama' => 'Belum Terdata',
                        'kalori' => 'Belum Terdata'
                    )
                );
            }
        }
        
        $data['path'] = "https://backend.yukija.tech/uploads/$nama_file";
        return response($data);
    }

    private function vireg($dir_foto)
    {
        $url = "https://api.us-south.visual-recognition.watson.cloud.ibm.com/instances/6a2cddb7-ef6d-4b5b-b988-c9f52c6a88fd/v3/classify?url=$dir_foto&version=2018-03-19";
        $model = "classifier_ids=food";

        //cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Endpoint URL
        curl_setopt($ch, CURLOPT_USERPWD, "apikey:OoON2Y_o8AdF1mcQxvJWNDBAmjzudrdHxGd4E5r4Vxp9");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1); //POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $model); //Parameters

        // Execute the cURL command
        $result = curl_exec($ch);

        // Erro
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        // Close the command
        curl_close($ch);

        // Show the JSON result
        return $result;
    }
}
