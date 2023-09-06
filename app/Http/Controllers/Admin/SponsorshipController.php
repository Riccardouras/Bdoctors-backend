<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSponsor;
use App\Models\DoctorVote;
use App\Models\Sponsor;
use Braintree\ClientToken;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


use Symfony\Component\CssSelector\Node\SelectorNode;

class SponsorshipController extends Controller
{
    public function showForm()
    {
        $sponsors = Sponsor::all();
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->first();
        // Verifico se l'utente ha una sposnosorizzazione in corso
        $sponsoredDoctors = DoctorSponsor::where('doctor_id', $doctor->id)->get();

        return view('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'));
    }

    public function payment(Request $request)
    {
        $selectedPackage = $request->input('selected_package');
        $selectedSponsor = Sponsor::where('id', $selectedPackage)->first();

        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'cstsvtg6wg8yxdcn',
            'publicKey' => 'prz7zwykd5yfnpm5',
            'privateKey' => '37d099ef946df7b7826f007ae3545422',
        ]);

        $clientToken = $gateway->clientToken()->generate();

        return view('admin.sponsorship.payment', [
            'selectedPackage' => $selectedSponsor,
            'clientToken' => $clientToken,
        ]);
    }


    public function processpayment(Request $request)
    {
        $sponsors = Sponsor::all();
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->first();
        $sponsoredDoctors = DoctorSponsor::where('doctor_id', $doctor->id)->get();

        $oldSponsor = DoctorSponsor::where('doctor_id', $doctor->id)->orderBy('end_date', 'desc')->first();

        $nonce = $request->input('payment_method_nonce');
        $selectedPackage = $request->input('selected_package');
        $selectedSponsor = Sponsor::where('id', $selectedPackage)->first();



        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'cstsvtg6wg8yxdcn',
            'publicKey' => 'prz7zwykd5yfnpm5',
            'privateKey' => '37d099ef946df7b7826f007ae3545422',
        ]);

        try {
            $result = $gateway->transaction()->sale([
                'amount' => $selectedSponsor->price,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]);

            if ($result->success) {
                $sponsorship = new DoctorSponsor();
                if ($oldSponsor) {
                    if ($sponsorship->id == 1) {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(24);
                    } elseif ($sponsorship->id == 2) {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(72);
                    } else {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(144);
                    }
                } else {

                    if ($sponsorship->id == 1) {
                        $sponsorship->start_date = Carbon::now();
                        $sponsorship->end_date = Carbon::now()->addHours(24);
                    } elseif ($sponsorship->id == 2) {
                        $sponsorship->start_date = Carbon::now();
                        $sponsorship->end_date = Carbon::now()->addHours(72);
                    } else {
                        $sponsorship->start_date = Carbon::now();
                        $sponsorship->end_date = Carbon::now()->addHours(144);
                    }
                }
                $sponsorship->doctor_id = $doctor->id;
                $sponsorship->sponsor_id = $selectedSponsor->id;
                $sponsorship->save();
                $message = 'Pagamento completato con successo';
                return view('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'))->with('message', $message);
            } else {
                $message = 'Errore durante il processo di pagamento';
                return view('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'))->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Errore durante il pagamento: ' . $e->getMessage();
            return view('admin.sponsorship.form', 'sponsoredDoctors')->with('error', $message);
        }
    }
}
