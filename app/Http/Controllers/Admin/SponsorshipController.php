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
        $sponsoredDoctors = DoctorSponsor::where('doctor_id', $doctor->id)->where('end_date', '>', Carbon::now() )->get();


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
        $sponsoredDoctors = DoctorSponsor::where('doctor_id', $doctor->id)->where('end_date', '>' , Carbon::now())->get();


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
                    if ($selectedPackage == 1) {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(24);
                    } elseif ($selectedPackage == 2) {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(72);
                    } else {
                        $sponsorship->start_date =
                            $oldSponsor->end_date;
                        $sponsorship->end_date = Carbon::parse($oldSponsor->end_date)->addHours(144);
                    }
                } else {

                    if ($selectedPackage == 1) {
                        $sponsorship->start_date = Carbon::now();
                        $sponsorship->end_date = Carbon::now()->addHours(24);
                    } elseif ($selectedPackage == 2) {
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
                $msg = 'Pagamento completato con successo';
                return to_route('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'))->with('msg', $msg);
            } else {
                $err = 'Errore durante il processo di pagamento';
                return to_route('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'))->with('err', $err);
            }
        } catch (\Exception $e) {
            $err = 'Errore durante il pagamento: ' . $e->getMessage();
            return to_route('admin.sponsorship.form', compact('sponsors', 'sponsoredDoctors'))->with('err', $err);
        }
    }
}
