@extends('layouts.admin')

@section('content')
    <div class="container my-3">
        <div class="row">

            <h1>MODIFICA PROFILO</h1>

            @if ($errors->any())
                
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            @endif

            <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="needs-valiation" enctype="multipart/form-data">
            
                @csrf

                @method('PUT')

                <label for="name">Nome</label>
                <input type="text" class="form-control mb-3" name="name" id="name" value="{{ $doctor->user->name }}">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="city">Città</label>
                <input type="text" class="form-control mb-3" name="city" id="city" value="{{ $doctor['city'] }}">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="address">Indirizzo</label>
                <input type="text" class="form-control mb-3" name="address" id="address" value="{{ $doctor['address'] }}">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="phone_number">Telefono</label>
                <input type="text" class="form-control mb-3" name="phone_number" id="phone_number" value="{{ $doctor['phone_number'] }}">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="service">Prestazioni</label>
                <input type="text" class="form-control mb-3" name="service" id="service" value="{{ $doctor['service'] }}">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="profile_img">Immagine di profilo</label>
                <input type="file" class="form-control mb-3" name="profile_img" id="profile_img">
                @error('profile_img')
                    <div class="text-danger mb-3"></div>
                @enderror

                <span>Specializzazione/i</span>
                <div class="d-block btn-group mb-3" role="group">
                    @foreach ($specialtiesArray as $i => $specialty)
                        <input type="checkbox" value="{{$specialty->id}}" class="btn-check" id="specialty{{$i}}" name="specialty[]" @checked ( in_array( $specialty->id, old('specialties') ?? $doctor->specialties->pluck('id')->toArray()))>
                        <label for="specialty{{$i}}" class="btn btn-outline-primary mb-1 rounded-0 mx-0"> {{ $specialty->name }}</label>
                    @endforeach
                </div>
                @error('specialty')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <input type="submit" class="form-control btn btn-primary"> 
            </form>
        </div>
    </div>
@endsection