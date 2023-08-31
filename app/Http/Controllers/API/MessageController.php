<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    public function storeMessage(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'text' => 'required|max:800',
                'full_name' => 'required|max:30',
                'mail' => 'required|email',
                'doctor_id' => 'required|exists:doctors,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            );
        }

        $newData = $validator->validated();
        // $newData['doctor_id'] = $id;
        $newData['date'] = date("Y-m-d H:i:s");
        $newMessage = new Message();
        $newMessage->fill($newData);
        $newMessage->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
