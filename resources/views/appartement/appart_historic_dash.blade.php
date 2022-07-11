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
    <div class="row">
        <button id="new_vehicle_btn" class="m-5 btn btn-primary">Créer une nouvelle activité <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

        <div id="new_vehicle_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">


            <h2 class="text-center mb-4">Enregistrer une nouvelle activité</h2>
            <div id="screeresult" role="alert">
            </div>

            <form id="historic-form" action="javascript:add_historic()">
                @csrf
                <input type="hidden" id="stay_length" class="form-control" name="stay_length" required>

                <div class="mb-3">

                    <div class="form-group">
                        <label for="appart_type" class="form-label">Type de l'appartement</label>
                        <select id="type_select" class="form-control select2" name="appart_type" style="width: 100%!important" required>
                            <option value="">Choisir le type de l'appartement</option>
                            <option value="RV1">RV1</option>
                            <option value="RV2">RV2</option>
                            <option value="STUDIO">STUDIO</option>
                        </select>
                    </div>

                </div>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="appart_id" class="form-label">Code de l'appartement</label>
                        <select id="code_select" class="form-control select2" name="appart_id" style="width: 100%!important" required>
                            <option value="">Choisir le code de l'appartement</option>
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="start_time" class="form-label" required>Date de début séjour</label>
                        <input id="start_time" type="datetime-local" name="start_time" class="form-control" onchange="startChange();">
                    </div>

                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="end_time" class="form-label" required>Date de fin du séjour</label>
                        <input id="end_time" type="datetime-local" name="end_time" class="form-control" onchange="endChange()" format="DD-MM-YY hh:mm:ss">
                    </div>
                </div>
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <div id="other_check_div" class="mb-3 form-group">
                        <div class="form-label">Autre tarif ?</div>
                        <label class="custom-switch mt-2">
                            <input id="other_check" type="checkbox" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> OUI</span>
                        </label>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="amount" class="form-label" required>Prix par jour</label>
                    <input type="number" class="form-control" id="day_amount" placeholder="Prix par jour" step="1" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label" required>Prix total du séjour</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Montant total" step="1" readonly required>
                </div>


                <div class="mb-3">
                    <label for="paid_amount" class="form-label" required>Montant payé</label>
                    <input type="number" class="form-control" id="paid_amount" value="0" name="paid_amount" placeholder="Montant payé" step="1" required>
                </div>
                <div class="mb-3">
                    <label for="rest" class="form-labetype_selectl" required>Montant restant</label>
                    <input type="number" class="form-control" id="rest" value="0" name="rest" placeholder="Reste du montant" step="1" readonly required>
                </div>


                <div class="mb-3">
                    <label for="occupant" class="form-label">Nom du client</label>
                    <input type="text" class="form-control" id="occupant" name="occupant" placeholder="Nom du client" aria-describedby="Nom du client" required>
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
                                        Code de l'appartement
                                    </th>
                                    <th>
                                        Type de l'appartement
                                    </th>
                                    <th>Nom de l'occuppant</th>
                                    <th>Date de début de séjour</th>
                                    <th>Date de fin de séjour</th>
                                    <th>Durée du séjour</th>
                                    <th>Prix</th>
                                    <th>Montant payé</th>
                                    <th>Montant Restant</th>
                                    <th>Etat actuel</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            {{-- /modal --}}

            <div class="modal fade" id="appartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de la location</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screeresult" role="alert">
                            </div>
                            <form id="modal-historic-form" action="javascript:update_historic()">

                                @csrf
                                <input type="hidden" id="modal_stay_length" class="form-control" name="stay_length" required>
                                <input type="hidden" id="modal_appart_hist_id" class="form-control" name="id" required>
                                <input type="hidden" id="modal_appart_id" class="form-control" name="last_id" required>



                                <div class="mb-3 form-group">
                                    <div id="appart_check_div" class="mb-3 form-group">
                                        <div class="form-label">Changer d'appartement ?</div>
                                        <label class="custom-switch mt-2">
                                            <input id="appart_check" type="checkbox" name="advance" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"> OUI</span>
                                        </label>
                                        <input id="hidden_check" type="hidden" name="advance" value="0" />
                                    </div>
                                    <div id="last_appart">
                                        <label class="form-label"> Code de l'appartement choisi</label>
                                        <input type="text" id="last_appart_choose" class="form-control" readonly>
                                    </div>

                                    <div id="select_div">
                                        <label for="modal_appart_id" class="form-label">Code de l'appartement</label>
                                        <select id="modal_code_select" class="form-control select2" name="appart_id" style="width: 100%!important" required>
                                            <option value="">Choisir le code de l'appartement</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="modal_start_time" class="form-label" required>Heure de début séjour</label>
                                        <input id="modal_start_time" type="datetime-local" name="start_time" class="form-control" format="DD-MM-YY hh:mm:ss">
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="modal_amount" class="form-label" required>Prix de l'appartement</label>
                                    <input type="number" class="form-control" id="modal_amount" name="amount" placeholder="Prix de l'appartement" step="1" readonly required>
                                </div>


                                <div class="mb-3">
                                    <label for="modal_paid_amount" class="form-label" required>Montant payé</label>
                                    <input type="number" class="form-control" id="modal_paid_amount" value="0" name="paid_amount" placeholder="Montant payé" step="1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_rest" class="form-label" required>Montant restant</label>
                                    <input type="number" class="form-control" id="modal_rest" value="0" name="rest" placeholder="Reste du montant" step="1" readonly required>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="modal_end_time" class="form-label" required>Heure de fin du séjour</label>
                                        <input id="modal_end_time" type="datetime-local" name="end_time" class="form-control" format="DD-MM-YY hh:mm:ss">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="modal_occupant" class="form-label">Nom du client</label>
                                    <input type="text" class="form-control" id="modal_occupant" name="occupant" placeholder="Nom du client" aria-describedby="Nom du client" required>
                                </div>


                                <button type="submit" id="modal-submit" class="btn btn-primary">Enregistrer</button>
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

            $("#end_time").prop('disabled', true)
            $("#start_time").prop('disabled', true)
            $("#other_check_div").hide()
            $("#day_amount").attr('readonly', true);


            loadHistoric()
            // geCodesList()
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
                $("#other_check_div").hide()


            });


            $('#other_check').on('change', function() {

                if ($('#other_check').is(':checked')) {

                    $("#day_amount").attr('readonly', false);

                } else {

                    $("#day_amount").attr('readonly', true);
                }
            });


            $('#day_amount').keyup(function() {

                let day_amount = $('#day_amount').val();
                $('#rest').val(day_amount);


                let start_time
                let end_time


                if ($("#end_time").val()) {
                    end_time = formatDate($("#end_time").val())
                }

                start_time = formatDate($("#start_time").val())

                var beginningTime = moment(start_time);
                var endTime = moment(end_time);

                let nbr_day = getDayDiff(start_time, end_time)


                $('#amount').val(day_amount * nbr_day)
                $('#rest').val(day_amount)
                $('#paid_amount').val(0)

            });

            $('#type_select').on('change', function() {
                var type = this.value
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('getAppartByType') }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type
                    },
                    success: function(response) {
                        try {
                            let data = JSON.parse(response).data
                            //active start date if type is selected
                            if (data.length > 0) {
                                $("#start_time").prop('disabled', false)
                            } else {
                                $("#start_time").prop('disabled', true)
                                $("#screeresult").html("IL n'y a pas d'appartement disponible pour ce type");
                                $("#screeresult").show();

                                $("#screeresult").removeClass("alert alert-success");
                                $("#screeresult").removeClass("alert alert-danger");
                                $("#screeresult").addClass("alert alert-danger");
                                setTimeout(function() {
                                    $("#screeresult").hide();

                                }, 2000); //wait 2 seconds

                            }

                            $('#code_select').empty().append('<option value="">Choisir le code de l\'appartement</option>')
                            $.each(data, function(i, item) {
                                $('#code_select').append($('<option>', {
                                    value: item.id,
                                    text: item.code
                                }));
                            });

                        } catch (error) {
                            console.log(error)

                        }

                    },
                    error: function(data) {
                        console.log(data)
                        // location.reload();
                        $("#screeresult").html("Il s'est produite une erreur");
                        // $('#submit').html("Connexion").prop("disabled", false);

                    },
                });


            });

            $('#modal_code_select').on('change', function() {
                var id = this.value
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('getAppartById') }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        try {
                            let data = JSON.parse(response).data

                            $('#modal_amount').val(data.price);
                            $('#modal_paid_amount').val(0);
                            $('#modal_rest').val(data.price);


                        } catch (error) {
                            console.log(error)

                        }

                    },
                    error: function(data) {
                        console.log(data)
                        // location.reload();
                        $("#screeresult").html("Il s'est produite une erreur");
                        // $('#submit').html("Connexion").prop("disabled", false);

                    },
                });

            });

            // $('#code_select').on('change', function() {

            //     var id = this.value
            //     $.ajax({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         url: '{{ route('getAppartById') }}',
            //         method: 'POST',
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             id: id
            //         },
            //         success: function(response) {
            //             try {
            //                 let data = JSON.parse(response).data

            //                 $('#amount').val(data.price);
            //                 $('#paid_amount').val(0);
            //                 $('#rest').val(data.price);
            //                 // $('#modal_start_time').val(data.start_time);


            //             } catch (error) {
            //                 console.log(error)

            //             }

            //         },
            //         error: function(data) {
            //             console.log(data)
            //             // location.reload();
            //             // $("#screeresult").html();
            //             // $('#submit').html("Connexion").prop("disabled", false);

            //         },
            //     });

            // });

            $('#paid_amount').keyup(function() {

                let amount = $('#amount').val();
                let rest = amount - this.value
                if (rest > 0) {
                    $('#rest').val(rest);
                    $("#screeresult").hide();
                    $('#submit').prop("disabled", false);

                } else {
                    $('#rest').val(0);
                    $("#screeresult").html("Veuillez entrez une somme qui n'est pas supérieure au montannt de la chambre ");
                    $("#screeresult").show();

                    $("#screeresult").removeClass("alert alert-success");
                    $("#screeresult").removeClass("alert alert-danger");
                    $("#screeresult").addClass("alert alert-danger");

                    setTimeout(function() {
                        $("#screeresult").hide();

                    }, 2000); //wait 2 seconds
                    $('#submit').prop("disabled", true);

                }

            });

            $('#modal_paid_amount').keyup(function() {

                let amount = $('#modal_amount').val();
                let rest = amount - this.value
                if (rest > 0) {
                    $('#modal_rest').val(rest);
                    $("#modal-screeresult").hide();
                    $('#modal-submit').prop("disabled", false);


                } else {
                    $('#modal_rest').val(0);
                    $("#modal-screeresult").html("Veuillez entrez une somme qui n'est pas supérieure au montannt de la chambre ");
                    $("#modal-screeresult").show();

                    $("#modal-screeresult").removeClass("alert alert-success");
                    $("#modal-screeresult").removeClass("alert alert-danger");
                    $("#modal-screeresult").addClass("alert alert-danger");
                    setTimeout(function() {
                        $("#modal-screeresult").hide();

                    }, 2000); //wait 2 seconds
                    $('#modal-submit').prop("disabled", true);


                }

            });

            $('#appart_check').on('change', function() {

                if ($('#appart_check').is(':checked')) {
                    $('#select_div').show();
                    $('#last_appart').hide();
                    $("#modal_code_select").prop('required', true);
                } else {
                    $('#select_div').hide();
                    $('#last_appart').show();
                    $("#modal_code_select").prop('required', false);
                }

            });

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

        function geCodesList() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getValidAppart') }}',
                method: 'GET',
                success: function(response) {
                    let data = JSON.parse(response).data


                    $.each(data, function(i, item) {
                        $('#code_select').append($('<option>', {
                            value: item.id,
                            text: item.code
                        }));
                    });
                    $.each(data, function(i, item) {
                        $('#modal_code_select').append($('<option>', {
                            value: item.id,
                            text: item.code
                        }));
                    });
                }

            });

        }

        function add_historic() {

            var frm = $('#historic-form');


            let start_time = $("#start_time").val();

            let end_time = $("#end_time").val();

            let stay_length = getDateDiff(start_time, end_time)

            $("#stay_length").val(stay_length);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('addAppartHistoric') }}',
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
                                loadHistoric();
                                chargeRecapDate();
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
                    $("#screeresult").html("Une errreur s'est produite");
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        }

        function loadHistoric() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getAppartHistoric') }}',
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
                            url: "{{ route('getAppartHistoric') }}",
                            dataType: 'JSON'
                        },

                        "data": response.data,
                        "columns": [

                            {
                                "data": "code"

                            },
                            {
                                "data": "type"

                            },
                            {
                                "data": "occupant"
                            },
                            {
                                "data": "start_time"
                            },
                            {
                                "data": "end_time"
                            },
                            {
                                "data": "stay_length"
                            },

                            {
                                "data": "paid_amount"
                            },
                            {
                                "data": "rest"
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
                                    return '<button value="' + data + '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#appartModal"><i class="fa fa-eye"></i></button> <button value="' + data + '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#appartModal"><i class="fa fa-pencil-alt"></i></button>';
                                },
                            },
                            {
                                "targets": -2,
                                "data": "status",
                                render: function(data, type, row, meta) {
                                    if (data == "TERMINE") {
                                        return "<div class='badge badge-success h1'>Terminé</div>";

                                    } else if (data == "EN COURS") {
                                        return "<div class='badge badge-info h1'> En cours</div>  ";

                                    } else if (data == "REVERVE") {
                                        return "<div class='badge badge-warning h1'> Réservé</div>  ";
                                    } else {
                                        console.log(data)
                                        return ''
                                    }
                                },
                            },
                            {
                                "targets": -7,
                                "data": "end_time",
                                render: function(data, type, row, meta) {
                                    if (row.end_time) {
                                        return this.formatDate(row.end_time);
                                    } else {
                                        return ''
                                    }

                                },
                            },
                            {

                                "targets": -8,
                                "data": "start_time",
                                render: function(data, type, row, meta) {
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
            let end_time = $("#modal_end_time").val();

            let start_date = moment(start_time, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');

            let end_date = moment(end_time, 'YYYY-MM-DD HH:mm').format('DD-MM-YYYY HH:mm:ss');


            start_date = moment(start_date, 'DD-MM-YYYY HH:mm:ss')

            end_date = moment(end_date, 'DD-MM-YYYY HH:mm:ss')


            let seconds_result = end_date.diff(start_date, 'seconds')
            let minutes_result = end_date.diff(start_date, 'minutes')
            let hours_result = end_date.diff(start_date, 'hours')
            let days_result = end_date.diff(start_date, 'days')
            let months_result = end_date.diff(start_date, 'months')
            let years_result = end_date.diff(start_date, 'years')

            let stay_length


            if (seconds_result < 0) {

                stay_length = 0

            } else if (seconds_result > 3153600) {

                stay_length = years_result + ' An(s)'

            } else if (seconds_result > 2419200) {

                stay_length = months_result + ' Mois'

            } else if (seconds_result > 86400) {

                stay_length = days_result + ' Jours'

            } else if (seconds_result > 3600) {

                stay_length = hours_result + ' Heure(s)'

            } else if (seconds_result >= 60) {

                stay_length = minutes_result + 'Minute(s)'

            } else if (seconds_result < 60) {
                0
                stay_length = seconds_result + ' Seconde(s)'
            }

            $("#modal_stay_length").val(stay_length);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateAppartHistoric') }}',
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
                                loadHistoric();
                                chargeRecapDate();
                            }, 3000); //wait 2 seconds
                            $('#modal-submit').html('Enregistrer').prop("disabled", false);

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
                url: '{{ route('getAppartHistoricById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    try {
                        let data = JSON.parse(response).data

                        $('#appartModal').modal('toggle');
                        $('#appartModal').modal('show');

                        $("#modal_appart_hist_id").prop('readonly', true);
                        $("#modal_start_time").prop('readonly', true);
                        $("#modal_amount").prop('readonly', true);
                        $("#modal_paid_amount").prop('readonly', true);
                        $("#modal_rest").prop('readonly', true);
                        $("#modal_end_time").prop('readonly', true);
                        $("#modal_occupant").prop('readonly', true);
                        $('#select_div').hide();
                        $('#last_appart').show();

                        $('#appart_check').prop("checked", false);
                        $('#appart_check_div').hide()

                        $('#modal_appart_hist_id').val(data.id);
                        $('#modal_start_time').val(data.start_time);
                        $('#modal_amount').val(data.price);
                        $('#modal_paid_amount').val(data.paid_amount);
                        $('#modal_rest').val(data.rest);
                        $('#modal_end_time').val(data.end_time);
                        $('#modal_occupant').val(data.occupant);
                        $('#last_appart_choose').val(data.code);
                        $('#modal-submit').hide();


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                    // location.reload();
                    $("#screeresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        });

        $('table').on('click', 'button#actionEdit', function() {
            var id = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getAppartHistoricById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {

                    try {
                        let data = JSON.parse(response).data

                        $('#appartModal').modal('toggle');
                        $('#appartModal').modal('show');

                        $("#modal_appart_hist_id").prop('readonly', true);
                        $("#modal_start_time").prop('readonly', false);
                        $("#modal_amount").prop('readonly', true);
                        $("#modal_paid_amount").prop('readonly', false);
                        $("#modal_rest").prop('readonly', true);
                        $("#modal_end_time").prop('readonly', false);
                        $("#modal_occupant").prop('readonly', false);
                        $("#modal_code_select").prop('required', false);


                        $('#last_appart').show();
                        $('#select_div').hide();
                        $('#appart_check').prop("checked", false);
                        $('#appart_check_div').show()


                        $('#modal_appart_hist_id').val(data.id);
                        $('#modal_start_time').val(data.start_time);
                        $('#modal_amount').val(data.price);
                        $('#modal_paid_amount').val(data.paid_amount);
                        $('#modal_rest').val(data.rest);
                        $('#modal_end_time').val(data.end_time);
                        $('#modal_occupant').val(data.occupant);
                        $('#last_appart_choose').val(data.code);
                        $('#modal_appart_id').val(data.appart_id)



                        $('#modal-submit').show()

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

        function getDayDiff(start_time, end_time) {

            let start_date = moment(start_time);

            let end_date = moment(end_time);

            let days_result = end_date.diff(start_date, 'days')

            if (days_result < 0 || days_result == 0) {
                days_result = 1
            }

            return days_result;

        }

        function startChange() {
            $('#submit').prop("disabled", false);
            $("#end_time").prop('disabled', false)


            // let formatDate = moment($("#start_time").val()).subtract(0, "hour").format("DD-MM-YYYY HH:mm:ss");

        }


        function endChange() {
            let start_time
            let end_time


            if ($("#end_time").val()) {
                end_time = formatDate($("#end_time").val())
            }

            start_time = formatDate($("#start_time").val())

            var beginningTime = moment(start_time);
            var endTime = moment(end_time);


            //test if end date is after begin date
            if (beginningTime.isBefore(endTime)) {

                let nbr_day = getDayDiff(start_time, end_time)

                let type = $('#type_select').val()

                getAmoutPerDay(nbr_day, type)

                $('#submit').prop("disabled", false);
                $("#other_check_div").show()

            } else {
                $("#screeresult").html("Veuillez renseigner une date supérieure à la date de début de séjour");
                $("#screeresult").show();
                $("#other_check_div").hide()

                $("#screeresult").removeClass("alert alert-success");
                $("#screeresult").removeClass("alert alert-danger");
                $("#screeresult").addClass("alert alert-danger");

                setTimeout(function() {
                    $("#screeresult").hide();

                }, 2000); //wait 2 seconds
                $('#submit').prop("disabled", true);

            }





        }


        function formatDate(str) {
            // return moment(str).subtract(0, "hour").format("YYYY-MM-DD[T]HH:mm:ss");
            return moment(str).format("YYYY-MM-DD HH:mm:ss");
        }

        function getAmoutPerDay(nbr_day, type) {

            let result
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getIndiceByTypeDays') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    type: type,
                    min_nbr_day: nbr_day
                },
                success: function(response) {
                    let data = JSON.parse(response).data

                    $('#day_amount').val(data.amount)
                    $('#amount').val(data.amount * nbr_day)
                    $('#rest').val(data.amount)


                }

            });

        }

        function getDateDiff(start_time, end_time) {


            let start_date = moment(start_time, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');

            let end_date = moment(end_time, 'YYYY-MM-DD HH:mm').format('DD-MM-YYYY HH:mm:ss');

            start_date = moment(start_date, 'DD-MM-YYYY HH:mm:ss')

            end_date = moment(end_date, 'DD-MM-YYYY HH:mm:ss')


            let seconds_result = end_date.diff(start_date, 'seconds')
            let minutes_result = end_date.diff(start_date, 'minutes')
            let hours_result = end_date.diff(start_date, 'hours')
            let days_result = end_date.diff(start_date, 'days')
            let months_result = end_date.diff(start_date, 'months')
            let years_result = end_date.diff(start_date, 'years')

            let stay_length


            if (seconds_result < 0) {

                stay_length = 0

            } else if (seconds_result > 3153600) {

                stay_length = years_result + ' An(s)'

            } else if (seconds_result > 2419200) {

                stay_length = months_result + ' Mois'

            } else if (seconds_result > 86400) {

                stay_length = days_result + ' Jours'

            } else if (seconds_result > 3600) {

                stay_length = hours_result + ' Heure(s)'

            } else if (seconds_result >= 60) {

                stay_length = minutes_result + 'Minute(s)'

            } else if (seconds_result < 60) {

                stay_length = seconds_result + ' Seconde(s)'
            }

            return stay_length;

        }
    </script>
@endsection
