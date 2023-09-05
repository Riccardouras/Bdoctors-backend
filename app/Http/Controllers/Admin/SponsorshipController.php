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


use Symfony\Component\CssSelector\Node\SelectorNode;

class SponsorshipController extends Controller
{
    public function showForm()
    {
        $sponsors = Sponsor::all();

        return view('admin.sponsorship.form', compact('sponsors'));
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
        $user_id = Auth::user()->id;
        $doctor = Doctor::where('user_id', $user_id)->first();

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
                $sponsorship->start_date = date("Y-m-d H:i:s");
                $sponsorship->end_date = Carbon::now()->addHours(48);
                $sponsorship->doctor_id = $doctor->id;
                $sponsorship->sponsor_id = $selectedSponsor->id;

                $sponsorship->save();
                // $message = [
                //     'status' => true,
                //     'message' => 'Il pagamento è stato effettuato con successo'
                // ];
                return to_route('admin.sponsorship.form');
            } else {
                return response()->json(['success' => false, 'error' => 'Errore durante il pagamento']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
