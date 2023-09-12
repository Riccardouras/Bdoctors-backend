@extends('layouts.admin')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 p-0 overflow-hidden">
        <div class="backgroundHeader">
            <header-section class="d-flex flex-column justify-content-center h-100">
                <h1>Sponsorizza il tuo profilo</h1>
            </header-section>
        </div>
        <div class="container">
            <div class="bg">
                <div class="row text-center">
                    <div class="col-12">
                        @if (session('msg'))
                            <div class="card alert alert-success mt-4">
                                {{ session('msg') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="card alert alert-danger mt-4">
                                {{ session('err') }}
                            </div>
                        @endif
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sponsorship.payment') }}">
                    @csrf
                    <div class="row">
                        @foreach ($sponsors as $sponsor)
                            <div class="col-12 col-lg-4 d-flex justify-content-center mb-2">
                                <label for="selected_package{{ $loop->index }}">
                                    <div class="card mt-2 border-5">
                                        <div class="card-body z-1 text-center">
                                            <h5 class="card-title titoloCard p-2">Sponsorizza il tuo profilo per
                                                {{ $sponsor->hours }} ore </h5>
                                            <p class="card-text sponsorPrice fs-3">{{ $sponsor->price }} €</p>
                                            <label class="radioButton">
                                                <input type="radio" value="{{ $sponsor->id }}" checked
                                                    id="selected_package{{ $loop->index }}" name="selected_package">
                                                <div class="checkmark"></div>
                                            </label>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 mb-3 col-12 d-flex justify-content-center">
                        <button class="bottone">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 24">
                                <path d="m18 0 8 12 10-8-4 20H4L0 4l10 8 8-12z"></path>
                            </svg>
                            Passa ai dettagli del pagamento
                        </button>
                    </div>
                </form>

                <div class="row justify-content-center">
                    @foreach ($sponsoredDoctors as $item)
                        <div class="col-12 col-lg-4 mt-2">
                            <div class="card my-2">
                                <div class="card-body text-center">
                                    @if ($loop->first)
                                        <div class="card-title titoloCard">
                                            <h5>Sponsorizzazione attiva</h5>
                                        </div>
                                    @else
                                        <div class="card-title titoloCard">
                                            <h5>Sponsorizzazione futura</h5>
                                        </div>
                                    @endif
                                    <div class="card-text"><strong>Data inizio:</strong>
                                        {{ date('d-m-Y H:i:s', strtotime($item->start_date)) }}</div>
                                    <div class="card-text"><strong>Data fine:
                                        </strong>{{ date('d-m-Y H:i:s', strtotime($item->end_date)) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
