@extends('layouts.main_layout')

@section('content')
    <div class="">
        <div class="row" style="width: 100%">
            <div class="col">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <h1 id="total" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>

            <div class="col">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Occupés</h5>
                        <h1 id="active_appartement" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Disponibles</h5>
                        <h1 id="available_appartement" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Suspendus</h5>
                        <h1 id="disabled_appartement" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Réservés</h5>
                        <h1 id="reserve_appartement" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto ">

        <h2 class="text-center m-4">Formulaire de Recherche</h2>
        <div id="screeresult" role="alert">
        </div>


        <form id="search-form" action="javascript:search()">
            @csrf <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input id="date_debut" type="date" name="date_debut" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input id="date_fin" type="date" name="date_fin" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm pt-4">
                    <div class="form-group  pl-4">

                        <button type="submit" id="submit" class="btn btn-primary">Rechercher</button>
                        <a id="close_btn" class="m-2 text-white btn btn-info">Rechargées les données</a>
                    </div>
                </div>
        </form>

    </div>

    <div class="row">

        <div class="col-12 mt-5">
            <div class="card">
                <div class="section-header">
                    <h2 id="title_datatable" class="text-center">Listes des recapitulatifs pour chaque appartement de ce mois</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="appart-table">
                            <thead>
                                <tr>
                                    <th>
                                        Matricule
                                    </th>
                                    <th>Chiffre d'affaire cumulé</th>
                                    <th>Statut actuel</th>

                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>

    </div>
    <style>
        .badge.badge-success {
            background-color: #27973a !important;
        }

        .btn-secondary,
        .btn-secondary.disabled {
            box-shadow: 0 2px 6px #e1e5e8;
            background-color: #6777ef;
            border-color: #cdd3d8;
            color: #fff;
        }



        @media (max-width: 900px) {
            .main-content {
                padding-left: 2rem;
                padding-right: 2rem;
                padding-top: 80px;
                width: 100%;
                position: relative;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            moment.locale('en')
            loadRecap()
            chargeRecapDate()
        });

        function chargeRecapDate() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getAppartRecapData') }}',
                method: 'GET',
                success: function(response) {
                    try {

                        $('#total').html(response.total);
                        $('#disabled_appartement').html(response.disabled_appartement);
                        $('#active_appartement').html(response.active_appartement);
                        $('#available_appartement').html(response.available_appartement);
                        $('#reserve_appartement').html(response.reserve_appartement);


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                },
            });
        }

        function formatDate(str) {
            return moment(str).subtract(0, "hour").format("DD-MM-YYYY, h:mm:ss");
        }

        function search() {


            var frm = $('#search-form');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('recapApparts') }}',
                method: 'POST',
                data: frm.serialize(),
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);

                    let result = JSON.parse(data).data


                    try {

                        if (result.length != 0) {
                            $('#search-form')[0].reset();
                            $("#screeresult").html("Recherche bien effecttuée");
                            $("#screeresult").show();

                            $('#title_datatable').html("Résultats de la recherche")

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                            }, 3000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);
                        } else {
                            $('#search-form')[0].reset();
                            $("#screeresult").html("Aucune donné trouvée(s)");
                            $("#screeresult").show();

                            $('#title_datatable').html("Résultats de la recherche")

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-warning");
                            setTimeout(function() {
                                $("#screeresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);

                        }
                        //datatable reload

                        $('#appart-table').DataTable({
                            destroy: true,
                            responsive: true,
                            orderCellsTop: true,
                            fixedHeader: true,
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excelHtml5',
                                text: '<i class="mdi mdi-file-excel"></i> Exporter'
                            }, ],
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                            },
                            "order": [
                                [0, 'desc']
                            ],
                            "data": result,
                            "columns": [

                                {
                                    "data": "code"
                                },
                                {
                                    "data": "ca_total"
                                },
                                {
                                    "data": "current_state"
                                },


                            ],
                            "columnDefs": [

                                {
                                    "targets": -1,
                                    "data": "status",
                                    render: function(data, type, row, meta) {

                                        if (data == 'LIBRE') {
                                            return "<div class='badge badge-success h1'>LIBRE </div>";

                                        } else {
                                            return "<div class='badge badge-danger h1'> OCCUPÉ</div>  ";

                                        }
                                    },
                                },

                            ]
                        });

                    } catch (error) {
                        $("#screeresult").show();

                        $("#screeresult").removeClass("alert alert-success");
                        $("#screeresult").removeClass("alert alert-danger");
                        $("#screeresult").addClass("alert alert-danger");
                        $("#screeresult").html('Une erreur s\'est produite veuillez ressayer').show();

                        setTimeout(function() {
                            $("#screeresult").hide();

                        }, 2000); //wait 2 seconds


                    }


                },
            });
        }


        $('#close_btn').click(function() {
            $('#title_datatable').html("Listes des recapitulatifs pour chaque appartements de ce mois")
            loadRecap();
            chargeRecapDate();
        })


        function loadRecap() {

            var frm = $('#search-form');
            $.ajax({


                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('recapApparts') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    data: frm.serialize(),
                },
                success: function(response) {

                    $('#appart-table').DataTable({
                        destroy: true,
                        responsive: true,
                        orderCellsTop: true,
                        // fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="mdi mdi-file-excel"></i> Exporter'
                        }, ],
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                        "order": [
                            [0, 'desc']
                        ],
                        "data": JSON.parse(response).data,
                        "columns": [

                            {
                                "data": "code"
                            },
                            {
                                "data": "ca_total"
                            },
                            {
                                "data": "current_state"
                            },


                        ],
                        "columnDefs": [

                            {
                                "targets": -1,
                                "data": "status",
                                render: function(data, type, row, meta) {

                                    if (data == 'LIBRE') {
                                        return "<div class='badge badge-success h1'>LIBRE </div>";

                                    } else {
                                        return "<div class='badge badge-danger h1'> OCCUPÉ</div>  ";

                                    }
                                },
                            },

                        ]
                    });
                }

            });
        }
    </script>
@endsection
