<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\DoctorSponsor;
use App\Models\DoctorVote;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DoctorController extends Controller
{

    public function sponsored()
    {
        $currentDate = date("Y-m-d H:i:s");
        $activeSponsorships = DoctorSponsor::where('end_date', '>', $currentDate)->get();

        
        $sponsoredDoctorsIDS = $activeSponsorships->pluck('doctor_id')->toArray();
        
        
        $sponsoredDoctors = [];
        

        foreach ($sponsoredDoctorsIDS as $id) {

            $doctor = Doctor::where('id', $id)->first();
            $doctor_id = $doctor->id;

            $doctorImage = Doctor::where('id', $id)->select('image')->first();
            // $doctorImage =  'http://localhost:8000/storage/' . $doctorImage->image;
            $doctor->image =  'http://localhost:8000/storage/' . $doctorImage->image;

            $userID = Doctor::where('id', $id)->pluck('user_id');
            $doctorName = User::where('id', $userID[0])->select('name')->first();
            // $doctorName = $doctorName->name;
            $doctor->name = $doctorName->name;

            $doctorSpecialtiesArray = $doctor->specialties()->pluck('name')->toArray();
            $doctor->specialties = $doctor->specialties()->pluck('name')->toArray();


            $averageVote = DoctorVote::where('doctor_id', $id)->avg('vote_id');
            $averageVote = round($averageVote, 1);
            if ($averageVote == null) {
                $averageVote = 0;
            }
            $numberOfReviews = $doctor->reviews()->count();
            $doctor->averageVote = $averageVote;
            $doctor->numberOfReviews = $numberOfReviews;

            $sponsoredDoctors[] = $doctor;   
    }

    $response = [
        'success' => true,
        'results' => $sponsoredDoctors
    ];

    return response()->json($response);
}

    public function allSpecialties()
    {

        $specialtiesArray = Specialty::select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'results' => $specialtiesArray
        ]);
    }

    public function searchPerSpecialty(Request $request)
    {

        $specialty = $request->input('specialty');

        $doctors_IDS = DoctorSpecialty::where('specialty_id', $specialty)->pluck('doctor_id')->toArray();

        $doctors = [];

        foreach ($doctors_IDS as $id) {

            $doctor = Doctor::where('id', $id)->first();
            $doctor_id = $doctor->id;

            $doctorImage = Doctor::where('id', $id)->select('image')->first();
            $doctorImage =  'http://localhost:8000/storage/' . $doctorImage->image;

            $userID = Doctor::where('id', $id)->pluck('user_id');
            $doctorName = User::where('id', $userID[0])->select('name')->first();
            $doctorName = $doctorName->name;

            $doctorSpecialtiesArray = $doctor->specialties()->pluck('name')->toArray();

            $numberOfReviews = $doctor->reviews()->count();

            $averageVote = DoctorVote::where('doctor_id', $id)->avg('vote_id');
            $averageVote = round($averageVote, 1);

            $doctors[] = [
                'doctorId' => $doctor_id,
                'doctorImage' => $doctorImage,
                'doctorName' => $doctorName,
                'doctorSpecialtiesArray' => $doctorSpecialtiesArray,
                'numberOfReviews' => $numberOfReviews,
                'averageVote' => $averageVote
            ];
        }

        $response = [
            'success' => true,
            'results' => $doctors
        ];

        return response()->json($response);
    }

    public function searchWithFilter(Request $request)
    {

        $specialty = $request->input('specialty');
        $minAvgVote = $request->input('minAvgVote');
        $minNumOfReviews = $request->input('minNumOfReviews');

        $doctors_IDS = DoctorSpecialty::where('specialty_id', $specialty)->pluck('doctor_id')->toArray();

        $doctors = [];

        foreach ($doctors_IDS as $id) {

            $check = true;

            $doctor = Doctor::where('id', $id)->first();
            $doctor_id = $doctor->id;

            $doctorImage = Doctor::where('id', $id)->select('image')->first();
            $doctorImage =  'http://localhost:8000/storage/' . $doctorImage->image;

            $userID = Doctor::where('id', $id)->pluck('user_id');
            $doctorName = User::where('id', $userID[0])->select('name')->first();
            $doctorName = $doctorName->name;

            $doctorSpecialtiesArray = $doctor->specialties()->pluck('name')->toArray();

            $numberOfReviews = $doctor->reviews()->count();
            if ($numberOfReviews < $minNumOfReviews) {
                $check = false;
            }

            $averageVote = DoctorVote::where('doctor_id', $id)->avg('vote_id');
            $averageVote = round($averageVote, 1);
            if ($averageVote == null) {
                $averageVote = 0;
            }
            if ($averageVote < $minAvgVote) {
                $check = false;
            }

            if ($check) {
                $doctors[] = [
                    'doctorId' => $doctor_id,
                    'doctorImage' => $doctorImage,
                    'doctorName' => $doctorName,
                    'doctorSpecialtiesArray' => $doctorSpecialtiesArray,
                    'numberOfReviews' => $numberOfReviews,
                    'averageVote' => $averageVote
                ];
            }
        }

        $response = [
            'success' => true,
            'results' => $doctors
        ];

        return response()->json($response);
    }

    public function doctorDetails(Request $request){

        $doctor_id = $request->input('doctor_id');

        $doctor = Doctor::where('id', $doctor_id)->first();
        $userID = Doctor::where('id', $doctor_id)->pluck('user_id');
        $doctor_name = User::where('id', $userID)->pluck('name');
        $doctor->name = $doctor_name[0];
        $doctor->image = 'http://localhost:8000/storage/' . $doctor->image;
        $doctor->curriculum = 'http://localhost:8000/storage/' . $doctor->curriculum;
        $specialtyIDS = DoctorSpecialty::where('doctor_id', $doctor_id)->pluck('specialty_id')->toArray();
        $specialties= [];
        
        foreach($specialtyIDS as $id){
            $specialtyName = Specialty::where('id', $id)->pluck('name');
            $specialties[] = $specialtyName[0];
        }

        $doctor->specialties = $specialties;
        $averageVote = DoctorVote::where('doctor_id', $doctor_id)->avg('vote_id');
        $averageVote = round($averageVote, 1);
        if ($averageVote == null) {
            $averageVote = 0;
        }
        $numberOfReviews = $doctor->reviews()->count();
        $doctor->averageVote = $averageVote;
        $doctor->numberOfReviews = $numberOfReviews;


        $response = [
            'success' => true,
            'results' =>[
                'doctor' => $doctor
            ]
            ];

        return response()->json($response);
    }

    public function getDoctorReviews(Request $request){
        
        $doctor_id = $request->input('doctor_id');

        $reviews = Review::where('doctor_id', $doctor_id)->orderBy('date', 'desc')->get();

        $response = [
            'success' => true,
            'results' => $reviews
        ];

        return response()->json($response);
    }
}
