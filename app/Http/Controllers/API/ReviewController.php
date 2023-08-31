<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    public function storeReview(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|max:300',
                'title' => 'required|max:30',
                'comment' => 'required|max:800',
                'doctor_id' => 'required|exists:doctors,id'
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
        $newMessage = new Review();
        $newMessage->fill($newData);
        $newMessage->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
