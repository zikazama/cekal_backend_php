<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasModel;
use App\Models\BukalModel;


class BotController extends Controller
{
    public function index(Request $request){
        $TOKEN = "1489404888:AAEO2t9MTKMQZybdgV0C67NO7XFH983G2_0";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"),TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        $dataAktivitas = new AktivitasModel;
        $dataBukal = new BukalModel;
        $aktivitas = AktivitasModel::where('chat_id',$chatID);

        if($aktivitas->count() == 0){
            $dataAktivitas->chat_id = $chatID;
            if($message == '/cekal'){
                $dataAktivitas->status = 'cekal';
                $text = urlencode("Silahkan kirim gambar yang ingin dianalisis kalorinya.");
                file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
            } else if ($message == '/bukal'){
                $dataAktivitas->status = 'bukal';
                $text = urlencode("Silahkan balas : \n L - untuk laki laki \n P - untuk perempuan \n tulis hurufnya saja, contoh : L");
                file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
            }
            //$dataAktivitas->status = 'cekal';
            $dataAktivitas->step = 1;
            $dataAktivitas->save();
        } else {
            $aktivitas = $aktivitas->orderBy('id_aktivitas','DESC')->first();
            if($aktivitas->status == 'cekal'){
                switch ($aktivitas->step) {
                    case 1:
                        # code...
                        $text = urlencode("Berhasil.");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->delete();
                        break;
                    
                    default:
                        # code...
                        break;
                }
            } else if($aktivitas->status == 'bukal'){
                switch ($aktivitas->step) {
                    case 1:
                        //$dataBukal->id_aktivitas = $aktivitas->id_aktivitas;
                        $text = urlencode("Berapa berat badan anda dalam bilangan bulat dan satuan kilogram ? \n contoh : 55");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->step = 2;
                        $aktivitas->save();
                        break;
                    case 2:

                        $text = urlencode("Berapa tinggi badan anda dalam bilangan bulat dan satuan centimeter ? \n contoh : 165");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->step = 3;
                        $aktivitas->save();
                        break;
                    case 3:

                        $text = urlencode("Berapa tahun usia anda saat ini ? \n contoh : 20");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->step = 4;
                        $aktivitas->save();
                        break;
                    case 4:
                        $text = urlencode("Seberapa sering anda beraktivitas : \n 1. Jarang \n 2. Sedang \n 3. Sering \n Tulis angkanya saja, contoh : 2");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->step = 5;
                        $aktivitas->save();
                        break;
                    case 5:
                        # code...
                        $text = urlencode("Berhasil.");
                        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$text");
                        $aktivitas->delete();
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }

        // if(strpos($message,"/bukal") === 0){
        //     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Work");
        // } else if (strpos($message,"/cekal") === 0) {
        //     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Work");
        // }
    }
}
