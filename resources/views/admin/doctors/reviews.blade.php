@extends('layouts.admin')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 p-0 overflow-hidden">
        <div class="backgroundHeader">
            <header-section class="d-flex flex-column justify-content-center h-100">
                <h1>Recensioni ricevute</h1>
            </header-section>
        </div>

        <!-- Pannello delle recensioni -->
        @if (count($reviews) == 0)
            <h2 class="text-center mt-4">Non ci sono recensioni da visualizzare</h2>
        @else
            <div class="card border-0">
                <div class="card-body">
                    <table class="my-table table table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-none d-md-table-cell">Da <i class="fa-solid fa-user"></th>
                                <th>Titolo <i class="fa-solid fa-envelope"></i></th>
                                <th class="d-none d-sm-table-cell">Data <i class="fa-regular fa-calendar"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr class="messandreview_bg pointer " data-bs-toggle="modal"
                                    data-bs-target="#message{{ $loop->index }}">
                                    <td class="d-none d-md-table-cell">{{ $review->name }}</td>
                                    <td>{{ $review->title }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $review->date }}</td>
                                </tr>

                                {{-- modale --}}
                                <div class="modal fade bg" id="message{{ $loop->index }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="messageLabel{{ $loop->index }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div>
                                                    <h3 class="modal-title" id="messageLabel{{ $loop->index }}">
                                                        {{ $review->title }}
                                                    </h3>
                                                    <h5>{{ $review->name }}</h5>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Testo del messaggio:</h5>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn_close" data-bs-dismiss="modal">Chiudi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
