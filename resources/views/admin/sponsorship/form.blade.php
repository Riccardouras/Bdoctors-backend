@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Sponsorizza il tuo profilo</h1>

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sponsorship.payment') }}">
            @csrf

            <div class="form-group">
                <label for="package">Seleziona un pacchetto di sponsorizzazione:</label>
                <select class="form-control" id="package" name="selected_package">
                    @foreach ($sponsors as $sponsor)
                        <option value="{{ $sponsor->id }}">{{ $sponsor->name }}. {{ $sponsor->price }} </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-warning mt-2">Passa ai dettagli del pagamento</button>
        </form>
    </div>
@endsection
