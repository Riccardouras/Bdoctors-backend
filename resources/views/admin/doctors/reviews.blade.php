@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h1>RECENSIONI RICEVUTE</h1>

            @if (count($reviews) == 0)
                <h2>Non ci sono recensioni da visualizzare</h2>
            @endif

            @foreach ($reviews as $review)
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
            @endforeach
        </div>
    </div>
@endsection
