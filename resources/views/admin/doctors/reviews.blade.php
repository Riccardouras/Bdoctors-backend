@extends('layouts.admin')

@section('content')
        <div class="backgroundHeader">
            <header-section class="d-flex flex-column justify-content-center h-100">
                <h1>Recensioni ricevute</h1>
    
                @if (count($reviews) == 0)
                    <h2>Non ci sono recensioni da visualizzare</h2>
                @endif
        </header-section>
        </div>
        
        <section> 
            <div class="row bg ps-5 pe-5">
                @foreach ($reviews as $review)
                    <div class="col-xs-12 col-md-6 col-xl-4 gap-2 p-2">
                        <div class="card mb-3 pointer messandreview_bg " data-bs-toggle="modal"
                            data-bs-target="#review{{ $loop->index }}">
                            <div class="card-header h-50">
                                <div class="card-title">
                                    <h6><i class="fa-solid fa-comment"></i> </h6>
                                    <p>{{ $review->name }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ date('d-m-Y', strtotime($review->date)) }}
                            </div>
                        </div>
                    </div>
    
    
                    <div class="modal fade" id="review{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="Label{{ $loop->index }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h2 class="modal-title" id="reviewLabel{{ $loop->index }}"> {{ $review->name }}
                                        </h2>
                                        <h5>{{ $review->title }}</h5>
                                    </div>
                                    <button type="button" class="btn-close " data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Testo della recensione:</h5>
                                    <p>{{ $review->comment }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn_close" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        
@endsection











{{-- @foreach ($reviews as $review)
                <div class="col-12">
                    <div class="card mb-3 ">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>{{ $review->title }}</h4>
                            </div>
                            <div class="card-subtitle">
                                {{ $review->name }} <br>
                                {{ $review->date }}
                            </div>
                        </div>
                        <div class="card-body">
                            <p>
                            <h5>Testo della recensione:</h5>
                            {{ $review->comment }}
                            </p>
                        </div>

                    </div>
                </div>
            @endforeach --}}
