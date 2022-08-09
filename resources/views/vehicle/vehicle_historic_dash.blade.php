@extends('layouts.main_layout')

@section('content')
    <div class="">
        <div class="row" style="width: 100%">
            <div class="col-md-3">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <h1 id="total" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Occupés</h5>
                        <h1 id="active_vehicle" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Disponibles</h5>
                        <h1 id="available_vehicle" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Suspendu</h5>
                        <h1 id="disabled_vehicle" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mx-auto ">

        <h2 class="text-center m-4">Formulaire de Recherche</h2>

        <div id="search_screeresult" role="alert">
        </div>


        <form id="search-form" action="javascript:search()">
            @csrf
            <div class="row">
                <div class="col-sm">
                    <div class="">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input id="date_debut" type="date" name="date_debut" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input id="date_fin" type="date" name="date_fin" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm pt-4">
                    <div class="pl-4">

                        <button type="submit" id="submit" class="btn btn-primary">Rechercher</button>
                        <a id="search_close" class="m-2 text-white btn btn-warning">Recharger les données</a>
                    </div>
                </div>
        </form>

    </div>


    <div class="row">
        <button id="new_vehicle_btn" class="m-5 btn btn-primary">Créer une nouvelle activité <i class="ml-3 fa fa-plus"
                aria-hidden="true"></i></button>

        <div id="new_vehicle_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none;margin-top:100px;">



            <h2 class="text-center mb-4">Enregistrer une nouvelle activité</h2>

            <div id="screenresult" role="alert">
            </div>

            <form id="historic-form" action="javascript:add_historic()">
                @csrf

                <div class="mb-3">

                    <div class="form-group">
                        <label for="vehicle_id" class="form-label">Matricule de la voiture</label>
                        <select id="matricul_select" class="form-control select2" name="vehicle_id"
                            style="width: 100%!important" required>
                            <option value="">Choisir le matricule de la voiture</option>
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="start_time" class="form-label" required>Heure de départ de la voiture</label>
                        <input id="start_time" type="datetime-local" name="start_time" class="form-control"
                            format="DD-MM-YY hh:mm:ss">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="start_km" class="form-label" required>Km départ de la voiture</label>
                    <input type="number" class="form-control" id="start_km" min="0"
                        oninput="this.value = Math.abs(this.value)" name="start_km"placeholder="Km départ de la voiture"
                        step="0.01" required>
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                <a id="close_btn" class="m-2 text-white btn btn-danger">Fermer</a>

            </form>

        </div>

        <div class="col-12 mt-5">
            <div clas s="card">
                <div lass="section-header">
                    <h1 id="title_datatable">Listes des activités de ce mois</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="vehicle-table">
                            <thead>
                                <tr>
                                    <th>
                                        Matricule
                                    </th>
                                    <th>Nom & couleur</th>
                                    <th>Heure de départ</th>
                                    <th>Heure d'arrivée</th>
                                    <th>Durée de conduite</th>
                                    <th>kM de départ</th>
                                    <th>kM de d'arrivée</th>
                                    <th>kM parcourus</th>
                                    <th>Chiffre d'affaire du jour</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                    {{-- <th>Durée du trajet </th>
                                <th>Status</th>
                                <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            {{-- /modal --}}

            <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de la voiture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screenresult" role="alert">
                            </div>
                            <form id="modal-historic-form" action="javascript:update_historic()">

                                @csrf
                                <input type="hidden" id="modal_historic_id" class="form-control" name="historic_id"
                                    required>
                                <input type="hidden" id="modal_travel_time" class="form-control" name="travel_time"
                                    required>
                                <input type="hidden" id="modal_vehicle_id" class="form-control" name="vehicle_id"
                                    required>


                                <div class="mb-3">

                                    <div class="form-group">
                                        <label for="vehicle_id" class="form-label">Matricule de la voiture</label>
                                        <input id="modal_matricul_select" class="form-control" name="vehicle_id"
                                            style="width: 100%!important" required>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label" required>Heure de départ de la
                                            voiture</label>
                                        <input id="modal_start_time" type="text" name="start_time"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="start_km" class="form-label" required>Km départ de la voiture</label>
                                    <input type="number" class="form-control"
                                        oninput="this.value = Math.abs(this.value)" id="modal_start_km" min="0"
                                        name="start_km" placeholder="Km départ de la voiture" step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <label for="arrival_time" class="form-label" required> Heure d'arrivée de la
                                        voiture</label>
                                    <input id="modal_arrival_time" type="datetime-local" name="arrival_time"
                                        class="form-control datetimepicker" onchange="endChange()">

                                </div>

                                <div class="mb-3">
                                    <label for="arrival_km" class="form-label" required>Km d'arrivée de la voiture</label>
                                    <input type="number" class="form-control"
                                        oninput="this.value = Math.abs(this.value)" id="modal_arrival_km"
                                        name="arrival_km" min="0" placeholder="Km d'arrivée de la voiture"
                                        step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <label for="amount_repaid" class="form-label" required>Montant reversé</label>
                                    <input type="number" class="form-control" min="0"
                                        oninput="this.value = Math.abs(this.value)" id="modal_amount_repaid"
                                        name="amount_repaid"placeholder="Montant reversé" required>
                                </div>

                                <button type="modal-submit" id="modal-submit"
                                    class="btn btn-primary">Enregistrer</button>
                                <a id="modal_close_btn" class="m-2 text-white btn btn-danger"
                                    data-dismiss="modal">Fermer</a>

                            </form>

                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        .badge.badge-success {
            /* background-color: #27973a !important; */
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
            moment.locale('fr')

            loadHistoric()
            getMatriculesList()
            $("#new_vehicle_div").hide();
            $("#screenresult").hide()


            $('#new_vehicle_btn').click(function() {
                $("#new_vehicle_div").show();
                $("#new_vehicle_btn").hide();

                $("#name").show().prop('required', true);

                $("#matricule").show().prop('required', true);

                $("#color").show().prop('required', true);

            });
            $('#close_btn').click(function() {

                $("#name").hide().prop('required', false);

                $("#matricule").hide().prop('required', false);

                $("#color").hide().prop('required', false);

                $("#new_vehicle_div").hide();
                $("#new_vehicle_btn").show();


                $('#historic-form')[0].reset();

            });

            chargeRecapDate()



        });

        $('#search_close').click(function() {
            $('#title_datatable').html("Listes des activitésde ce mois")
            loadHistoric()
            chargeRecapDate()
        })




        $('#close_modal').click(function() {

            $("#matricul_select").val("");

            $('#matricul_select').trigger('change');
        });

        function search() {
            var data = new FormData();
            //Form data
            var form_data = $('#search-form').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });

            $.ajax({
                url: '{{ route('getHistoric') }}',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop(
                        "disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);

                    let result = JSON.parse(data).data


                    try {

                        if (result.length != 0) {
                            $('#search-form')[0].reset();
                            $("#search_screeresult").show();
                            $("#search_screeresult").html("Recherche bien effectuée");

                            $("#search_screeresult").removeClass("alert alert-success");
                            $("#search_screeresult").removeClass("alert alert-danger");
                            $("#search_screeresult").addClass("alert alert-success");
                            $('#title_datatable').html("Résultats de la recherche")
                            setTimeout(function() {
                                $("#search_screeresult").hide();
                            }, 3000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);
                        } else {
                            $('#search-form')[0].reset();
                            $("#search_screeresult").show();
                            $("#search_screeresult").html("Aucune donné trouvée(s)");

                            $("#search_screeresult").removeClass("alert alert-success");
                            $("#search_screeresult").removeClass("alert alert-danger");
                            $("#search_screeresult").addClass("alert alert-warning");
                            $('#title_datatable').html("Résultats de la recherche")
                            setTimeout(function() {
                                $("#search_screeresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);

                        }
                        //datatable reload

                        $('#vehicle-table').DataTable({
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
                            "data": result,
                            "columns": [

                                {
                                    "data": "matricule"

                                },
                                {
                                    "data": "name"
                                },
                                {
                                    "data": "start_time"
                                },
                                {
                                    "data": "arrival_time"
                                },
                                {
                                    "data": "travel_time"
                                },
                                {
                                    "data": "start_km"
                                },
                                {
                                    "data": "arrival_km"
                                },
                                {
                                    "data": "travel_km"
                                },
                                {
                                    "data": "ca_daily"
                                },
                                {
                                    "data": "status"
                                },
                                {
                                    "data": "id"
                                },

                            ],
                            "columnDefs": [{
                                    "targets": -1,
                                    "data": "id",
                                    render: function(data, type, row, meta) {
                                        // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";

                                        return '<button value="' + data +
                                            '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-eye"></i></button> <button value="' +
                                            data +
                                            '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-pencil-alt"></i></button>';
                                    },
                                },
                                {
                                    "targets": -2,
                                    "data": "status",
                                    render: function(data, type, row, meta) {
                                        // console.log(data)
                                        if (data == "EN COURS") {
                                            return "<div class='badge badge-info'><h8>En cours</h8> </div>";

                                        } else if (data == "RESERVE") {
                                            return "<div class='badge badge-warning'> <h8>RESERVE</h8></div>  ";

                                        } else if (data == "TERMINE") {
                                            return "<div class='badge badge-success'> <h8>TERMINE</h8></div>  ";

                                        }
                                    },
                                },
                                {

                                    "targets": -10,
                                    "data": "name",
                                    render: function(data, type, row, meta) {
                                        // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                        return row.name + " " + row.color + "";
                                    },
                                },
                                {

                                    "targets": -8,
                                    "data": "arrival_time",
                                    render: function(data, type, row, meta) {
                                        // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                        if (row.travel_time) {
                                            return this.formatDate(row.arrival_time);
                                        } else {
                                            return ''
                                        }

                                    },
                                },
                                {

                                    "targets": -9,
                                    "data": "start_time",
                                    render: function(data, type, row, meta) {
                                        // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                        if (row.start_time) {
                                            return this.formatDate(row.start_time);
                                        } else {
                                            return ''
                                        }

                                    },
                                },



                            ]
                        });

                    } catch (error) {
                        $("#search_screeresult").show();

                        $("#search_screeresult").removeClass("alert alert-success");
                        $("#search_screeresult").removeClass("alert alert-danger");
                        $("#search_screeresult").addClass("alert alert-danger");
                        $("#search_screeresult").html('Une erreur s\'est produite veuillez ressayer').show();

                        setTimeout(function() {
                            $("#search_screeresult").hide();

                        }, 2000); //wait 2 seconds


                    }


                },
            });
        }

        function endChange() {


            let start_time
            let end_time


            if ($("#modal_arrival_time").val()) {
                end_time = formatDate($("#modal_arrival_time").val())
            }

            start_time = formatDate($("#modal_start_time").val())

            var beginningTime = moment(start_time, "DD-MM-YYYY, h:mm:ss");
            var endTime = moment(end_time, "DD-MM-YYYY, h:mm:ss");


            //test if end date is after begin date
            if (beginningTime.isBefore(endTime)) {

                $('#modal-submit').prop("disabled", false);

            } else {
                console.log("zeazrazer")
                $("#modal-screenresult").html("Veuillez renseigner une heure supérieure à l'heure de départ");
                $("#modal-screenresult").show();

                $("#modal-screenresult").removeClass("alert alert-success");
                $("#modal-screenresult").removeClass("alert alert-danger");
                $("#modal-screenresult").addClass("alert alert-danger");

                setTimeout(function() {
                    $("#modal-screenresult").hide();

                }, 2000); //wait 2 seconds
                $('#modal-submit').prop("disabled", true);

            }

        }


        $("#modal_arrival_km").keyup(function() {
            let start_km = Number($("#modal_start_km").val())


            let end_km = Number(this.value)

            if (start_km >= end_km) {


                $("#modal-screenresult").html("Veuillez renseigner un km supérieure au km de départ");
                $("#modal-screenresult").show();

                $("#modal-screenresult").removeClass("alert alert-success");
                $("#modal-screenresult").removeClass("alert alert-danger");
                $("#modal-screenresult").addClass("alert alert-danger");

                setTimeout(function() {
                    $("#modal-screenresult").hide();

                }, 2000); //wait 2 seconds
                $('#modal-submit').prop("disabled", true);
            } else {
                $('#modal-submit').prop("disabled", false);
            }
            // this.value = this.value.toLocaleUpperCase();
        });

        function chargeRecapDate() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getVehicleRecapData') }}',
                method: 'GET',
                success: function(response) {
                    try {

                        $('#total').html(response.total);
                        $('#disabled_vehicle').html(response.disabled_vehicle);
                        $('#active_vehicle').html(response.active_vehicle);
                        $('#available_vehicle').html(response.available_vehicle);


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

        function getMatriculesList() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getMatriculesList') }}',
                method: 'GET',
                success: function(response) {
                    let data = JSON.parse(response).data


                    $.each(data, function(i, item) {
                        $('#matricul_select').append($('<option>', {
                            value: item.id,
                            text: item.matricule
                        }));
                    });
                }

            });

        }

        function add_historic() {

            var frm = $('#historic-form');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('add_historic') }}',
                method: 'POST',
                data: frm.serialize(),
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop(
                        "disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#historic-form')[0].reset();
                            $("#screenresult").html(data.message);
                            $("#screenresult").show();

                            $("#screenresult").removeClass("alert alert-success");
                            $("#screenresult").removeClass("alert alert-danger");
                            $("#screenresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screenresult").hide();
                                loadHistoric();
                                chargeRecapDate();
                                getMatriculesList()
                            }, 2000); //wait 2 seconds

                            $("#matricul_select").val("");

                            $('#matricul_select').trigger('change');


                            $('#submit').html('Enregistrer').prop("disabled", false);


                        } else {
                            $("#screenresult").html(data.message);
                            $("#screenresult").show();

                            $("#screenresult").removeClass("alert alert-success");
                            $("#screenresult").removeClass("alert alert-danger");
                            $("#screenresult").addClass("alert alert-danger");
                            setTimeout(function() {
                                $("#screenresult").hide();

                            }, 2000); //wait 2 seconds


                            $('#submit').html('Enregistrer').prop("disabled", false);

                        }



                    } catch (error) {
                        $("#screenresult").show();

                        $("#screenresult").removeClass("alert alert-success");
                        $("#screenresult").removeClass("alert alert-danger");
                        $("#screenresult").addClass("alert alert-danger");
                        setTimeout(function() {
                            $("#screenresult").hide();

                        }, 2000); //wait 2 seconds

                        // $("#screenresult").html('Une erreur s\'est produite veuillez ressayer').show();

                    }

                },
                error: function(data) {

                    // location.reload();
                    // $("#screenresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        }

        function loadHistoric() {

            var data = new FormData();
            //Form data
            var form_data = $('#search-form').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });

            $.ajax({
                url: '{{ route('getHistoric') }}',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#vehicle-table').DataTable({
                        destroy: true,
                        responsive: true,
                        orderCellsTop: true,
                        // fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="mdi mdi-file-excel"></i> Exporter',
                            className: 'btn btn-primary'
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
                                "data": "matricule"

                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "start_time"
                            },
                            {
                                "data": "arrival_time"
                            },
                            {
                                "data": "travel_time"
                            },
                            {
                                "data": "start_km"
                            },
                            {
                                "data": "arrival_km"
                            },
                            {
                                "data": "travel_km"
                            },
                            {
                                "data": "ca_daily"
                            },
                            {
                                "data": "status"
                            },
                            {
                                "data": "id"
                            },

                        ],
                        "columnDefs": [{
                                "targets": -1,
                                "data": "id",
                                render: function(data, type, row, meta) {
                                    // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";

                                    return '<button value="' + data +
                                        '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-eye"></i></button> <button value="' +
                                        data +
                                        '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-pencil-alt"></i></button>';
                                },
                            },
                            {
                                "targets": -2,
                                "data": "status",
                                render: function(data, type, row, meta) {
                                    // console.log(data)
                                    if (data == "EN COURS") {
                                        return "<div class='badge badge-info'><h8>En cours</h8> </div>";

                                    } else if (data == "RESERVE") {
                                        return "<div class='badge badge-warning'> <h8>RESERVE</h8></div>  ";

                                    } else if (data == "TERMINE") {
                                        return "<div class='badge badge-success'> <h8>TERMINE</h8></div>  ";

                                    }
                                },
                            },
                            {

                                "targets": -10,
                                "data": "name",
                                render: function(data, type, row, meta) {
                                    // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                    return row.name + " " + row.color + "";
                                },
                            },
                            {

                                "targets": -8,
                                "data": "arrival_time",
                                render: function(data, type, row, meta) {
                                    // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                    if (row.travel_time) {
                                        return this.formatDate(row.arrival_time);
                                    } else {
                                        return ''
                                    }

                                },
                            },
                            {

                                "targets": -9,
                                "data": "start_time",
                                render: function(data, type, row, meta) {
                                    // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";
                                    if (row.start_time) {
                                        return this.formatDate(row.start_time);
                                    } else {
                                        return ''
                                    }

                                },
                            },



                        ]
                    });
                }

            });
        }

        function update_historic() {
            var frm = $('#modal-historic-form');

            let start_time = $("#modal_start_time").val();
            let arrival_time = $("#modal_arrival_time").val();

            let start_date = moment(start_time, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');

            let arrival_date = moment(arrival_time, 'YYYY-MM-DD HH:mm').format('DD-MM-YYYY HH:mm:ss');


            start_date = moment(start_date, 'DD-MM-YYYY HH:mm:ss')

            arrival_date = moment(arrival_date, 'DD-MM-YYYY HH:mm:ss')


            let seconds_result = arrival_date.diff(start_date, 'seconds')
            let minutes_result = arrival_date.diff(start_date, 'minutes')
            let hours_result = arrival_date.diff(start_date, 'hours')
            let days_result = arrival_date.diff(start_date, 'days')
            let months_result = arrival_date.diff(start_date, 'months')
            let years_result = arrival_date.diff(start_date, 'years')

            let travel_time


            if (seconds_result < 0) {

                travel_time = 0

            } else if (seconds_result > 3153600) {

                travel_time = years_result + ' An(s)'

            } else if (seconds_result > 2419200) {

                travel_time = months_result + ' Mois'

            } else if (seconds_result > 86400) {

                travel_time = days_result + ' Jours'

            } else if (seconds_result > 3600) {

                travel_time = hours_result + ' Heure(s)'

            } else if (seconds_result >= 60) {

                travel_time = minutes_result + 'Minute(s)'

            } else if (seconds_result < 60) {

                travel_time = seconds_result + ' Seconde(s)'
            }

            $("#modal_travel_time").val(travel_time);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateHistoric') }}',
                method: 'POST',
                data: frm.serialize(),
                beforeSend: function(data) {
                    console.log(data)
                    $('#modal-submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>')
                        .prop("disabled", true);
                },
                success: function(data) {
                    $('#modal-submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {

                            $("#modal-screenresult").html(data.message);
                            $("#modal-screenresult").show();

                            $("#modal-screenresult").removeClass("alert alert-success");
                            $("#modal-screenresult").removeClass("alert alert-danger");
                            $("#modal-screenresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#modal-screenresult").hide();
                                loadHistoric();
                                chargeRecapDate();
                                getMatriculesList()
                            }, 2000); //wait 2 seconds

                            $('#modal-submit').html('Enregistrer').prop("disabled", false);

                        } else {
                            $("#modal-screenresult").html(data.message);
                            $("#modal-screenresult").show();

                            $("#modal-screenresult").removeClass("alert alert-success");
                            $("#modal-screenresult").removeClass("alert alert-danger");
                            $("#modal-screenresult").addClass("alert alert-danger");
                            setTimeout(function() {
                                $("#modal-screenresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#modal-submit').html('Enregistrer').prop("disabled", false);

                        }






                    } catch (error) {
                        $("#screenresult").show();

                        $("#screenresult").removeClass("alert alert-success");
                        $("#screenresult").removeClass("alert alert-danger");
                        $("#screenresult").addClass("alert alert-danger");
                        setTimeout(function() {
                            $("#screenresult").hide();

                        }, 2000); //wait 2 seconds

                        // $("#screenresult").html('Une erreur s\'est produite veuillez ressayer').show();

                    }

                },
                error: function(data) {

                    // location.reload();
                    // $("#screenresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });

        }

        $('table').on('click', 'button#actionView', function() {
            var id = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getHistoricById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    try {
                        let data = JSON.parse(response).data


                        console.log(data)
                        $('#vehicleModal').modal('toggle');
                        $('#vehicleModal').modal('show');

                        $("#modal_matricul_select").prop('readonly', true);
                        $("#modal_start_time").prop('readonly', true);
                        $("#modal_start_km").prop('readonly', true);

                        $('#modal_arrival_time').prop('readonly', true);
                        $('#modal_arrival_km').prop('readonly', true);
                        $('#modal_amount_repaid').prop('readonly', true);



                        $('#modal_matricul_select').val(data.matricule);
                        $('#modal_start_time').val(data.start_time);
                        $('#modal_arrival_time').val(data.arrival_time);
                        $('#modal_start_km').val(data.start_km);
                        $('#modal_arrival_km').val(data.arrival_km);
                        $('#modal_arrival_km').val(data.arrival_km);
                        $('#modal_amount_repaid').val(data.amount_repaid);
                        $('#modal_vehicle_id').val(data.vehicle_id);

                        $('#modal-submit').hide();




                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                    // location.reload();
                    $("#screenresult").html(data.message);
                    $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        });

        $('table').on('click', 'button#actionEdit', function() {
            var id = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getHistoricById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {

                    try {
                        let data = JSON.parse(response).data

                        $('#vehicleModal').modal('toggle');
                        $('#vehicleModal').modal('show');

                        $("#modal_matricul_select").prop('readonly', true);
                        $("#modal_start_time").prop('readonly', true);
                        $("#modal_start_km").prop('readonly', true);

                        $('#modal_arrival_time').prop('readonly', false);
                        $('#modal_arrival_km').prop('readonly', false);
                        $('#modal_amount_repaid').prop('readonly', false);
                        $("#modal_travel_time").prop('required', false)


                        $('#modal_matricul_select').val(data.matricule);
                        $('#modal_start_time').val(data.start_time);
                        $('#modal_arrival_time').val(data.arrival_time);
                        $('#modal_start_km').val(data.start_km);
                        $('#modal_arrival_km').val(data.arrival_km);
                        $('#modal_amount_repaid').val(data.amount_repaid);
                        $('#modal_historic_id').val(data.id);
                        $('#modal_vehicle_id').val(data.vehicle_id);
                        $('#modal-submit').show();


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {

                    // location.reload();
                    // $("#screenresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        });
    </script>
@endsection
