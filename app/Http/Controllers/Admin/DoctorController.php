<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\DoctorSponsor;
use App\Models\DoctorVote;
use App\Models\Message;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\Sponsor;
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
        //Recupero l'utente autenticato e il record in doctors relativo
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->first();
        // Verifico se l'utente ha una sposnosorizzazione in corso
        $sponsoredDoctor = DoctorSponsor::where('doctor_id', $doctor->id)->first();
        $rating = DoctorVote::where('doctor_id', $doctor->id)->avg('vote_id');
        $averageRating = round($rating, 1);

        //Creo l'array con i dati da passare alla vista
        $data = [
            'doctor' => $doctor,
            'sponsoredDoctor' => $sponsoredDoctor,
            'averageRating' => $averageRating
        ];

        //Richiamo la vista del profilo e restituisco i dati
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
        //Controllo che il profilo da modificare sia quello dell'utente loggato
        //In caso contrario blocco l'operazione
        if ($doctor->id != auth()->id()) {
            abort(code: 403);
        }
        //Creo l'array con tutti i dati da passare alla vista 
        $data = [
            'doctor' => $doctor,
            'specialtiesArray' => Specialty::all(),
            'doctorSpecialties' => $doctor->specialties->pluck('id')->toArray()
        ];

        //Richiamo la vista edit e restituisco i dati 
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
        //Valido i dati usando una Request esterna
        $data = $request->validated();

        // Se viene inserita una nuova immagine viene salvata nello storage e viene salvato il path
        if (array_key_exists('image', $data)) {
            $imgPath = Storage::put('uploads', $data['image']);
            $data['image'] = $imgPath;
        }

        // Se viene inserito un nuovo curriculum viene salvato nello storage e viene salvato il path
        if (array_key_exists('curriculum', $data)) {
            $imgPath = Storage::put('uploads', $data['curriculum']);
            $data['curriculum'] = $imgPath;
        }
        //Recupero l'utente autenticato e ne aggiorno il nome
        $user = Auth::user();
        $user->name = $data['name'];
        $user->update();

        //Aggiorno i dati del record doctor
        $doctor->fill($data);
        $doctor->update();

        //Aggiorno le specializzazioni collegate al record doctor
        $doctor->specialties()->sync($data['specialty']);

        //Richiamo la vista del profilo passando i nuovi dati
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
        //Recupero l'utente autenticato
        $user = Auth::user();
        //Recupero l'id dell'utente
        $user_id = $user->id;
        //Faccio il logout dell'utente
        Auth::logout();
        //Elimino il record in doctors relativo all'utente
        $doctor = Doctor::where('user_id', $user_id)->first();
        $doctor->delete();
        //Elimino il record dell'utente
        $user->delete();

        //Reindirizzo all home del sito
        return redirect('http://localhost:5174');
    }

    /**
     * Show the doctor's received reviews.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews()
    {
        //Recupero utente autenticato e id dottore corrispondente
        $user_id = Auth::user()->id;
        $doctor_id = Doctor::where('user_id', $user_id)->pluck('id')->first();

        //Recupero le recensioni, che hanno doctor_id uguale a quello recuperato sopra, per data in ordine decrescente
        $reviews = Review::where('doctor_id', $doctor_id)->orderBy('date', 'desc')->get();

        //Richiamo la vista delle recensioni e passo le recensioni recuperate
        return view('admin.doctors.reviews', compact('reviews'));
    }

    /**
     * Show the doctor's received messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function messages()
    {
        //Recupero utente autenticato e id dottore corrispondente
        $user_id = Auth::user()->id;
        $doctor_id = Doctor::where('user_id', $user_id)->pluck('id')->first();

        //Recupero i messaggi, che hanno doctor_id uguale a quello recuperato sopra, per data in ordine decrescente
        $messages = Message::where('doctor_id', $doctor_id)->orderBy('date', 'desc')->get();

        //Richiamo la vista dei messaggi e passo i messaggi recuperati
        return view('admin.doctors.messages', compact('messages'));
    }


    /**
     * Show the doctor's statistic.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        //Recupero utente autenticato e record dottore corrispondente
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();

        //Creo le date indietro nel tempo di un mese e un anno e le converto in formato DateTime MySQL
        $lastMonthDates = mktime(0, 0, 0, date("m") - 1, date("d"),   date("Y"));
        $lastMonthDates = gmdate("Y-m-d H:i:s", $lastMonthDates);
        $lastYearDates = mktime(0, 0, 0, date("m"), date("d"),   date("Y") - 1);
        $lastYearDates = gmdate("Y-m-d H:i:s", $lastYearDates);

        //Dichiaro gli array dei voti dell'ultimo mese e anno che verranno restituiti alla vista
        $lastMonthVotes = [];
        $lastYearVotes = [];

        //Creo un array per effettuare la stessa operazione con date e array di store differenti,
        // Con & uso un riferimento alle variabili e non una copia 
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

        //Ciclo sull'array appena fatto per salvare la quantità di voti per ogni singolo valore per l'ultimo mese e anno
        foreach ($dynamicVotesVariables as $variables) {

            //Salvo le quantità di voti per ogni singolo valore
            $oneStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '1')->count();
            $twoStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '2')->count();
            $threeStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '3')->count();
            $fourStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '4')->count();
            $fiveStar = $doctor->votes()->where('date', '>', $variables['timeVariable'])->where('vote_id', '5')->count();

            //Inserisco nell'array i dati appena recuperati
            $variables['storeVariable'] = [
                'oneStar' => $oneStar,
                'twoStar' => $twoStar,
                'threeStar' => $threeStar,
                'fourStar' => $fourStar,
                'fiveStar' => $fiveStar
            ];
        }

        //Recupero il numero dei messaggi e delle recensioni ricevute nell'ultimo mese e anno
        $lastMonthMessages = $doctor->messages()->where('date', '>', $lastMonthDates)->count();
        $lastYearMessages = $doctor->messages()->where('date', '>', $lastYearDates)->count();

        $lastMonthReviews = $doctor->reviews()->where('date', '>', $lastMonthDates)->count();
        $lastYearReviews = $doctor->reviews()->where('date', '>', $lastYearDates)->count();

        // Dichiaro l'array con i dati che devono essere mandati alla vista
        $data = [
            'lastMonthVotes' => $lastMonthVotes,
            'lastYearVotes' => $lastYearVotes,
            'lastMonthMessages' => $lastMonthMessages,
            'lastYearMessages' => $lastYearMessages,
            'lastMonthReviews' => $lastMonthReviews,
            'lastYearReviews' => $lastYearReviews,
            'user' => $user
        ];

        //Richiamo la vista delle statistiche passandole l'array di dati dichiarato sopra
        return view('admin.doctors.stats', $data);
    }
}
