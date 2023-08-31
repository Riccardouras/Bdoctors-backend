<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Review;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->first();

        $data = [
            'doctor' => $doctor
        ];

        return view('admin.doctors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        if ($doctor->id != auth()->id()) {
            abort(code: 403);
        }
        $data = [
            'doctor' => $doctor,
            'specialtiesArray' => Specialty::all(),
            'doctorSpecialties' => $doctor->specialties->pluck('id')->toArray()
        ];

        return view('admin.doctors.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {

        $data = $request->validated();

        if (array_key_exists('image', $data)) {
            $imgPath = Storage::put('uploads', $data['image']);
            $data['image'] = $imgPath;
        }

        if (array_key_exists('curriculum', $data)) {
            $imgPath = Storage::put('uploads', $data['curriculum']);
            $data['curriculum'] = $imgPath;
        }

        $user = Auth::user();
        $user->name = $data['name'];
        $user->update();

        $doctor->fill($data);
        $doctor->update();

        $doctor->specialties()->sync($data['specialty']);

        return to_route('admin.doctors.index', compact('doctor'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        $user = Auth::user();
        Auth::logout();
        $doctor->delete();
        $user->delete();
        return view('welcome');
    }

    /**
     * Show the doctor's received reviews.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews()
    {
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->pluck('id');
        $doctor_id = $doctor[0];

        $reviews = Review::where('doctor_id', $doctor_id)->orderBy('date', 'desc')->get();

        return view('admin.doctors.reviews', compact('reviews'));
    }

    /**
     * Show the doctor's received messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function messages()
    {
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->pluck('id');
        $doctor_id = $doctor[0];

        $messages = Message::where('doctor_id', $doctor_id)->orderBy('date', 'desc')->get();

        return view('admin.doctors.messages', compact('messages'));
    }


    /**
     * Show the doctor's statistic.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();

        $lastMonthDates = mktime(0, 0, 0, date("m") - 1, date("d"),   date("Y"));
        $lastMonthDates = gmdate("Y-m-d H:i:s", $lastMonthDates);
        $lastYearDates = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);
        $lastYearDates = gmdate("Y-m-d H:i:s", $lastYearDates);

        $lastMonthVotes = [];
        $lastYearVotes = [];

        $dynamicVotesVariables = [
            [
                'timeVariable' => &$lastMonthDates,
                'storeVariable' => &$lastMonthVotes
            ],
            [
                'timeVariable' => &$lastYearDates,
                'storeVariable' => &$lastYearVotes
            ]
        ];

        foreach ($dynamicVotesVariables as $variables) {

            $oneStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '1')->count();
            $twoStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '2')->count();
            $threeStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '3')->count();
            $fourStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '4')->count();
            $fiveStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '5')->count();

            $variables['storeVariable'] = [
                'oneStar' => $oneStar,
                'twoStar' => $twoStar,
                'threeStar' => $threeStar,
                'fourStar' => $fourStar,
                'fiveStar' => $fiveStar
            ];
        }

        $lastMonthMessages = $doctor->messages()->where('date', '>', $lastMonthDates)->count();
        $lastYearMessages = $doctor->messages()->where('date', '>', $lastYearDates)->count();

        $lastMonthReviews = $doctor->reviews()->where('date', '>', $lastMonthDates)->count();
        $lastYearReviews = $doctor->reviews()->where('date', '>', $lastYearDates)->count();

        $data = [
            'lastMonthVotes' => $lastMonthVotes,
            'lastYearVotes' => $lastYearVotes,
            'lastMonthMessages' => $lastMonthMessages,
            'lastYearMessages' => $lastYearMessages,
            'lastMonthReviews' => $lastMonthReviews,
            'lastYearReviews' => $lastYearReviews,
            'user' => $user
        ];

        return view('admin.doctors.stats', $data);
    }
}
