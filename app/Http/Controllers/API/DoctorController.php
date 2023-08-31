<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\DoctorSponsor;
use App\Models\DoctorVote;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DoctorController extends Controller
{

    public function sponsored()
    {
        $currentDate = date("Y-m-d H:i:s");
        $activeSponsorships = DoctorSponsor::where('end_date', '>', $currentDate);

        $sponsoredDoctorsIDS = $activeSponsorships->pluck('doctor_id')->toArray();

        $sponsoredDoctors = [];

        foreach ($sponsoredDoctorsIDS as $id) {

            $doctor = Doctor::where('id', $id)->first();

            $doctorImage = Doctor::where('id', $id)->select('image')->first();
            $doctorImage =  'http://localhost:8000/storage/' . $doctorImage->image;

            $userID = Doctor::where('id', $id)->pluck('user_id');
            $doctorName = User::where('id', $userID[0])->select('name')->first();
            $doctorName = $doctorName->name;

            $doctorSpecialtiesArray = $doctor->specialties()->pluck('name')->toArray();

            $sponsoredDoctors[] = [
                'doctorImage' => $doctorImage,
                'doctorName' => $doctorName,
                'doctorSpecialtiesArray' => $doctorSpecialtiesArray
            ];
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
}
