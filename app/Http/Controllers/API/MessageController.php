<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;



class MessageController extends Controller
{
    public function storeMessage(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'full_name' => 'required|max:30',
                'mail' => 'required|email',
                'text' => 'required|max:800',
                'doctor_id' => 'required|exists:doctors,id',
            ],
            [
                'text.required' => 'Il testo è obbligatorio',
                'text.max' => 'Il testo può avere massimo 800 caratteri',
                'full_name.required' => 'Il nome è obbligatorio',
                'full_name.max' => 'Il nome può avere massimo 30 caratteri',
                'mail.required' => 'la mail è obbligatoria',
                'mail.email' => 'Il formato della mail non è valido',
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
        $newData['date'] = Carbon::now();
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
