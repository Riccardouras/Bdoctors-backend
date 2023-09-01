@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrati') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome Completo *') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="city"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Città *') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text"
                                        class="form-control @error('city') is-invalid @enderror" name="city"
                                        value="{{ old('city') }}" required autocomplete="city">

                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo *') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" required autocomplete="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-block btn-group mb-3" role="group">
                                <p class="mb-3">Specializzazione/i*</p>
                                <div class="row">
                                    @php
                                    $currentLetter = ''; 
                                    @endphp
                                
                                    @foreach ($specialtiesArray as $i => $specialty)
                                        @php
                                        $firstLetter = substr($specialty->name, 0, 1);
                                
                                        if ($currentLetter !== $firstLetter) {
                                            if ($i > 0) {
                                                echo "</div>";
                                            }
                                            echo "<div class='col-4 mb-3'>";
                                            echo "<div style='background-color:#BDDAF2' class='p-1'><h6>{$firstLetter}:</h6></div>";
                                
                                            $currentLetter = $firstLetter;
                                        }
                                        @endphp
                                
                                        <div class="form-check">
                                            <input type="checkbox" value="{{ $specialty->id }}" class="form-check-input"
                                            id="specialty{{ $i }}" name="specialty[]" @checked (in_array($specialty->id, old('specialty') ?? ['chiave' => 'valore']))>
                                            <label for="specialty{{ $i }}" class="form-check-label"> {{ $specialty->name }}</label>
                                        </div>
                                
                                        @if ($loop->last)
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                          

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail *') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password *') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password *') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
