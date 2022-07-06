@extends('layouts.main_layout')

@section('content')
    <div class="">

        <section class="section">
            <div class="section-header">
                <h3 class="text-center mt-5">Bienvenue sur votre dashboard cher <b> {{ Auth::user()->name }}</b></h3>
            </div>
        </section>
        @if (Auth::user()->role == 'appartement' || Auth::user()->role === 'admin')
            <section class="section">
                <div class="section-header">
                    <h1>Points des appartements</h1>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <h3 class="text-center text-white mt-4"> {{ $total_appartement }}</h3>

                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total des appartements</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <h3 class="text-center text-white mt-4"> {{ $active_appartement }}</h3>

                            </div>

                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Appartements en activité</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">

                            <div class="card-icon bg-success">
                                <h3 class="text-center text-white mt-4"> {{ $available_appartement }}</h3>

                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Appartements Disponibles</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <h3 class="text-center text-white mt-4"> {{ $disabled_appartement }}</h3>

                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Appartements hors service</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        @if (Auth::user()->role == 'vehicule' || Auth::user()->role === 'admin')
            <section class="section">
                <div class="section-header">
                    <h1>Points des voitures</h1>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <h3 class="text-center text-white mt-4"> {{ $total_vehicle }}</h3>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total des voitures</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <h3 class="text-center text-white mt-4"> {{ $active_vehicle }}</h3>
                            </div>

                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Voitures en activité</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">

                            <div class="card-icon bg-success">
                                <h3 class="text-center text-white mt-4"> {{ $available_vehicle }}</h3>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Voitures Disponibles</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <h3 class="text-center text-white mt-4"> {{ $disabled_appartement }}</h3>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Voitures hors service</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


    </div>
    <style>
        @media (max-width: 1024px) {
            .main-content {
                padding-left: 2rem;
                padding-right: 2rem;
                padding-top: 80px;
                width: 100%;
                position: relative;
            }
        }
    </style>
@endsection
