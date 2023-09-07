@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="bg">
            <h1 class="mt-2">Sponsorizza il tuo profilo</h1>

            @if (session('msg'))
                <div class="alert alert-success">
                    {{ session('msg') }}
                </div>
            @endif

            @if (session('err'))
                <div class="alert alert-danger">
                    {{ session('err') }}
                </div>
            @endif

            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sponsorship.payment') }}">
                @csrf
                <div class="row">
                    @foreach ($sponsors as $sponsor)
                        <div class="col-md-4">
                            <label for="selected_package{{$loop->index}}">
                                <div class="card mt-2 sponsor-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sponsorizza il tuo profilo per {{ $sponsor->hours }} ore </h5>
                                        <p class="card-text">{{ $sponsor->price }} €</p>
                                        <input type="radio" name="selected_package" id="selected_package{{$loop->index}}" checked value="{{ $sponsor->id }}"> Seleziona
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-warning mt-2">Passa ai dettagli del pagamento</button>
            </form>

            <div class="row">
                @foreach ($sponsoredDoctors as $item)
                    <div class="col-md-4">
                        <div class="card mt-2">
                            <div class="card-body">
                                @if ($loop->first)
                                    <div class="card-title">Sponsorizzazione attiva </div>
                                @else 
                                    <div class="card-title">Sponsorizzazione futura </div>
                                @endif
                                <div class="card-text">Data inizio: {{ date("d-m-Y H:i:s" ,strtotime($item->start_date)) }}</div>
                                <div class="card-text">Data fine: {{ date("d-m-Y H:i:s" ,strtotime($item->end_date)) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
