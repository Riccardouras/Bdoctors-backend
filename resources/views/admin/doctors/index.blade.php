@extends ('layouts.admin')


@section('content')

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('admin.doctors.edit', $doctor)}}" class="btn btn-warning">
            MODIFICA PROFILO
        </a>
    </div>
    <h1>PROFILO DI : <span class=" text-uppercase">{{$doctor->user->name}}</span> </h1>

    <div>
        <span class="fw-bold">Nome:</span>  {{ $doctor->user->name }} <br>
        @if (count($doctor->specialties)>1)
            <span class="fw-bold">Specializzazioni:</span>
            @foreach ($doctor->specialties as $specialty)
                @if ($loop->last)
                    {{ $specialty->name }}
                @else
                    {{ $specialty->name }},
                @endif
            @endforeach
            
        @else
            <span class="fw-bold">Specializzazione:</span>
            @foreach ($doctor->specialties as $specialty)
                {{ $specialty->name }}
            @endforeach
        @endif
        <br>
        
        <span class="fw-bold">Città:</span>  {{ $doctor->city }} <br>
        <span class="fw-bold">Indirizzo:</span>  {{ $doctor->address }} <br>
        <span class="fw-bold">Telefono:</span>  {{ $doctor->phone_number }} <br>
        <span class="fw-bold">Prestazioni:</span>  {{ $doctor->service }} <br>
        @if ($doctor->curriculum == null)
            <span class="text-danger">Aggiorna il profilo e inserisci il curriculum</span>
        @else
            <a href="{{ asset('storage/'. $doctor->curriculum) }}"><span class="fw-bold">Curriculum</span></a> <br>
        @endif
        <br>
        @if ($doctor->image == null)
            <span class="text-danger">Aggiorna il profilo e inserisci la foto profilo</span>
        @else
            <img src="{{ asset('storage/'. $doctor->image) }}" alt="">
        @endif
    </div>

    

@endsection
