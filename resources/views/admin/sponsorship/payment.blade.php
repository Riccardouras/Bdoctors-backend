@extends('layouts.admin')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 p-0 overflow-hidden">
        <div class="backgroundHeader">
            <header-section class="d-flex flex-column justify-content-center h-100">
                <h1>Effettua il pagamento</h1>
            </header-section>
        </div>
        <div class="container margin">
            <div class="bg">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-5 mt-4" style="max-width: 20rem">
                            <div class="card-body z-1 text-center">
                                <h5 class="card-title titoloCard">Hai selezionato il pacchetto: {{ $selectedPackage->hours }}
                                    ore
                                </h5>
                                <p class="card-text sponsorPrice fs-3">{{ $selectedPackage->price }} €</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <!-- Form per il pagamento -->
                        <form id="payment-form" action="{{ route('admin.sponsorship.processpayment') }}" method="POST">
                            @csrf
                            <!-- Elemento per il modulo di pagamento di Braintree -->
                            <div id="bt-dropin"></div>
                            <input type="hidden" name="selected_package" id="selected_package"
                                value="{{ $selectedPackage->id }}">
                            <button class="bottone" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 24">
                                    <path d="m18 0 8 12 10-8-4 20H4L0 4l10 8 8-12z"></path>
                                </svg>
                                Effettua il pagamento</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script src="https://js.braintreegateway.com/web/dropin/1.32.0/js/dropin.min.js"></script>

        <!-- Il tuo script personalizzato per gestire il pagamento -->
        <script>
            let form = document.querySelector('#payment-form');
            let submitButton = form.querySelector('button[type="submit"]');

            let clientToken = "{{ $clientToken }}";

            braintree.dropin.create({
                authorization: clientToken,
                container: '#bt-dropin'
            }, function(createErr, instance) {
                if (createErr) {
                    console.error(createErr);
                    return;
                }

                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                        if (requestPaymentMethodErr) {
                            console.error(requestPaymentMethodErr);
                            return;
                        }

                        let nonceInput = document.createElement('input');
                        nonceInput.setAttribute('type', 'hidden');
                        nonceInput.setAttribute('name', 'payment_method_nonce');
                        nonceInput.setAttribute('value', payload.nonce);
                        form.appendChild(nonceInput);
                        form.submit();
                    });
                });
            });
        </script>
    </div>
@endsection
