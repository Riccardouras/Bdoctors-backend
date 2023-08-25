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
            <span class="fw-bold">Specializzazione</span>
            {{$doctor->specialties[0]->name}}
        @endif
        <br>
        
        <span class="fw-bold">Città:</span>  {{ $doctor->city }} <br>
        <span class="fw-bold">Indirizzo:</span>  {{ $doctor->address }} <br>
        <span class="fw-bold">Telefono:</span>  {{ $doctor->phone_number }} <br>
        <span class="fw-bold">Prestazioni:</span>  {{ $doctor->service }} <br>
        <a href="{{ asset('storage/'. $doctor->curriculum) }}"><span class="fw-bold">Curriculum</span></a> <br>
        <img src="{{ asset('storage/'. $doctor->image) }}" alt="">
        <img src="{{ $doctor->curriculum }}" alt="">
    </div>

    

@endsection
