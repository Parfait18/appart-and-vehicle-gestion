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
        <button id="new_appart_btn" class="m-5 btn btn-primary">Créer un nouvel appartement <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

        <div id="new_appart_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">



            <h2 class="text-center mb-4">Enregistrer un nouvel appartement</h2>

            <div id="screeresult" role="alert">
            </div>
            <form id="appart-form" action="javascript:addAppart()">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'appartement</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom de l'appartement" aria-describedby="Nom de l'appartement" required>

                </div>
                {{-- <div class="mb-3">
                    <label for="code" class="form-label" required>Code</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="Code de l'appartement" readonly required>
                </div> --}}
                {{-- <div class="mb-3">
                    <label for="price" class="form-label" required>Prix de l'appartement</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Prix de l'appartement" step="1" required>
                </div> --}}

                <div class="mb-3">
                    <div class="form-group">
                        <label for="type_select" class="form-label">Type de l'appartement</label>
                        <select id="type_select" class="form-control select2" name="type" style="width: 100%!important" required>
                            <option value="">Selectionner le type de l'appartement</option>
                            <option value="RV1">RV1</option>
                            <option value="RV2">RV2</option>
                            <option value="STUDIO">STUDIO</option>
                        </select>
                    </div>

                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                <a id="close_btn" class="m-2 text-white btn btn-danger">Fermer</a>

            </form>

        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="section-header">
                    <h1>Listes des appartements</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="appart-table">
                            <thead>
                                <tr>
                                    <th>
                                        Nom de l'appartement
                                    </th>
                                    <th>Type</th>
                                    <th>Code</th>

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

            <div class="modal fade" id="appartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de l'appartement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screeresult" role="alert">
                            </div>
                            <form enctype="multipart/form-data" method="post" id="modal-appart-form" action="javascript:update_appart()">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de l'appartement</label>
                                    <input type="text" class="form-control" id="modal-name" name="name" placeholder="Nom de l'appartement" aria-describedby="Nom de l'appartement" required>
                                </div>

                                <div class="mb-3">
                                    <label for="code" class="form-label">Code de l'appartement</label>
                                    <input type="text" class="form-control" id="modal-code" name="code" placeholder="Code de l'appartement" aria-describedby="Nom de l'appartement" required>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="modal-price" class="form-label" required>Prix de l'appartement</label>
                                    <input type="number" class="form-control" id="modal-price" name="price" placeholder="Prix de l'appartement" step="0.01" required>

                                </div> --}}
                                <div class="mb-3">
                                    <div id="modal-type-select-div" class="form-group">
                                        <label for="type" class="form-label">Type de l'appartement</label>
                                        <select id="modal_type_select" class="form-control select2" name="type" style="width: 100%!important">
                                            <option value="">Choisir le type de l'appartement</option>
                                            <option value="RV1">RV1</option>
                                            <option value="RV2">RV2</option>
                                            <option value="STUDIO">STUDIO</option>
                                        </select>
                                    </div>
                                    <div id="modal-type-div" class="form-group">
                                        <label for="type" class="form-label">Type de l'appartement</label>
                                        <input type="text" class="form-control" id="modal-type" placeholder="">

                                    </div>
                                </div>
                                <div class="mb-3 form-group">
                                    <div class="form-label">L'appartement est tjrs en service</div>
                                    <label class="custom-switch mt-2">
                                        <input id="status_check" type="checkbox" name="" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"> OUI</span>
                                    </label>
                                    <input id="hidden_check" type="hidden" name="status" value="0" />
                                </div>

                                <button type="submit" id="modal-submit" class="btn btn-primary">Enregistrer</button>
                                <a type="button" id="close_modal" class="text-white btn btn-warning" data-dismiss="modal">Close</a>


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
            loadApparts()

            $("#new_appart_div").hide();
            $("#screeresult").hide()

            $('#new_appart_btn').click(function() {
                $("#new_appart_div").show();
                $("#new_appart_btn").hide();

                $("#name").show().prop('required', true);

                // $("#code").show().prop('required', true);

                // $("#price").show().prop('required', true);

            });
            $('#close_btn').click(function() {

                $("#name").hide().prop('required', false);

                // $("#code").hide().prop('required', false);

                // $("#price").hide().prop('required', false);

                $("#new_appart_div").hide();
                $("#new_appart_btn").show();


                $('#appart-form')[0].reset();

            });


            // $('#code').keyup(function() {
            //     this.value = this.value.toLocaleUpperCase();
            // });

            chargeRecapDate()


            $('#close_modal').click(function() {

                $("#modal_type_select").val("");

                $('#modal_type_select').trigger('change');
            });



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

        function addAppart() {
            var frm = $('#appart-form');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('addAppart') }}',
                method: 'POST',
                data: frm.serialize(),
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#appart-form')[0].reset();
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                                loadApparts();
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
                    $("#screeresult").html(data.message);
                    $('#submit').html("Connexion").prop("disabled", false);

                },
            });
        }

        function loadApparts() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getApparts') }}',
                method: 'GET',
                success: function(response) {
                    $('#appart-table').DataTable({
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
                            url: "{{ route('getApparts') }}",
                            dataType: 'JSON'
                        },

                        "data": response.data,
                        "columns": [

                            {
                                "data": "name"

                            },
                            {
                                "data": "type"
                            },
                            {
                                "data": "code"
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

                                    return '<button value="' + data + '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#appartModal"><i class="fa fa-eye"></i></button> <button value="' + data + '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#appartModal"><i class="fa fa-pencil-alt"></i></button>';
                                },
                            },
                            {
                                "targets": -2,
                                "data": "current_state",
                                render: function(data, type, row, meta) {
                                    console.log(data)
                                    if (data == 'RESERVE') {
                                        return "<div class='badge badge-info'> <h8>Réservé</h8> </div>";

                                    } else if (data == 'OCCUPE') {
                                        return "<div class='badge badge-danger'> <h8>Occupé</h8></div>  ";

                                    } else if (data == 'LIBRE') {
                                        return "<div class='badge badge-success'><h8> Libre</h8></div>  ";

                                    }
                                },
                            },


                        ]
                    });
                }

            });
        }

        function update_appart() {


            if ($('#status_check').is(":checked")) {
                $("#hidden_check").val(1)
            } else {
                $("#hidden_check").val(0)
            }


            //Form data
            var data = new FormData();
            var form_data = $('#modal-appart-form').serializeArray();


            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });


            if (!$('#modal_type_select').val()) {
                var type = $('#modal-type').val()
                data.set("type", type);
            }




            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateAppart') }}',
                method: 'POST',

                processData: false,
                contentType: false,
                data: data,
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
                                loadApparts();
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
                    $("#screeresult").html("Une errreur s'est produite");
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
                url: '{{ route('getAppartById') }}',
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

                        $("#modal-name").prop('readonly', true);
                        $("#modal-code").prop('readonly', true);
                        // $("#modal-price").prop('readonly', true);
                        $("#modal-type").prop('readonly', true);
                        $("#modal-type").prop('required', false);
                        $('#status_check').prop("disabled", true);
                        $('#modal_type_select').prop("disabled", true);



                        $('#modal-name').val(data.name);
                        $('#modal-code').val(data.code);
                        // $('#modal-price').val(data.price);
                        $('#modal-type').val(data.type);
                        $('#modal_type_select').val();
                        $('#modal-submit').hide();

                        $('#modal-type-select-div').hide();
                        $('#modal-type-div').show();


                        if (data.status) {
                            $('#status_check').prop("checked", true);
                        } else {
                            $('#status_check').prop("checked", false);
                        }



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
                url: '{{ route('getAppartById') }}',
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

                        $("#modal-name").prop('readonly', false);
                        $("#modal-code").prop('readonly', true);
                        // $("#modal-price").prop('readonly', false);
                        $('#status_check').prop("disabled", false);
                        $('#modal_type_select').prop("disabled", false);

                        $("#modal-type").hide();

                        $('#modal-type-select-div').show();
                        $('#modal-type-div').hide();



                        $('#modal-name').val(data.name);
                        $('#modal-code').val(data.code);
                        $('#modal-type').val(data.type)
                        // $('#modal-price').val(data.price);
                        $('#modal-submit').show();


                        if (data.status) {
                            $('#status_check').prop("checked", true);
                        } else {
                            $('#status_check').prop("checked", false);
                        }



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
