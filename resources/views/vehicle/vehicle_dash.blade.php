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
            {{-- <div class="col-md-3">
                <div class=" custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Suspendus</h5>
                        <h1 id="disabled_vehicle" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row">
        <button id="new_vehicle_btn" class="m-5 btn btn-primary">Créer une nouvelle voiture <i class="ml-3 fa fa-plus"
                aria-hidden="true"></i></button>

        <div id="new_vehicle_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">



            <h2 class="text-center mb-4">Enregistrer une nouvelle voitures</h2>

            <div id="screeresult" role="alert">
            </div>

            <form enctype="multipart/form-data" method="post" id="vehicle-form" action="javascript:AddVehicle()">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la voiture</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la voiture"
                        aria-describedby="Nom de la voiture" required>

                </div>
                <div class="mb-3">
                    <label for="matricule" class="form-label" required>Immatriculation</label>
                    <input type="text" class="form-control" name="matricule" id="matricule"
                        placeholder="Matricule de la voiture" required>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label" required>Couleur de la voiture</label>
                    <input type="text" class="form-control" id="color"
                        name="color"placeholder="Couleur de la voiture" required>
                </div>
                <div class="mb-3">
                    <label for="vehicle_file" class="form-label">Photo de la voiture</label>

                    <input class="form-control" name="vehicle_file" type="file" id="vehicle_file" accept="image/*"
                        required />
                </div>
                <div class="mb-3">
                    <label for="conductor_file" class="form-label">Photo du conducteur</label>

                    <input class="form-control" name="conductor_file" type="file" id="conductor_file" accept="image/*"
                        required />
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                <a id="close_btn" class="m-2 text-white btn btn-danger">Fermer</a>

            </form>

        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="section-header">
                    <h1>Listes des voitures</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="vehicle-table">
                            <thead>
                                <tr>
                                    <th>
                                        Immatriculation
                                    </th>
                                    <th>Nom & couleur</th>

                                    <th>Statut</th>
                                    <th>Etat actuel</th>
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
                            <div id="modal-screeresult" role="alert">
                            </div>
                            <form enctype="multipart/form-data" method="post" id="modal-vehicle-form"
                                action="javascript:update_vehicle()">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de la voiture</label>
                                    <input type="text" class="form-control" id="modal-name" name="name"
                                        placeholder="Nom de la voiture" aria-describedby="Nom de la voiture" required>

                                </div>
                                <div class="mb-3">
                                    <label for="matricule" class="form-label" required>Matricule</label>
                                    <input type="text" class="form-control" name="matricule" id="modal-matricule"
                                        placeholder="Matricule de la voiture" required>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label" required>Couleur de la voiture</label>
                                    <input type="text" class="form-control" id="modal-color"
                                        name="color"placeholder="Couleur de la voiture" required>
                                </div>

                                <div class="mb-3 form-group">
                                    <div class="form-label">La Voiture est en service</div>
                                    <label class="custom-switch mt-2">
                                        <input id="status_check" type="checkbox" name="status"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"> OUI</span>
                                    </label>
                                    <input id="hidden_check" type="hidden" name="status" value="0" />
                                </div>
                                <div class="mb-3">
                                    <label for="vehicle_file" class="form-label"> Photo de la voiture</label>
                                    <button value="" type="button" class="m-2 btn btn-primary text-white"
                                        id="vehicleFileView"> Voir <i
                                            class="
                                    fa fa-eye"></i></button>
                                    <input class="form-control" name="vehicle_file" type="file"
                                        id="modal_vehicle_file" accept="image/*" />
                                </div>
                                <div class="mb-3">
                                    <label for="conductor_file" class="form-label"> Photo du conducteur</label>
                                    <button value="" type="button" class="m-2 btn btn-primary text-white"
                                        id="conductorFileView"> Voir <i
                                            class="
                                    fa fa-eye"></i></button>
                                    <input class="form-control" name="conductor_file" type="file"
                                        id="modal_conductor_file" accept="image/*" />
                                </div>
                                <button type="submit" id="modal-submit" class="btn btn-primary">Enregistrer</button>
                                <a type="button" id="modal_close_btn" class="text-white btn btn-warning"
                                    data-dismiss="modal">Close</a>


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

    <script>
        $(document).ready(function() {
            loadVehicles()

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

                $("#vehicle_file").val(null);
                $("#conductor_file").val(null);

                $('#vehicle-form')[0].reset();

            });

            $('#modal_close_btn').click(function() {
                $("#modal_vehicle_file").val(null);
                $("#modal_conductor_file").val(null);
            });

            $('#matricule').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            chargeRecapDate()
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

                        console.log(response)
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

        function AddVehicle() {
            // var frm = $('#vehicle-form');

            var data = new FormData();

            //Form data
            var form_data = $('#vehicle-form').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });


            //File data
            var file_vehicle = $('input[name="vehicle_file"]')[0].files[0];
            var file_conductor = $('input[name="conductor_file"]')[0].files[0];
            data.append("vehicle_file", file_vehicle);
            data.append("conductor_file", file_conductor);


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('addVehicle') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop(
                        "disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#vehicle-form')[0].reset();
                            $("#vehicle_file").val(null);
                            $("#conductor_file").val(null);
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                                loadVehicles();
                                chargeRecapDate();
                            }, 3000); //wait 2 seconds

                            $('#submit').html('Enregistrer').prop("disabled", false);

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
                    $("#screeresult").html(data.message);
                    $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        }

        function loadVehicles() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getVehicles') }}',
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
                            text: '<i class="mdi mdi-file-excel"></i> Exporter',
                            className: 'btn btn-primary'
                        }, ],
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                        "order": [
                            [0, 'desc']
                        ],
                        "ajax": {
                            url: "{{ route('getVehicles') }}",
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
                                "data": "status"
                            },
                            {
                                "data": "current_state"
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
                                "targets": -3,
                                "data": "status",
                                render: function(data, type, row, meta) {

                                    if (data == 1) {
                                        return "<div class='badge badge-success'><h8>En activité </h8> </div>";

                                    } else {
                                        return "<div class='badge badge-danger'><h8> Suspendu </h8></div>  ";

                                    }
                                },
                            },
                            {
                                "targets": -2,
                                "data": "current_state",
                                render: function(data, type, row, meta) {

                                    if (data == "LIBRE") {
                                        return "<div class='badge badge-success'>LIBRE </div>";

                                    } else {
                                        return "<div class='badge badge-danger'> OCCUPÉE</div>  ";

                                    }
                                },
                            },
                            {
                                "targets": -4,
                                "data": "name",
                                render: function(data, type, row, meta) {
                                    // return "<div class='btn btn-primary '><i class='fa fa-eye'></i></div>";

                                    return row.name + " " + row.color + "";
                                },
                            },


                        ]
                    });
                }

            });
        }
        $('#vehicle_file').change(function(e) {
            let file = e.target.files[0];

            if (file.size > 2000000) {
                $("#screeresult").html("Votre fichier ne doit pas dépasser 2Mb");
                $("#screeresult").show();

                $("#screeresult").removeClass("alert alert-success");
                $("#screeresult").removeClass("alert alert-danger");
                $("#screeresult").addClass("alert alert-danger");

                setTimeout(function() {
                    $("#screeresult").hide();

                }, 2000); //wait 2 seconds
                $('#submit').prop("disabled", true);


            } else {

                $('#submit').prop("disabled", false);

            }

        });
        $('#conductor_file').change(function(e) {
            let file = e.target.files[0];

            if (file.size > 2000000) {
                $("#screeresult").html("Votre fichier ne doit pas dépasser 2Mb");
                $("#screeresult").show();

                $("#screeresult").removeClass("alert alert-success");
                $("#screeresult").removeClass("alert alert-danger");
                $("#screeresult").addClass("alert alert-danger");

                setTimeout(function() {
                    $("#screeresult").hide();

                }, 2000); //wait 2 seconds
                $('#submit').prop("disabled", true);


            } else {

                $('#submit').prop("disabled", false);

            }

        });

        function update_vehicle() {

            if ($('#status_check').is(":checked")) {
                $("#hidden_check").val(1)
            } else {
                $("#hidden_check").val(0)
            }

            //Form data
            var data = new FormData();
            var form_data = $('#modal-vehicle-form').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });

            //File data
            var file_vehicle = $('input[name="vehicle_file"]')[1].files[0];
            var file_conductor = $('input[name="conductor_file"]')[1].files[0];

            data.append("vehicle_file", file_vehicle);
            data.append("conductor_file", file_conductor);


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateVehicle') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(data) {
                    console.log(data)
                    $('#modal-submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>')
                        .prop("disabled", true);
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
                                this.loadVehicles()
                                loadVehicles();
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

                        $('#modal-submit').html('Enregistrer').prop("disabled", false);


                    }

                },
                error: function(data) {
                    $('#modal-submit').html('Enregistrer').prop("disabled", false);

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
                url: '{{ route('getVehicleById') }}',
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

                        $("#modal-name").prop('readonly', true);
                        $("#modal-matricule").prop('readonly', true);
                        $("#modal-color").prop('readonly', true);
                        $('#status_check').prop("disabled", true);



                        $('#vehicleFileView').show();
                        $("#modal_vehicle_file").hide()

                        $('#conductorFileView').show();
                        $("#modal_conductor_file").hide()

                        $('#modal-name').val(data.name);
                        $('#modal-matricule').val(data.matricule);
                        $('#modal-color').val(data.color);

                        $('#vehicleFileView').prop('value', data.vehicle_file);
                        $('#conductorFileView').prop('value', data.conductor_file);



                        if (data.status) {
                            $('#status_check').prop("checked", true);
                        } else {
                            $('#status_check').prop("checked", false);
                        }

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

        $('#vehicleFileView').click(function() {
            window.open(this.value, '_blank');

        });

        $('#conductorFileView').click(function() {
            window.open(this.value, '_blank');

        });

        $('table').on('click', 'button#actionEdit', function() {
            var id = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getVehicleById') }}',
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

                        $("#modal-name").prop('readonly', false);
                        $("#modal-matricule").prop('readonly', true);
                        $("#modal-color").prop('readonly', false);
                        $('#status_check').prop("disabled", false);

                        $('#vehicleFileView').hide();
                        $("#modal_vehicle_file").show()

                        $('#conductorFileView').hide();
                        $("#modal_conductor_file").show()

                        if (data.status) {
                            $('#status_check').prop("checked", true);
                        } else {
                            $('#status_check').prop("checked", false);
                        }



                        $('#modal-name').val(data.name);
                        $('#modal-matricule').val(data.matricule);
                        $('#modal-color').val(data.color);
                        $('#modal-submit').show();


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                    // location.reload();
                    // $("#screeresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        });
    </script>
@endsection
