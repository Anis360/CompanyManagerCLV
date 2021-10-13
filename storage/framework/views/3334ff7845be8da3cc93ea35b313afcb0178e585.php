<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-25 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Stagiaires</div>

                    <div class="panel-body">

                        <div class="form-group pull-right">
                            Rechercher :
                            <input type="text" class="form-control input-search" id="search" name="search" placeholder="Nom stagiaire">
                        </div>
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead>
                            <tr class="data-row">
                                <th>Nom</th>
                                <th>Société</th>
                                <th>Fonction</th>
                                <th>N° du téléphone</th>
                                <th>Adresse de courriel</th>
                                <?php if(Auth::user()->role != 'Agent'): ?>
                                    <th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                	<th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Stagiaires')"><i class="fa fa-save"></i></button></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php foreach($stagiaires as $stagiaire): ?>
                                <tr>
                                    <td class="tdnom"><?php echo e($stagiaire->Prenom_Nom_Stgre); ?></td>
                                    <td class="tdste"><?php echo e($stagiaire->Societe_Stgre); ?></td>
                                    <td class="tdfn"><?php echo e($stagiaire->Fonction_Stgre); ?></td>
                                    <td class="tdtel"><?php echo e($stagiaire->Tel_Stgre); ?></td>
                                    <td class="tdemail"><?php echo e($stagiaire->Email_Stgre); ?></td>
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter une catégorie</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/createSt" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="nom" class="col-4 col-form-label">Nom stagiaire</label>
                            <div class="col-8">
                                <input id="nom" name="nom" type="text" required="required" class="form-control" placeholder="Prénom & nom">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="ste" class="col-4 col-form-label">Société</label>
                            <div class="col-8">
                                <input id="ste" name="ste" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="fn" class="col-4 col-form-label">Fonction</label>
                            <div class="col-8">
                                <input id="fn" name="fn" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="tel" class="col-4 col-form-label">N° du téléphone</label>
                            <div class="col-8">
                                <input id="tel" name="tel" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="email" class="col-4 col-form-label">Adresse de courriel</label>
                            <div class="col-8">
                                <input id="email" name="email" type="text" required="required" class="form-control">
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Modifier stagiaire</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/stagiaires/edit" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="form-group w-25">
                            <label for="editnom" class="col-4 col-form-label">Nom stagiaire</label>
                            <div class="col-8">
                                <input id="editnom" name="editnom" type="text" required="required" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editste" class="col-4 col-form-label">Société</label>
                            <div class="col-8">
                                <input id="editste" name="editste" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editfn" class="col-4 col-form-label">Fonction</label>
                            <div class="col-8">
                                <input id="editfn" name="editfn" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="edittel" class="col-4 col-form-label">N° du téléphone</label>
                            <div class="col-8">
                                <input id="edittel" name="edittel" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editemail" class="col-4 col-form-label">Adresse de courriel</label>
                            <div class="col-8">
                                <input id="editemail" name="editemail" type="text" required="required" class="form-control">
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
                <form action = "/stagiaires/delete" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                        <div class="form-group w-25">
                            <label for="delstg" class="col-4 col-form-label">Nom stagiaire</label>
                            <div class="col-8">
                                <input id="delstg" name="delstg" type="text" required="required" class="form-control" readonly>
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
            xhr.open('GET','<?php echo e(route('StagiaireController.search')); ?>/?search=' + searchValue ,true);
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
            var _nom = _row.find(".tdnom").text();
            var _ste = _row.find(".tdste").text();
            var _fn= _row.find(".tdfn").text();
            var _tel = _row.find(".tdtel").text();
            var _email= _row.find(".tdemail").text();




            jQuery("#editnom").val(_nom);
            jQuery("#editste").val(_ste);
            jQuery("#editfn").val(_fn);
            jQuery("#edittel").val(_tel);
            jQuery("#editemail").val(_email);



        });
    </script>

    <script>
        jQuery(".btndel").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _nom = _row.find(".tdnom").text();



            jQuery("#delstg").val(_nom);




        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>