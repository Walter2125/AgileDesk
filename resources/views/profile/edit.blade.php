@extends('layouts.app')

@section('mensaje-superior')
            Perfil de Usuario
        @endsection
@section('content')

    <div class="py-2">
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection