<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-25 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Salles</div>

                    <div class="panel-body">

                        <div class="form-group pull-right">
                            Rechercher :
                            <input type="text" class="form-control input-search" id="search" name="search" placeholder="Nom salle">
                        </div>
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead>
                            <tr class="data-row">
                                <th>Nom</th>
                                <th>Capacité</th>
                                <?php if(Auth::user()->role != 'Agent'): ?>
                                	<th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                	<th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Salles')"><i class="fa fa-save"></i></button></th>
                            	<?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php foreach($salles as $salle): ?>
                                <tr>
                                    <td class="tdnom"><?php echo e($salle->Nom_SF); ?></td>
                                    <td class="tdcap"><?php echo e($salle->Capacite_SF); ?></td>
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter une salle</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/createSl" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="nom" class="col-4 col-form-label">Nom salle</label>
                            <div class="col-8">
                                <input id="nom" name="nom" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="cap" class="col-4 col-form-label">Capacité</label>
                            <div class="col-8">
                                <input id="cap" name="cap" type="number" required="required" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Ajouter">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Modifier éditeur</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/salles/edit" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="form-group w-25">
                            <label for="editnom" class="col-4 col-form-label">Nom salle</label>
                            <div class="col-8">
                                <input id="editnom" name="editnom" type="text" required="required" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editcap" class="col-4 col-form-label">Capacité</label>
                            <div class="col-8">
                                <input id="editcap" name="editcap" type="number" required="required" class="form-control">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Modifier">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
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
                <form action = "/salles/delete" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                        <div class="form-group w-25">
                            <label for="delsf" class="col-4 col-form-label">Nom Salle</label>
                            <div class="col-8">
                                <input id="delsf" name="delsf" type="text" required="required" class="form-control" readonly>
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
            xhr.open('GET','<?php echo e(route('SalleController.search')); ?>/?search=' + searchValue ,true);
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
            var _cap= _row.find(".tdcap").text();




            jQuery("#editnom").val(_nom);
            jQuery("#editcap").val(_cap);


        });
    </script>

    <script>
        jQuery(".btndel").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _nom = _row.find(".tdnom").text();



            jQuery("#delsf").val(_nom);




        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>