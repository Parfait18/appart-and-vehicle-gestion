@extends('layouts.main_layout')

@section('content')
    <div class="">
        <div class="row" style="width: 100%">
            <div class="col-md-4">
                <div id="first-card" class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Total des agents</h5>
                        <h1 id="total" class=" text-center m-4 card-subtitle mb-2 text-muted"></h1>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Agents actifs</h5>
                        <h1 id="active_agent" class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="custum-border card">
                    <div class="card-body">
                        <h5 class="card-title">Agents en désactivés</h5>
                        <h1 id="disabled_agent"class=" text-center m-4 card-subtitle mb-2 text-muted"> </h1>

                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="card">agentAddAgent
                    <div class="card-body">
                        <h5 class="card-title">Agents en hors services</h5>
                        <h1 class=" text-center m-4 card-subtitle mb-2 text-muted"> 22</h1>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row">
        <button id="new_agent_btn" class="m-5 btn btn-primary">Créer un nouvel agent <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

        <div id="new_agent_div" class="mx-auto col-10 offset-1" style="max-width: 70%;display:none">


            <h2 class="text-center mb-4">Enregistrer un nouvel agent</h2>
            <div id="screeresult" role="alert">
            </div>

            <form id="agent-form" action="javascript:AddAgent()">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l' agent</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom de l' agent" aria-describedby="Nom de l' agent" required>

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" required>Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email de l'agent" required>
                </div>
                <div class="mb-3">
                    <div class="">
                        <label for="role" class="form-label">Role de l'agent</label>
                        <select id="matricul_select" class="form-control select2" name="role" style="width: 100%!important" required>
                            <option value="">Choisir le role de l'agent</option>
                            <option value="vehicule">Gestion des vehicules</option>
                            <option value="appartement">Gestion des appartement</option>
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
                    <h1>Listes des agents</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="agent-table">
                            <thead>
                                <tr>
                                    <th>
                                        Nom de l'agent
                                    </th>
                                    <th>Role</th>

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

            <div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Les informations de l' agent</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-screeresult" role="alert">
                            </div>
                            <form enctype="multipart/form-data" method="post" id="modal-agent-form" action="javascript:update_agent()">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de l' agent</label>
                                    <input type="text" class="form-control" id="modal-name" name="name" placeholder="Nom de l'agent" aria-describedby="Nom de l' agent" required>

                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label" required>Email</label>
                                    <input type="email" class="form-control" name="email" id="modal-email" placeholder="Email de l'agent" required>
                                </div>
                                <div class="mb-3">
                                    <div id="modal-role-select-div" class="form-group">
                                        <label for="role" class="form-label">Role de l'agent</label>
                                        <select id="modal-role-select" class="form-control select2" name="role" style="width: 100%!important">
                                            <option value="">Choisir le role de l'agent</option>
                                            <option value="vehicule">Gestion des vehicules</option>
                                            <option value="appartement">Gestion des appartement</option>
                                        </select>
                                    </div>
                                    <div id="modal-role-div" class="form-group">
                                        <label for="role" class="form-label">Role de l'agent</label>
                                        <input type="text" id="modal-role" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 form-group">
                                    <div class="form-label">L' agent est en service</div>
                                    <label class="custom-switch mt-2">
                                        <input id="status_check" type="checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"> OUI</span>
                                    </label>
                                    <input id="hidden_check" type="hidden" name="status" value="0" />
                                </div>
                                <button type="submit" id="modal-submit" class="btn btn-primary">Enregistrer</button>
                                <a type="button" class="text-white btn btn-warning" data-dismiss="modal">Close</a>


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
            loadAgents()

            $("#new_agent_div").hide();
            $("#screeresult").hide()

            $('#new_agent_btn').click(function() {
                $("#new_agent_div").show();
                $("#new_agent_btn").hide();

                $("#name").show().prop('required', true);

                $("#matricule").show().prop('required', true);

                $("#color").show().prop('required', true);

            });
            $('#close_btn').click(function() {

                $("#name").hide().prop('required', false);

                $("#matricule").hide().prop('required', false);

                $("#color").hide().prop('required', false);

                $("#new_agent_div").hide();
                $("#new_agent_btn").show();


                $('#agent-form')[0].reset();

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
                url: '{{ route('getRecapAgent') }}',
                method: 'GET',
                success: function(response) {
                    try {

                        $('#total').html(response.total);
                        $('#disabled_agent').html(response.disabled_agent);
                        $('#active_agent').html(response.active_agent);


                    } catch (error) {
                        console.log(error)

                    }

                },
                error: function(data) {
                    console.log(data)
                },
            });
        }

        function AddAgent() {
            var frm = $('#agent-form');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('addAgent') }}',
                method: 'POST',
                data: frm.serialize(),
                beforeSend: function(data) {
                    $('#submit').html('Patientez... <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>').prop("disabled", true);
                },
                success: function(data) {
                    $('#submit').html('connexion').prop("disabled", false);


                    try {

                        if (data.success) {
                            $('#agent-form')[0].reset();
                            $("#screeresult").html(data.message);
                            $("#screeresult").show();

                            $("#screeresult").removeClass("alert alert-success");
                            $("#screeresult").removeClass("alert alert-danger");
                            $("#screeresult").addClass("alert alert-success");
                            setTimeout(function() {
                                $("#screeresult").hide();
                                loadAgents()
                                chargeRecapDate()
                            }, 3000); //wait 2 seconds

                            $('#modal-submit').html('Enregistrer').prop("disabled", false);

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

        function loadAgents() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('getAgents') }}',
                method: 'GET',
                success: function(response) {
                    $('#agent-table').DataTable({
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
                            url: "{{ route('getAgents') }}",
                            dataType: 'JSON'
                        },

                        "data": response.data,
                        "columns": [

                            {
                                "data": "name"

                            },
                            {
                                "data": "role"
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

                                    return '<button value="' + data + '" class="btn btn-primary text-white" id="actionView" data-bs-toggle="modal" data-bs-target="#agentModal"><i class="fa fa-eye"></i></button> <button value="' + data + '" class="btn btn-success text-white" id="actionEdit" data-bs-toggle="modal" data-bs-target="#agentModal"><i class="fa fa-pencil-alt"></i></button>';
                                },
                            },
                            {
                                "targets": -2,
                                "data": "status",
                                render: function(data, type, row, meta) {
                                    // console.log(data)
                                    if (data == 1) {
                                        return "<div class='badge badge-success'><h8>En activité</h8> </div>";

                                    } else {
                                        return "<div class='badge badge-danger'><h8> Suspendu </h8></div>  ";

                                    }
                                },
                            },



                        ]
                    });
                }

            });
        }

        function update_agent() {
            // var frm = $('#modal-agent-form');

            if ($('#status_check').is(":checked")) {
                $("#hidden_check").val(1)
            } else {
                $("#hidden_check").val(0)
            }


            //Form data
            var data = new FormData();
            var form_data = $('#modal-agent-form').serializeArray();


            $.each(form_data, function(key, input) {
                data.append(input.name, input.value);
            });


            if (!$('#modal-role-select').val()) {
                var role = $('#modal-role').val()
                data.set("role", role);
            }



            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('updateAgent') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(data) {

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
                                this.loadAgents()
                                loadAgents()
                                chargeRecapDate()
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
                url: '{{ route('getAgentById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    try {
                        let data = JSON.parse(response).data
                        $('#agentModal').modal('toggle');
                        $('#agentModal').modal('show');

                        $("#modal-name").prop('readonly', true);
                        $("#modal-email").prop('readonly', true);
                        $("#modal-role").prop('readonly', true);
                        $('#status_check').prop("disabled", true);


                        $('#modal-role-select-div').hide();
                        $('#modal-role-div').show();

                        $('#modal-name').val(data.name);
                        $('#modal-email').val(data.email);
                        $('#modal-role').val(data.role);


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
                url: '{{ route('getAgentById') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    try {
                        let data = JSON.parse(response).data
                        $('#agentModal').modal('toggle');
                        $('#agentModal').modal('show');

                        if (data.status) {
                            $('#status_check').prop("checked", true);
                        } else {
                            $('#status_check').prop("checked", false);
                        }

                        $("#modal-name").prop('readonly', false);
                        $("#modal-email").prop('readonly', true);
                        // $("#modal-color").prop('readonly', false);
                        $('#status_check').prop("disabled", false);

                        $('#modal-role-select-div').show();
                        $('#modal-role-div').hide();



                        $('#modal-name').val(data.name);
                        $('#modal-email').val(data.email);
                        $('#modal-role').val(data.role);
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
