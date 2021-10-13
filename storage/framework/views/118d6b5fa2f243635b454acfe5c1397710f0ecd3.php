<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-25 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Sessions</div>

                    <div class="panel-body">
                        <div class="form-group pull-right">
                            Rechercher :
                            <input type="text" class="form-control input-search" id="search" name="search"  placeholder="Thème session">


                        </div>
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead>
                            <tr class="data-row">
                                <th>Thème session</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Formateur 1</th>
                                <th>Formateur 2</th>
                                <th>Salle</th>
                                <th>Etat</th>
                                <th>Commentaire</th>
                                <?php if(Auth::user()->role != 'Agent'): ?>
                                    <th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                    <th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Sessions')"><i class="fa fa-save"></i></button></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php foreach($sessions as $session): ?>
                                <tr>
                                    <!--<td class="tdid"><?php echo e($session->ID_Session); ?></td>-->
                                    <td class="tdtheme"><?php echo e($session->Theme_Session); ?></td>
                                    <td class="tddb"><?php echo e($session->Date_Debut); ?></td>
                                    <td class="tddf"><?php echo e($session->Date_Fin); ?></td>
                                    <td class="tdnf1"><?php echo e($session->Nom_Formateur1); ?></td>
                                    <td class="tdnf2"><?php echo e($session->Nom_Formateur2); ?></td>
                                    <td class="tdsf"><?php echo e($session->Nom_SF); ?></td>
                                    <td class="tdet"><?php echo e($session->Etat); ?></td>
                                    <td class="tdcomm"><?php echo e($session->Commentaire); ?></td>
                                    <?php if(Auth::user()->role != 'Agent'): ?>
                                    	<td style="width:50px"><button id ="idbtnedit" class="btn btn-warning btnedit" data-toggle="modal" data-target="#modifier" data-item-id="1"><i class="fa fa-pencil"></i></button></td>
                                    	<td style="width:50px"><button type="button" class="btn btn-danger btndel" data-toggle="modal" data-target="#delmodal"><i class="fa fa-trash"></i></button></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter une session</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/createSs" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="theme" class="col-4 col-form-label">Thème session</label>
                            <div class="col-8">
                                <select id="theme" name="theme" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($themes as $theme): ?>
                                        <option value="<?php echo e($theme->Nom_Theme); ?>">
                                            <?php echo e($theme->Nom_Theme); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="datedebut" class="col-4 col-form-label">Date début</label>
                            <div class="col-8">
                                <input id="datedebut" name="datedebut" type="date" class="form-control datepicker-autoclose" required="required">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="datefin" class="col-4 col-form-label">Date Fin</label>
                            <div class="col-8">
                                <input id="datefin" name="datefin" type="date" class="form-control datepicker-autoclose" required="required">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="frr1" class="col-4 col-form-label">Formateur 1</label>
                            <div class="col-8">
                                <select id="frr1" name="frr1" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($fr as $f): ?>
                                        <option value="<?php echo e($f->Prenom_Nom_Formateur); ?>">
                                            <?php echo e($f->Prenom_Nom_Formateur); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="frr2" class="col-4 col-form-label">Formateur 2</label>
                            <div class="col-8">
                                <select id="frr2" name="frr2" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <option value ="Néant">Néant</option>
                                    <?php foreach($fr as $f): ?>
                                        <option value="<?php echo e($f->Prenom_Nom_Formateur); ?>">
                                            <?php echo e($f->Prenom_Nom_Formateur); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="salle" class="col-4 col-form-label">Salle</label>
                            <div class="col-8">
                                <select id="salle" name="salle" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($salles as $salle): ?>
                                        <option value="<?php echo e($salle->Nom_SF); ?>">
                                            <?php echo e($salle->Nom_SF); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="etat" class="col-4 col-form-label">Etat</label>
                            <div class="col-8">
                                <select id="etat" name="etat" class="form-control" required="required">
                                    <option value="">Sélectionner</option>
                                    <option value="Confirmée">Confirmée</option>
                                    <option value="Non confirmée">Non confirmée</option>
                                    <option value="Annulée">Annulée</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="comm" class="col-4 col-form-label">Commentaire</label>
                            <div class="col-8">
                                <input id="comm" name="comm" type="text" class="form-control">
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Modifier session</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/sessions/edit" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="edittheme" class="col-4 col-form-label">Thème session</label>
                            <div class="col-8">
                                <input id="edittheme" name="edittheme" type="text" required="required" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editdatedebut" class="col-4 col-form-label">Date début</label>
                            <div class="col-8">
                                <input id="editdatedebut" name="editdatedebut" type="date" class="form-control datepicker-autoclose" required="required">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editdatefin" class="col-4 col-form-label">Date Fin</label>
                            <div class="col-8">
                                <input id="editdatefin" name="editdatefin" type="date" class="form-control datepicker-autoclose" required="required">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editfrr1" class="col-4 col-form-label">Formateur 1</label>
                            <div class="col-8">
                                <select id="editfrr1" name="editfrr1" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($fr as $f): ?>
                                        <option value="<?php echo e($f->Prenom_Nom_Formateur); ?>">
                                            <?php echo e($f->Prenom_Nom_Formateur); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editfrr2" class="col-4 col-form-label">Formateur 2</label>
                            <div class="col-8">
                                <select id="editfrr2" name="editfrr2" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <option value ="Néant">Néant</option>
                                    <?php foreach($fr as $f): ?>
                                        <option value="<?php echo e($f->Prenom_Nom_Formateur); ?>">
                                            <?php echo e($f->Prenom_Nom_Formateur); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editsalle" class="col-4 col-form-label">Salle</label>
                            <div class="col-8">
                                <select id="editsalle" name="editsalle" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($salles as $salle): ?>
                                        <option value="<?php echo e($salle->Nom_SF); ?>">
                                            <?php echo e($salle->Nom_SF); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editetat" class="col-4 col-form-label">Etat</label>
                            <div class="col-8">
                                <select id="editetat" name="editetat" class="form-control" required="required">
                                    <option value="">Sélectionner</option>
                                    <option value="Confirmée">Confirmée</option>
                                    <option value="Non confirmée">Non confirmée</option>
                                    <option value="Annulée">Annulée</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editcomm" class="col-4 col-form-label">Commentaire</label>
                            <div class="col-8">
                                <input id="editcomm" name="editcomm" type="text" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
                <form action = "/sessions/delete" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                    <div class="form-group w-25">
                        <label for="deltheme" class="col-4 col-form-label">Thème session</label>
                        <div class="col-8">
                            <input id="deltheme" name="deltheme" type="text" required="required" class="form-control" readonly>
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

    <script>
        jQuery(".btnedit").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _theme = _row.find(".tdtheme").text();
            var _datedebut = _row.find(".tddb").text();
            var _datefin = _row.find(".tddf").text();
            var _nf1 = _row.find(".tdnf1").text();
            var _nf2 = _row.find(".tdnf2").text();
            var _salle = _row.find(".tdsf").text();
            var _etat = _row.find(".tdet").text();
            var _comm = _row.find(".tdcomm").text();


            jQuery("#edittheme").val(_theme);
            jQuery("#editdatedebut").val(_datedebut);
            jQuery("#editdatefin").val(_datefin);
            jQuery("#editfrr1").val(_nf1);
            jQuery("#editfrr2").val(_nf2);
            jQuery("#editsalle").val(_salle);
            jQuery("#editetat").val(_etat);
            jQuery("#editcomm").val(_comm);



        });
    </script>

    <script>
        jQuery(".btndel").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _theme = _row.find(".tdtheme").text();



            jQuery("#deltheme").val(_theme);




        });
    </script>







    <script type="text/javascript">
        const search = document.getElementById('search');
        const tableBody = document.getElementById('tbody');
        function getContent(){
            const searchValue = search.value;

            const xhr = new XMLHttpRequest();
            xhr.open('GET','<?php echo e(route('SessionController.search')); ?>/?search=' + searchValue ,true);
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
$(document).ready(function () {
  $('select').change(function () {
    if ($('select option[value="' + $(this).val() + '"]:selected').length > 1) {
      $(this).val('').change();
      alert('Vous avez déjà choisi ce formateur. Veuillez en choisir un autre.')
    }
  });
});

</script>



<!--    <script type="text/javascript">
        $(document).ready(function(){

            $.ajaxSetup({
                headers:{
                    'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });
            $i = 1
            $('#editable').Tabledit({
                url:'<?php echo e(route("SessionController.action")); ?>',
                dataType:"json",
                columns:{
                    identifier:[0, 'ID_Session'],
                    editable:[[1, 'Theme_Session'], [2, 'Date_Debut'], [3, 'Date_Fin'], [4, 'Nom_Formateur1', '{/*'], [5, 'Nom_Formateur2'], [6, 'Nom_SF'], [7, 'Etat', '{"1":"Confirmée", "2":"Non confirmée", "3":"Annulée"}'], [8, 'Commentaire']]
                },
                restoreButton:false,
                onSuccess:function(data, textStatus, jqXHR)
                {
                    if(data.action == 'delete')
                    {
                        $('#'+data.ID_Session).remove();
                    }
                }
            });

        });
    </script>
-->








<!--    <script>
        $(document).ready(function(){
            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'yyyy-mm-dd',
                autoclose:true
            });

            load_data();

            function load_data(from_date = '', to_date = '')
            {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:'<?php echo e(route("sessions.index")); ?>',
                        data:{start_date:from_date, end_date:to_date}
                    },
                    columns: [
                        { data: 'id', name: 'id', 'visible': false},
                        { data: 'Theme_Session', name: 'Theme_Session' },
                        { data: 'Date_Debut', name: 'Date_Debut' },
                        { data: 'Date_Fin', name: 'Date_Fin' },
                        { data: 'Nom_Formateur1', name: 'Nom_Formateur1' },
                        { data: 'Nom_Formateur2', name: 'Nom_Formateur2' },
                        { data: 'Nom_SF', name: 'Nom_SF' },
                        { data: 'Etat', name: 'Etat' },
                        { data: 'Commentaire ', name: 'Commentaire ' },

                    ]
                });
            }

            $('#filter').click(function(){
                var from_date = $('#start_date').val();
                var to_date = $('#end_date').val();
                if(from_date != '' &&  to_date != '')
                {
                    //$('#sessions_table').Datatable().destroy();
                    load_data(from_date, to_date);
                }
                else
                {
                    alert('Both dates are required');
                }
            });

            $('#refresh').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                //$('#sessions_table').Datatable().destroy();
                load_data();
            });

        });
    </script> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>