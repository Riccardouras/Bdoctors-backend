@extends ('layouts.admin')


@section('content')
    <h1>PROFILO DI : <span class=" text-uppercase">{{$doctor->user->name}}</span> </h1>

    <div>

        <div>
            <span class="fw-bold">Nome:</span>  {{ $doctor->user->name }} <br>
            <span class="fw-bold">Città:</span>  {{ $doctor->city }} <br>
            <span class="fw-bold">Indirizzo:</span>  {{ $doctor->address }} <br>
            <span class="fw-bold">Telefono:</span>  {{ $doctor->phone_number }} <br>
            <span class="fw-bold">Prestazioni:</span>  {{ $doctor->service }} <br>
            <img src="{{ $doctor->img_path }}" alt="">
            <img src="{{ $doctor->cv_path }}" alt="">
        </div>

    </div>
@endsection
