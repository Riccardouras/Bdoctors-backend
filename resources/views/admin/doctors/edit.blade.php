@extends('layouts.admin')

@section('content')
    <div class="container my-3">

        <h1>MODIFICA PROFILO</h1>

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="needs-valiation"
            enctype="multipart/form-data">

            @csrf

            @method('PUT')

            <label for="name">Nome Completo</label>
            <input type="text" class="form-control mb-3  @error('name') is-invalid @enderror" name="name" id="name"
                value="{{ old('name') ? old('name') : $doctor->user->name }}" required minlength="5" maxlength="30">
            @error('name')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <label for="city">Città</label>
            <input type="text" class="form-control mb-3  @error('city') is-invalid @enderror" name="city"
                id="city" value="{{ old('city') ? old('city') : $doctor['city'] }}" required maxlength="30">
            @error('city')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <label for="address">Indirizzo</label>
            <input type="text" class="form-control mb-3  @error('address') is-invalid @enderror" name="address"
                id="address" value="{{ old('address') ? old('address') : $doctor['address'] }}" required maxlength="100">
            @error('address')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <label for="phone_number">Telefono</label>
            <input type="text" class="form-control mb-3  @error('phone_number') is-invalid @enderror" name="phone_number"
                id="phone_number" value="{{ old('phone_number') ? old('phone_number') : $doctor['phone_number'] }}"
                maxlength="20">
            @error('phone_number')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <label for="service">Prestazioni</label>
            <input type="text" class="form-control mb-3  @error('service') is-invalid @enderror" name="service"
                id="service" value="{{ old('service') ? old('service') : $doctor['service'] }}" maxlength="2000">
            @error('service')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <label for="image">Immagine di profilo (MAX: 5MB)</label>
            <input type="file" class="form-control mb-3  @error('image') is-invalid @enderror" name="image"
                id="image">
            @error('profile_img')
                <div class="text-danger mb-3"></div>
            @enderror
            <div class="d-flex gap-4">
                @if ($doctor->image != null)
                    <figure id="currentImg" class="figure w-25">
                        <img class="figure-img img-fluid img-thumbnail" src="{{ asset('storage/' . $doctor->image) }}"
                            alt="currentImg">
                        <figcaption class="figure-caption">Current Image</figcaption>
                    </figure>
                @endif
                <figure class="figure w-25">
                    <img class="figure-img img-fluid img-thumbnail" id="imgPreview" src="#" alt="myImg"
                        style="display:none" />
                    <figcaption id="figCapPreview" class="figure-caption" style="display:none">Image Preview
                    </figcaption>
                </figure>
            </div>

            <label for="curriculum">Curriculum (PDF)</label>
            <input type="file" class="form-control mb-3  @error('curriculum') is-invalid @enderror" name="curriculum"
                id="curriculum">
            @error('curriculum')
                <div class="invalid-feedback mb-3">{{ $message }}</div>
            @enderror
            <div class="d-flex gap-4">
                @if ($doctor->curriculum != null)
                    <div>
                        <embed id="currentCv" src="{{ asset('storage/' . $doctor->curriculum) }}" />
                    </div>
                @endif

                <embed id="cvPreview" style="display: none" src="#" />
            </div>


            <span>Specializzazione/i</span>
            <div class="d-block btn-group mb-3" role="group">
                <?php $currentLetter = null; ?>
                @foreach ($specialtiesArray as $i => $specialty)
                    <?php
                    $firstLetter = substr($specialty->name, 0, 1);
                    if ($currentLetter !== $firstLetter) {
                        $currentLetter = $firstLetter;
                        echo "<h5>{$currentLetter}:</h5>";
                    }
                    ?>
                    <input type="checkbox" value="{{ $specialty->id }}" class="btn-check"
                        id="specialty{{ $i }}" name="specialty[]"
                        @if (in_array($specialty->id, old('specialty') ?? $doctor->specialties->pluck('id')->toArray())) checked @endif>
                    <label for="specialty{{ $i }}" class="btn btn-outline-primary mb-1 rounded-0 mx-0">
                        {{ $specialty->name }}</label>
                @endforeach
            </div>
            @error('specialty')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror
            <div class="d-flex justify-content-between">
                <input type="submit" class="btn btn-primary">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target="#delete">
                    Rimuovi Profilo
                </button>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteLabel">La cancellazione del profilo è
                            irreversibile, sicuro di voler continuare?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Torna
                            indietro</button>
                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Cancella utente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- add image preview --}}
    <script>
        image.onchange = evt => {
            preview = document.getElementById('imgPreview');
            capPreview = document.getElementById('figCapPreview');
            preview.style.display = 'block';
            capPreview.style.display = 'block';
            const [file] = image.files
            if (file) {
                preview.src = URL.createObjectURL(file)
                currentImg = document.getElementById('currentImg');
                currentImg.style.opacity = '0.4';
            }
        }
        // const curriculum = document.getElementById('curriculum');
        curriculum.onchange = evt => {
            cvPreview = document.getElementById('cvPreview');
            cvPreview.style.display = 'block';

            const [file] = curriculum.files;
            if (file) {
                cvPreview.src = URL.createObjectURL(file);
                currentCv = document.getElementById('currentCv');
                currentCv.style.opacity = '0.4';
            }
        }

        // delete confirmation with js
        // *******************************
        // function confirmation() {
        //     let result = confirm("La cancellazione del profilo è irreversibile! Sei sicuro di voler continuare?");
        //     if (!result) {
        //         event.preventDefault()
        //     }
        // }
    </script>
@endsection
