@extends ('layouts.admin')


@section('content')

            <div class="col-md-9 col-lg-10 ms-sm-auto px-3 margCard overflow-hidden">
                <div class="container mt-5 me-5 relative borders p-3 query_margin max_width">
                    <div class="elements d-flex align-items-center justify-content-around">
                        <div class="d-flex me-5">
                            @if ($doctor->image == null)
                                <p class="text-danger">Aggiorna il profilo e inserisci la foto profilo</p>
                            @else
                                <img class="img-fluid" src="{{ asset('storage/' . $doctor->image) }}" alt="">
                            @endif
                        </div>
                        <div class="text-center">
                            <div class="mb-5 mt-1">
                                <h1 class="fw-bold text-black">{{ $doctor->user->name }}</h1>
                            </div>
        
                            <div>
                                    <span class="rating-label fs-3">⭐</span>
                                <strong>{{ $averageRating }}</strong>
                            </div>
        
                            <hr>
                            <div class="mb-3">
                                @if (count($doctor->specialties) > 1)
                                    <h6 class="fw-bold text-black">Specializzazioni</h6>
                                    @foreach ($doctor->specialties as $specialty)
                                        @if ($loop->last)
                                            <span class="text-black">{{ $specialty->name }}.</span>
                                        @else
                                            <span class="text-black">{{ $specialty->name }},</span>
                                        @endif
                                    @endforeach
                                @else
                                    <h6 class="fw-bold text-black">Specializzazione <i class="fa-solid fa-stethoscope text-black"></i>
                                    </h6>
                                    @foreach ($doctor->specialties as $specialty)
                                        <span class="text-black">{{ $specialty->name }}.</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-3">
                                <h6 class="fw-bold text-black">Prestazioni <i class="fa-solid fa-syringe"></i></h6>
                                @if ($doctor->service == null)
                                    <p class="text-danger">Aggiorna il profilo e inserisci le prestazioni che offri</p>
                                @else
                                    <p class="text-black">{{ $doctor->service }}</p>
                                @endif
                            </div>
                            <hr>
                            <div class="mb-3">
                                <h5 class="text-black">Contatti <i class="fa-solid fa-map-pin text-black"></i></h5>
                                <h6 class="fw-bold text-black">Città</h6> <span class="text-black">{{ $doctor->city }}</span>
                                <h6 class="fw-bold text-black">Indirizzo</h6> <span class="text-black">{{ $doctor->address }}</span>
                                <h6 class="fw-bold text-black">Telefono</h6>
                                @if ($doctor->phone_number == null)
                                    <p class="text-danger">Aggiorna il profilo e inserisci il numero di telefono</p>
                                @else
                                    <span class="text-black">{{ $doctor->phone_number }} </span>
                                @endif
                            </div>
                            <div>
                                @if ($doctor->curriculum == null)
                                    <p class="text-danger">Aggiorna il profilo e inserisci il curriculum</p>
                                @else
                                    <a target="_blank" href="{{ asset('storage/' . $doctor->curriculum) }}">
                                        <p class="fw-bold text-black">Curriculum</p>
                                    </a>
                                @endif
                            </div>
                        </div>
        
                        <div class="">
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn">
                                <i class="fa-solid fa-user-pen size text-black"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
   
    <style>
        .size {
            width: 3rem;
        }

        .borders {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border-radius: 10px;
            background-color: rgb(248, 249, 250);
            border: 2px solid #313131;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
        }

        h6 {
            margin: 0;
        }

        hr {
            color: black;
        }
    </style>
@endsection
