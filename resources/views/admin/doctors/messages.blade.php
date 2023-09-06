@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row text-center mt-5 mb-5 bg borders ">
            <h1>MESSAGGI RICEVUTI</h1>
        </div>
        @if (count($messages) == 0)
                <h2>Non ci sono messaggi da visualizzare</h2>
        @endif
        <div class="row me-5 bg">
            @foreach ($messages as $message)
                <div class="col-12 col-md-6 col-lg-3 col-xl-2 h-100">
                    <div class="card mb-3 messandreview_bg pointer " data-bs-toggle="modal" data-bs-target="#message{{ $loop->index }}">
                        <div class="card-header">
                            <h6><i class="fa-solid fa-envelope"></i></h6>
                            <div class="card-title">
                                 {{ $message->full_name }}</h4>
                            </div>
                            <div class="card-subtitle">
                                {{ $message->date }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bg" id="message{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="messageLabel{{ $loop->index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <h1 class="modal-title fs-5" id="messageLabel{{ $loop->index }}">{{ $message->full_name }}
                                    </h1>
                                    <h5><a href="mailto:{{ $message->mail }}">{{ $message->mail }}</a></h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Testo del messaggio:</h5>
                                <p>{{ $message->text }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn_close" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  
@endsection