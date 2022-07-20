@extends('layouts.main_layout')

@section('content')
    <div class="row" style="margin-top:50px;">
        <button id="new_repair_btn" class="m-5 btn btn-primary">Référencer une nouvelle réparation <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

        <div id="new_repair_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">

            <h2 class="text-center m-4">Référencer une nouvelle réparation</h2>

            <div id="screeresult" role="alert">
            </div>

            <form enctype="multipart/form-data" method="post" id="repair-form" action="javascript:AddRepair()">
                @csrf

                <div class="mb-3">
                    <label for="vehicle_matricule" class="form-label">Matricule de la voiture</label>

                    <div class="form-group">
                        <select id="matricul_select" class="form-control select2" name="vehicle_matricule" style="width: 100%!important" required>
                            <option value="">Choisir le matricule de la voiture</option>
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="oil_change_date" class="form-label" required>Date de changement de vidange</label>
                    <input type="date" class="form-control" id="oil_change_date" name="oil_change_date" placeholder="Couleur de la voiture" required>
                </div>
                <div class="mb-3">
                    <label for="pneumatic_change_date" class="form-label">Date de changement pneumatique</label>

                    <input class="form-control" name="pneumatic_change_date" type="date" id="pneumatic_change_date" required />
                </div>
                <div class="mb-3">
                    <label for="brake_change_date" class="form-label">Date de changement de patin de frein</label>

                    <input class="form-control" name="brake_change_date" type="date" id="brake_change_date"required />
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                <a id="close_btn" class="m-2 text-white btn btn-danger">Fermer</a>

            </form>

        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="section-header">
                    <h1>Listes des réparations</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="repair-table">
                            <thead>
                                <tr>
                                    <th>
                                        Immatriculation
                                    </th>
                                    <th>Date de changment de vidange </th>

                                    <th>Date de changment pneumatique</th>
                                    <th>Date de changment de patin de frein</th>
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

            <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de la réparation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screeresult" role="alert">
                            </div>

                            <div class="mb-3" id="maticule_div">
                                <label for="modal_vehicle_matricule" class="form-label">Matricule de la voiture</label>
                                <input type="text" id="modal_vehicle_matricule" class="form-control" readonly>
                            </div>

                            <form enctype="multipart/form-data" method="post" id="modal-repair-form" action="javascript:update_repair()">
                                @csrf
                                <input type="hidden" id="repair_id" class="form-control" name="repair_id" required>
                                <div id="select_maticule_div" class="mb-3">
                                    <label for="vehicle_matricule" class="form-label">Matricule de la voiture</label>
                                    <div class="form-group">
                                        <select id="modal_matricul_select" class="form-control select2" name="vehicle_matricule" style="width: 100%!important">
                                            <option value="">Choisir le matricule de la voiture</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="modal_oil_change_date" class="form-label">Date de changement de vidange</label>
                                    <input type="date" class="form-control" id="modal_oil_change_date" name="oil_change_date" placeholder="Couleur de la voiture" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_pneumatic_change_date" class="form-label">Date de changement pneumatique</label>

                                    <input class="form-control" name="pneumatic_change_date" type="date" id="modal_pneumatic_change_date" required />
                                </div>
                                <div class="mb-3">
                                    <label for="modal_brake_change_date" class="form-label">Date de changement de patin de frein</label>

                                    <input class="form-control" name="brake_change_date" type="date" id="modal_brake_change_date"required />
                                </div>
                                <button type="submit" id="modal_submit" class="btn btn-primary">Enregistrer</button>
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
            loadRepairs()
            getMatriculesList()


            $("#new_repair_div").hide();
            $("#screeresult").hide()

            $('#new_repair_btn').click(function() {
                $("#new_repair_div").show();
                $("#new_repair_btn").hide();

                $("#vehicle_matricule").show().prop('required', true);
                $("#oil_change_date").show().prop('required', true);
                $("#pneumatic_change_date").show().prop('required', true);
                $("#brake_change_date").show().prop('required', true);


            });

            $('#close_btn').click(function() {

                $("#vehicle_matricule").show().prop('required', true);
                $("#oil_change_date").hide().prop('required', true);
                $("#pneumatic_change_date").hide().prop('required', true);
                $("#brake_change_date").hide().prop('required', true);

                $("#new_repair_div").hide();
                $("#new_repair_btn").show();


                $('#repair-form')[0].reset();

            });



            $('#vehicle_matricule').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            chargeRecapDate()

            today = moment(new Date()).format("YYYY-MM-DD");
            $("#oil_change_date").prop('max', today)
            $("#pneumatic_change_date").prop('max', today)
            $("#brake_change_date").prop('max', today)

            $("#modal_oil_change_date").prop('max', today)
            $("#modal_pneumatic_change_date").prop('max', today)
            $("#modal_brake_change_date").prop('max', today)
        });

        $('#close_btn').click(function() {

            $("#matricul_select").val("");

            $('#matricul_select').trigger('change');
        });

        function getMatriculesList() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getVehicles') }}',
                method: 'GET',
                success: function(response) {
                    let data = JSON.parse(response).data


                    $.each(data, function(i, item) {
                        $('#matricul_select').append($('<option>', {
                            value: item.matricule,
                            text: item.matricule
                        }));

                        $('#modal_matricul_select').append($('<option>', {
                            value: item.matricule,
                            text: item.matricule
                        }));


                    });
                }

            });

        }

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
                        $('#disabled_repair').html(response.disabled_repair);
                        $('#active_repair').html(response.active_repair);
                        $('#available_repair').html(response.available_repair);


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                },
            });
        }

        function AddRepair() {
            // var frm = $('#repair-form');

            var data = new FormData();

            //Form data
            var form_data = $('#repair-form').serializeArray();
            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('addRepair') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#repair-form')[0].reset();
                            $("#vehicle_file").val(null);
                            $("#conductor_file").val(null);
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                                loadRepairs();
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

        function loadRepairs() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getRepairs') }}',
                method: 'GET',
                success: function(response) {
                    $('#repair-table').DataTable({
                        destroy: true,
                        responsive: true,
                        orderCellsTop: true,
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
                            url: "{{ route('getRepairs') }}",
                            dataType: 'JSON'
                        },

                        "data": response.data,
                        "columns": [

                            {
                                "data": "vehicle_matricule"

                            },
                            {
                                "data": "oil_change_date"
                            },
                            {
                                "data": "pneumatic_change_date"
                            },
                            {
                                "data": "brake_change_date"
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
                        }]
                    });
                }

            });
        }

        function update_repair() {
            //Form data
            var data = new FormData();
            var form_data = $('#modal-repair-form').serializeArray();


            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });



            if (!$('#modal_matricul_select').val()) {
                //File data
                var vehicle_matricule = $('#modal_vehicle_matricule').val()
                data.set("vehicle_matricule", vehicle_matricule);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateRepair') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(data) {
                    console.log(data)
                    $('#modal_submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#modal_submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {

                            $("#modal-screeresult").html(data.message);
                            $("#modal-screeresult").show();

                            $("#modal-screeresult").removeClass("alert alert-success");
                            $("#modal-screeresult").removeClass("alert alert-danger");
                            $("#modal-screeresult").addClass("alert alert-success");

                            setTimeout(function() {
                                $("#modal-screeresult").hide();
                                this.loadRepairs()
                                loadRepairs();
                                chargeRecapDate();
                            }, 3000); //wait 2 seconds

                            $('#modal_submit').html('Enregistrer').prop("disabled", false);


                        } else {
                            $("#modal-screeresult").html(data.message);
                            $("#modal-screeresult").show();

                            $("#modal-screeresult").removeClass("alert alert-success");
                            $("#modal-screeresult").removeClass("alert alert-danger");
                            $("#modal-screeresult").addClass("alert alert-danger");
                            setTimeout(function() {
                                $("#modal-screeresult").hide();

                            }, 2000); //wait 2 seconds

                            $('#modal_submit').html('Enregistrer').prop("disabled", false);

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

                        $('#modal_submit').html('Enregistrer').prop("disabled", false);


                    }

                },
                error: function(data) {
                    $('#modal_submit').html('Enregistrer').prop("disabled", false);

                    // location.reload();
                    // $("#screeresult").html(data.message);
                    // $('#submit').html("Connexion").prop("disabled", false);

                },
            });

        }

        $('table').on('click', 'button#actionView', function() {
            console.log('zefefezefe')
            var id = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getRepairById') }}',
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


                        //matricul_select
                        $("#modal_vehicle_matricule").prop('readonly', true);
                        $("#modal_oil_change_date").prop('readonly', true);
                        $("#modal_pneumatic_change_date").prop('readonly', true);
                        $("#modal_brake_change_date").prop('readonly', true);


                        $('#select_maticule_div').hide();
                        $("#maticule_div").show()


                        $('#modal_vehicle_matricule').val(data.vehicle_matricule);
                        $('#modal_oil_change_date').val(moment(new Date(data.oil_change_date)).format("YYYY-MM-DD"));
                        $('#modal_pneumatic_change_date').val(moment(new Date(data.pneumatic_change_date)).format("YYYY-MM-DD"));
                        $('#modal_brake_change_date').val(moment(new Date(data.brake_change_date)).format("YYYY-MM-DD"));
                        $('#repair_id').val(data.id);

                        $('#modal_submit').hide();

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
                url: '{{ route('getRepairById') }}',
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


                        //matricul_select
                        $("#modal_vehicle_matricule").prop('readonly', false);
                        $("#modal_oil_change_date").prop('readonly', false);
                        $("#modal_pneumatic_change_date").prop('readonly', false);
                        $("#modal_brake_change_date").prop('readonly', false);


                        $('#select_maticule_div').show();
                        $("#maticule_div").hide()

                        console.log(data.vehicle_matricule)
                        console.log(data)

                        $('#modal_vehicle_matricule').val(data.vehicle_matricule);
                        $('#modal_oil_change_date').val(moment(new Date(data.oil_change_date)).format("YYYY-MM-DD"));
                        $('#modal_pneumatic_change_date').val(moment(new Date(data.pneumatic_change_date)).format("YYYY-MM-DD"));
                        $('#modal_brake_change_date').val(moment(new Date(data.brake_change_date)).format("YYYY-MM-DD"));
                        $('#repair_id').val(data.id);


                        $('#modal_submit').show();

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
