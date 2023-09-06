@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mt-2">Sponsorizza il tuo profilo</h1>

        @if (isset($message))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sponsorship.payment') }}">
            @csrf
            <div class="row">
                @foreach ($sponsors as $sponsor)
                    <div class="col-4">
                        <div class="card mt-2">
                            <div class="card-body">
                                <h5 class="card-title">Sponsorizza il tuo profilo per {{ $sponsor->hours }} ore </h5>
                                <p class="card-text">{{ $sponsor->price }} €</p>
                                <input type="radio" name="selected_package" value="{{ $sponsor->id }}"> Seleziona
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-warning mt-2">Passa ai dettagli del pagamento</button>
        </form>
    </div>
@endsection
