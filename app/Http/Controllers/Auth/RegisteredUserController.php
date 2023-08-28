<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $specialtiesArray= Specialty::all();

        return view('auth.register', compact('specialtiesArray'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:5', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'city' => ['required', 'max:30'],
                'address' => ['required', 'max:100'],
                'specialty' => ['required', 'exists:specialties,id']
            ],
            [
                'name.required' => 'Il nome è obbligatorio',
                'name.min' => 'Il nome deve avere minimo 5 caratteri',
                'name.max' => 'Il nome può avere massimo 30 caratteri',
                'email.required' => 'La mail è obbligatoria',
                'email.email' => 'La mail è in un formato non corretto',
                'email.max' => 'La mail può avere massimo 255 caratteri',
                'email.unique' => 'Questa mail appartiene ad un utente già registrato',
                'password.required' => 'La password è obbligatoria',
                'password.confirmed' => 'Le password non corrispondono',
                'city.required' => 'La città deve obbligatoria',
                'city.max' => 'La città può avere massimo 30 caratteri',
                'address.required' => 'L\'indirizzo è obbligatorio',
                'address.max' => 'L\'indirizzo può avere massimo 100 caratteri',
                'specialty.required' => 'Seleziona almeno una specializzazione',
                'specialty.exists' => 'C\'è stato un problema, riprova'
            ]
        );

        // dd($request->specialty);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $newDoctor = new Doctor();
        $newDoctor->city = $request->city;
        $newDoctor->address = $request->address;
        $newDoctor->user_id = $user->id;
        $newDoctor->save();

        $newDoctor->specialties()->sync($request->specialty);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
