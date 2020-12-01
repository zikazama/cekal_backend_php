<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    public function index(Request $request){
        $TOKEN = "1489404888:AAEO2t9MTKMQZybdgV0C67NO7XFH983G2_0";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"),TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if(strpos($message,"/bukal") === 0){
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Work");
        } else if (strpos($message,"/cekal") === 0) {
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Work");
        }
    }
}
