@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
                <h1>MESSAGGI RICEVUTI</h1>

                @foreach ($messages as $message)
                    <div class="col-12">
                        <div class="card mb-3 ">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Mittente: {{ $message->full_name }}</h4>
                                </div>
                                <div class="card-subtitle">
                                    Mail: {{ $message->mail }} <br>
                                    {{ $message->date }}
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    <h5>Testo del messaggio:</h5>
                                    {{ $message->text }}
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
        </div>
    </div>
@endsection
