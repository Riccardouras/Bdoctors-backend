@extends ('layouts.admin')


@section('content')

    {{-- <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('admin.doctors.edit', $doctor)}}" class="btn btn-warning">
            <i class="fa-solid fa-user-pen"></i>
        </a>
    </div>
    <h1>PROFILO DI : <p class=" text-uppercase">{{$doctor->user->name}}</p> </h1>

    <div>
        
        <br>
        
        <p class="fw-bold">Città:</p>  {{ $doctor->city }} <br>
        <p class="fw-bold">Indirizzo:</p>  {{ $doctor->address }} <br>
        <p class="fw-bold">Telefono:</p>
        @if ($doctor->phone_number == null)
            <p class="text-danger">Aggiorna il profilo e inserisci il numero di telefono</p> <br>
        @else
            {{ $doctor->phone_number }} <br>
        @endif

        <p class="fw-bold">Prestazioni:</p>
        @if ($doctor->service == null)
            <p class="text-danger">Aggiorna il profilo e inserisci le prestazioni che offri</p> <br>
        @else
            {{ $doctor->service }} <br>
        @endif
        @if ($doctor->curriculum == null)
            <p class="text-danger">Aggiorna il profilo e inserisci il curriculum</p>
        @else
            <a target="_blank" href="{{ asset('storage/'. $doctor->curriculum) }}"><p class="fw-bold">Curriculum</p></a> <br>
        @endif
        <br>
       
    </div> --}}

    <div class="mt-5 me-5 relative borders p-3">
        <div class="d-flex  align-items-center pl-3">
            <div class="d-flex me-5">
                    @if ($doctor->image == null)
                    <p class="text-danger">Aggiorna il profilo e inserisci la foto profilo</p>
                @else
                    <img src="{{ asset('storage/'. $doctor->image) }}" alt="">
                @endif
            </div>
            <div class="">
                <div class="mb-5">
                    <h1 class="fw-bold">{{ $doctor->user->name }}</h1>
                </div>
                <hr>
                <div class="mb-3">
                    @if (count($doctor->specialties)>1)
                    <h6 class="fw-bold">Specializzazione</h6> 
                        @foreach ($doctor->specialties as $specialty)
                            @if ($loop->last)
                                <span class="">{{ $specialty->name }}.</span>
                            @else
                                <span class="">{{ $specialty->name }},</span>
                            @endif
                        @endforeach
                        
                        @else
                            <h6 class="fw-bold">Specializzazione <i class="fa-solid fa-stethoscope"></i></h6>
                            @foreach ($doctor->specialties as $specialty)
                                <span class="">{{ $specialty->name }},</span>
                            @endforeach
                        @endif   
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold">Prestazioni <i class="fa-solid fa-syringe"></i></h6>
                    @if ($doctor->service == null)
                        <p class="text-danger">Aggiorna il profilo e inserisci le prestazioni che offri</p> 
                    @else
                        {{ $doctor->service }} 
                    @endif
                </div>
                <hr>
                <div class="mb-3">
                    <h5>Contatti <i class="fa-solid fa-map-pin"></i></h5>
                    <h6 class="fw-bold">Città</h6>  {{ $doctor->city }} 
                    <h6 class="fw-bold">Indirizzo</h6>  {{ $doctor->address }} 
                    <h6 class="fw-bold">Telefono</h6>
                    @if ($doctor->phone_number == null)
                        <p class="text-danger">Aggiorna il profilo e inserisci il numero di telefono</p> 
                    @else
                        {{ $doctor->phone_number }} 
                    @endif
                </div>
                <div>
                    @if ($doctor->curriculum == null)
                    <p class="text-danger">Aggiorna il profilo e inserisci il curriculum</p>
                @else
                    <a target="_blank" href="{{ asset('storage/'. $doctor->curriculum) }}"><p class="fw-bold">Curriculum</p></a> 
                @endif
                </div>
            </div>
            
            <div class="absolute">
                <a href="{{ route('admin.doctors.edit', $doctor)}}" class="btn">
                    <i class="fa-solid fa-user-pen size"></i>
                </a>
            </div>  
        </div>
    </div>
    <style>
        img{
            width: 28rem;
            border-radius: 20pc;
            padding-left: 1rem; 
        }
        .absolute{
            position: absolute;
            top: 4%;
            right: 0%;
        }
        .relative{
            position: relative;
        }
        .size{
            width: 3rem;
        }
        .borders{
            background-color: #BDDAF2; 
            /* border: 2px solid #2980b9;  */
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); 
        }
        h6{
            margin: 0;
        }
        main{
            background-color: #dbe1e6;
        }
    </style>
@endsection
