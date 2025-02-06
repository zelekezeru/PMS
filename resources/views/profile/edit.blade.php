@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card">
            <x-slot name="header">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </x-slot>

            <div class="container py-5">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @include('profile.partials.uploadProfileImage')
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-8 col-lg-6 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
