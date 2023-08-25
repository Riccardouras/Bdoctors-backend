@extends('layouts.admin')

@section('content')
    <div class="container my-3">
        <div class="row">

            <h1>MODIFICA PROFILO</h1>

            @if ($errors->any())
                <div class="card border-danger">
                    <div class="card-title m-0">
                            <h2 class="text-danger m-0">ERRORI</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">
                                    {{ $error }}
                                </li>    
                            @endforeach
                        </ul>
                    </div>
                </div>
                
            @endif

            <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="needs-valiation" enctype="multipart/form-data">
            
                @csrf

                @method('PUT')

                <label for="name">Nome</label>
                <input type="text" class="form-control mb-3  @error('name') is-invalid @enderror" name="name" id="name" value="{{ $doctor->user->name }}" required minlength="5" maxlength="30">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="city">Città</label>
                <input type="text" class="form-control mb-3  @error('city') is-invalid @enderror" name="city" id="city" value="{{ $doctor['city'] }}" required max="30">
                @error('name')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="address">Indirizzo</label>
                <input type="text" class="form-control mb-3  @error('address') is-invalid @enderror" name="address" id="address" value="{{ $doctor['address'] }}" required max="100">
                @error('address')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="phone_number">Telefono</label>
                <input type="text" class="form-control mb-3  @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" value="{{ $doctor['phone_number'] }}" max="20">
                @error('phone_number')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="service">Prestazioni</label>
                <input type="text" class="form-control mb-3  @error('service') is-invalid @enderror" name="service" id="service" value="{{ $doctor['service'] }}" max="2000">
                @error('service')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <label for="image">Immagine di profilo (MAX: 5MB)</label>
                <input type="file" class="form-control mb-3  @error('image') is-invalid @enderror" name="image" id="image">
                @error('profile_img')
                    <div class="text-danger mb-3"></div>
                @enderror

                <label for="curriculum">Curriculum (PDF)</label>
                <input type="file" class="form-control mb-3  @error('curriculum') is-invalid @enderror" name="curriculum" id="curriculum">
                @error('curriculum')
                    <div class="invalid-feedback mb-3">{{ $message }}</div>
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