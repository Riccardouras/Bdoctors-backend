<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DoctorVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DoctorVoteController extends Controller
{
    public function storeVote(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'doctor_id' => 'required|exists:doctors,id',
                'vote_id' => 'required|exists:votes,id'
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
        $newData['date'] = date("Y-m-d H:i:s");
        $newVote = new DoctorVote();
        $newVote->fill($newData);
        $newVote->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
