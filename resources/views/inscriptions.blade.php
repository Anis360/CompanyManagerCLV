@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-25 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Inscriptions</div>

                <div class="panel-body">

                    <div class="form-group pull-right">
                        Rechercher :
                        <input type="text" class="form-control input-search" id="search" name="search" placeholder="Nom & Code">


                    </div>

                    <table class="table table-bordered table-striped table-hover" id="table">
                        <thead>
                        <tr class="data-row">
                            <th>Code inscription</th>
                            <th>Stagiaire</th>
                            <th>Thème session</th>
                            <th>Statut</th>
                            @if(Auth::user()->role != 'Agent')
                                <th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                <th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Inscriptions')"><i class="fa fa-save"></i></button></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach ($inscriptions as $inscription)
                            <tr>
                                <td class="tdcode">{{ $inscription->Code_Inscription }}</td>
                                <td class="tdnomstgre">{{ $inscription->Nom_Stgre }}</td>
                                <td class="tdthmss">{{ $inscription->Theme_Session }}</td>
                                <td class="tdstt">{{ $inscription->Statut }}</td>
                                @if(Auth::user()->role != 'Agent')
                                    <td style="width:50px"><button id ="idbtnedit" class="btn btn-warning btnedit" data-toggle="modal" data-target="#modifier" data-item-id="1"><i class="fa fa-pencil"></i></button></td>
                                    <td style="width:50px"><button type="button" class="btn btn-danger btndel" data-toggle="modal" data-target="#delmodal"><i class="fa fa-trash"></i></button></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Ajouter une inscription</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action = "/createIn" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="modal-body">

                    <div class="form-group w-25">
                        <label for="code" class="col-4 col-form-label">Code inscription</label>
                        <div class="col-8">
                            <input id="code" name="code" type="text" required="required" class="form-control">
                        </div>
                    </div>

                    <div class="form-group w-25">
                        <label for="nomstgre" class="col-4 col-form-label">Stagiaire</label>
                        <div class="col-8">
                            <select id="nomstgre" name="nomstgre" class="form-control" required="required">
                                <option>Sélectionner</option>
                                @foreach ($stagiaires as $stagiaire)
                                    <option value="{{ $stagiaire->Prenom_Nom_Stgre }}">
                                        {{ $stagiaire->Prenom_Nom_Stgre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group w-25">
                        <label for="thmss" class="col-4 col-form-label">Thème</label>
                        <div class="col-8">
                            <select id="thmss" name="thmss" class="form-control" required="required">
                                <option>Sélectionner</option>
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->Nom_Theme }}">
                                        {{ $theme->Nom_Theme }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group w-25">
                        <label for="stt" class="col-4 col-form-label">Etat</label>
                        <div class="col-8">
                            <select id="stt" name="stt" class="form-control" required="required">
                                <option value="">Sélectionner</option>
                                <option value="Souhaitée">Souhaitée</option>
                                <option value="Confirmée">Confirmée</option>
                                <option value="Non confirmée">Non confirmée</option>
                                <option value="Accomplie">Accomplie</option>
                                <option value="Annulée">Annulée</option>
                                <option value="No Show">No Show</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Modifier -->
<div class="modal fade" id="modifier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Modifier une inscription</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action = "/inscriptions/edit" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="modal-body">

                    <div class="form-group w-25">
                        <label for="editcode" class="col-4 col-form-label">Code inscription</label>
                        <div class="col-8">
                            <input id="editcode" name="editcode" type="text" required="required" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group w-25">
                        <label for="editnomstgre" class="col-4 col-form-label">Stagiaire</label>
                        <div class="col-8">
                            <select id="editnomstgre" name="editnomstgre" class="form-control" required="required">
                                <option>Sélectionner</option>
                                @foreach ($stagiaires as $stagiaire)
                                    <option value="{{ $stagiaire->Prenom_Nom_Stgre }}">
                                        {{ $stagiaire->Prenom_Nom_Stgre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group w-25">
                        <label for="editthmss" class="col-4 col-form-label">Thème</label>
                        <div class="col-8">
                            <select id="editthmss" name="editthmss" class="form-control" required="required">
                                <option>Sélectionner</option>
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->Nom_Theme }}">
                                        {{ $theme->Nom_Theme }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group w-25">
                        <label for="editetat" class="col-4 col-form-label">Etat</label>
                        <div class="col-8">
                            <select id="editstt" name="editstt" class="form-control" required="required">
                                <option value="">Sélectionner</option>
                                <option value="Souhaitée">Souhaitée</option>
                                <option value="Confirmée">Confirmée</option>
                                <option value="Non confirmée">Non confirmée</option>
                                <option value="Accomplie">Accomplie</option>
                                <option value="Annulée">Annulée</option>
                                <option value="No Show">No Show</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <input type="submit" class="btn btn-primary" value="Modifier">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->

<div class="modal fade" id="delmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action = "/inscriptions/delete" method = "post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                    <div class="form-group w-25">
                        <label for="delins" class="col-4 col-form-label">Nom inscription</label>
                        <div class="col-8">
                            <input id="delins" name="delins" type="text" required="required" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Confirmer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    const search = document.getElementById('search');
    const tableBody = document.getElementById('tbody');
    function getContent(){
        const searchValue = search.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET','{{route('InscriptionController.search')}}/?search=' + searchValue ,true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {

            if(xhr.readyState == 4 && xhr.status == 200)
            {
                tableBody.innerHTML = xhr.responseText;
            }
        }
        xhr.send()
    }
    search.addEventListener('input',getContent);
</script>

<script>
    jQuery(".btnedit").click(function() {

        // var _button = $(e.relatedTarget);

        // console.log(_button, _button.parents("tr"));
        var _row = jQuery(this).closest("tr")
        var _code = _row.find(".tdcode").text();
        var _nomstgre = _row.find(".tdnomstgre").text();
        var _thmss = _row.find(".tdthmss").text();
        var _stt = _row.find(".tdstt").text();


        jQuery("#editcode").val(_code);
        jQuery("#editnomstgre").val(_nomstgre);
        jQuery("#editthmss").val(_thmss);
        jQuery("#editstt").val(_stt);




    });
</script>

<script>
    jQuery(".btndel").click(function() {

        // var _button = $(e.relatedTarget);

        // console.log(_button, _button.parents("tr"));
        var _row = jQuery(this).closest("tr")
        var _code = _row.find(".tdcode").text();



        jQuery("#delins").val(_code);




    });
</script>

@endsection