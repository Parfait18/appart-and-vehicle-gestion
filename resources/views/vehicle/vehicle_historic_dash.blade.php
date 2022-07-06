@extends('layouts.main_layout')

@section('content')
    <div class="container">
        <div class="row" style="width: 100%">
            <div class="col-md-4">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Total des voitures</h5>
                        <h1 class=" text-center m-4 card-subtitle mb-2 text-muted"> {{ $total }}</h1>
                        {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Voitures en activité</h5>
                        <h1 class=" text-center m-4 card-subtitle mb-2 text-muted"> {{ $active_vehicle }}</h1>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Voitures en hors services</h5>
                        <h1 class=" text-center m-4 card-subtitle mb-2 text-muted"> {{ $disabled_vehicle }}</h1>

                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Voitures en hors services</h5>
                        <h1 class=" text-center m-4 card-subtitle mb-2 text-muted"> 22</h1>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row">
        <button id="new_vehicle_btn" class="m-5 btn btn-primary">Créer une nouvelle activité <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

        <div id="new_vehicle_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">

            <div id="screeresult" role="alert">
            </div>

            <h2 class="text-center mb-4">Enregistrer une nouvelle activité</h2>

            <form id="historic-form" action="javascript:add_historic()">
                @csrf

                <div class="mb-3">

                    <div class="form-group">
                        <label for="vehicle_id" class="form-label">Matricule de la voiture</label>
                        <select id="matricul_select" class="form-control select2" name="vehicle_id" style="width: 100%!important" required>
                            <option value="">Choisir le matricule de la voiture</option>
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="start_time" class="form-label" required>Heure de départ de la voiture</label>
                        <input id="start_time" type="datetime-local" name="start_time" class="form-control" format="DD-MM-YY hh:mm:ss">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="start_km" class="form-label" required>Km départ de la voiture</label>
                    <input type="number" class="form-control" id="start_km" name="start_km"placeholder="Km départ de la voiture" step="0.01" required>
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                <a id="close_btn" class="m-2 text-white btn btn-danger">Fermer</a>

            </form>

        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="section-header">
                    <h1>Listes des activités</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="vehicle-table">
                            <thead>
                                <tr>
                                    <th>
                                        Matricule
                                    </th>
                                    <th>Nom && couleur</th>
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

            <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de la voiture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screeresult" role="alert">
                            </div>
                            <form id="modal-historic-form" action="javascript:update_historic()">

                                @csrf
                                <input type="hidden" id="modal_historic_id" class="form-control" name="historic_id" required>
                                <input type="hidden" id="modal_travel_time" class="form-control" name="travel_time" required>
                                <input type="hidden" id="modal_vehicle_id" class="form-control" name="vehicle_id" required>


                                <div class="mb-3">

                                    <div class="form-group">
                                        <label for="vehicle_id" class="form-label">Matricule de la voiture</label>
                                        <input id="modal_matricul_select" class="form-control" name="vehicle_id" style="width: 100%!important" required>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label" required>Heure de départ de la voiture</label>
                                        <input id="modal_start_time" type="text" name="start_time" class="form-control">
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="start_km" class="form-label" required>Km départ de la voiture</label>
                                    <input type="number" class="form-control" id="modal_start_km" name="start_km" placeholder="Km départ de la voiture" step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <label for="arrival_time" class="form-label" required> Heure d'arrivée de la voiture</label>
                                    <input id="modal_arrival_time" type="datetime-local" name="arrival_time" class="form-control datetimepicker">

                                </div>

                                <div class="mb-3">
                                    <label for="arrival_km" class="form-label" required>Km d'arrivée de la voiture</label>
                                    <input type="number" class="form-control" id="modal_arrival_km" name="arrival_km" placeholder="Km d'arrivée de la voiture" step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <label for="amount_repaid" class="form-label" required>Montant reversé</label>
                                    <input type="number" class="form-control" id="modal_amount_repaid" name="amount_repaid"placeholder="Montant reversé" required>
                                </div>

                                <button type="modal-submit" id="modal-submit" class="btn btn-primary">Enregistrer</button>
                                <a id="close_btn" class="m-2 text-white btn btn-danger" data-dismiss="modal">Fermer</a>

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
            moment.locale('en')

            loadHistoric()
            getMatriculesList()
            $("#new_vehicle_div").hide();
            $("#screeresult").hide()


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



        });

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
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#historic-form')[0].reset();
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                                // location.reload();
                            }, 3000); //wait 2 seconds


                        } else {
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-danger");
                            setTimeout(function() {
                                $("#screeresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);

                        }



                    } catch (error) {
                        $("#screeresult").show();

                        $("#screeresult").removeClass("alert alert-success");
                        $("#screeresult").removeClass("alert alert-danger");
                        $("#screeresult").addClass("alert alert-danger");
                        setTimeout(function() {
                            $("#screeresult").hide();

                        }, 2000); //wait 2 seconds

                        // $("#screeresult").html('Une erreur s\'est produite veuillez ressayer').show();

                    }

                },
                error: function(data) {

                    // location.reload();
                    // $("#screeresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        }

        function loadHistoric() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getHistoric') }}',
                method: 'GET',
                success: function(response) {
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
                        "ajax": {
                            url: "{{ route('getHistoric') }}",
                            dataType: 'JSON'
                        },

                        "data": response.data,
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

                                    return '<button value="' + data + '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-eye"></i></button> <button value="' + data + '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fa fa-pencil-alt"></i></button>';
                                },
                            },
                            {
                                "targets": -2,
                                "data": "status",
                                render: function(data, type, row, meta) {
                                    // console.log(data)
                                    if (data == "EN COURS") {
                                        return "<div class='badge badge-success h1'>En cours </div>";

                                    } else {
                                        return "<div class='badge badge-danger h1'> DEJA PASSE</div>  ";

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
                    $('#modal-submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#modal-submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {

                            $("#modal-screeresult").html(data.message);
                            $("#modal-screeresult").show();

                            $("#modal-screeresult").removeClass("alert alert-success");
                            $("#modal-screeresult").removeClass("alert alert-danger");
                            $("#modal-screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#modal-screeresult").hide();
                                // location.reload();
                            }, 3000); //wait 2 seconds


                        } else {
                            $("#modal-screeresult").html(data.message);
                            $("#modal-screeresult").show();

                            $("#modal-screeresult").removeClass("alert alert-success");
                            $("#modal-screeresult").removeClass("alert alert-danger");
                            $("#modal-screeresult").addClass("alert alert-danger");
                            setTimeout(function() {
                                $("#modal-screeresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#modal-submit').html('Enregistrer').prop("disabled", false);

                        }






                    } catch (error) {
                        $("#screeresult").show();

                        $("#screeresult").removeClass("alert alert-success");
                        $("#screeresult").removeClass("alert alert-danger");
                        $("#screeresult").addClass("alert alert-danger");
                        setTimeout(function() {
                            $("#screeresult").hide();

                        }, 2000); //wait 2 seconds

                        // $("#screeresult").html('Une erreur s\'est produite veuillez ressayer').show();

                    }

                },
                error: function(data) {

                    // location.reload();
                    // $("#screeresult").html(data.message);
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
                        $('#modal_start_km').val(data.start_km);
                        $('#modal_historic_id').val(data.id);
                        $('#modal_vehicle_id').val(data.vehicle_id);

                        $('#modal-submit').hide();




                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                    // location.reload();
                    $("#screeresult").html(data.message);
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
                    // $("#screeresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        });
    </script>
@endsection