<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-25 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Thèmes</div>

                    <div class="panel-body">

                        <div class="form-group pull-right">
                            Rechercher :
                            <input type="text" class="form-control input-search" id="search" name="search" placeholder="Nom thème">
                        </div>
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead>
                            <tr class="data-row">
                                <th>Thème</th>
                                <th>Editeur</th>
                                <th>Catégorie</th>
                                <th>Sous-Catégorie</th>
                                <th>Code</th>
                                <th>Examen</th>
                                <th>Officiel</th>
                                <?php if(Auth::user()->role != 'Agent'): ?>
                                    <th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                	<th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Thèmes')"><i class="fa fa-save"></i></button></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php foreach($themes as $theme): ?>
                                <tr>
                                    <td class="tdtheme"><?php echo e($theme->Nom_Theme); ?></td>
                                    <td class="tded"><?php echo e($theme->Nom_Ed); ?></td>
                                    <td class="tdcat"><?php echo e($theme->Categorie); ?></td>
                                    <td class="tdscat"><?php echo e($theme->Sous_Categorie); ?></td>
                                    <td class="tdcode"><?php echo e($theme->Code); ?></td>
                                    <td class="tdexam"><?php echo e($theme->Examen); ?></td>
                                    <td class="tdoff"><?php echo e($theme->Officiel); ?></td>
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter une inscription</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/createTh" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="ntheme" class="col-4 col-form-label">Nom thème</label>
                            <div class="col-8">
                                <input id="ntheme" name="ntheme" type="text" required="required" class="form-control">
                            </div>
                        </div>

                        <div class="form-group w-25">
                            <label for="ned" class="col-4 col-form-label">Editeur</label>
                            <div class="col-8">
                                <select id="ned" name="ned" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($editeurs as $editeur): ?>
                                        <option value="<?php echo e($editeur->Nom_Ed); ?>">
                                            <?php echo e($editeur->Nom_Ed); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="cat" class="col-4 col-form-label">Catégorie</label>
                            <div class="col-8">
                                <select id="cat" name="cat" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <?php foreach($categories as $categorie): ?>
                                        <option value="<?php echo e($categorie->Nom_Cat); ?>">
                                            <?php echo e($categorie->Nom_Cat); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group w-25">
                            <label for="scat" class="col-4 col-form-label">Sous catégorie</label>
                            <div class="col-8">
                                <input id="scat" name="scat" type="text" required="required" class="form-control">

                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="code" class="col-4 col-form-label">Code</label>
                            <div class="col-8">
                                <input id="code" name="code" type="text" required="required" class="form-control">

                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="ex" class="col-4 col-form-label">Examen</label>
                            <div class="col-8">
                                <input id="ex" name="ex" type="text" required="required" class="form-control">

                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="off" class="col-4 col-form-label">Officiel</label>
                            <div class="col-8">
                                <select id="off" name="off" class="form-control" required="required">
                                    <option value="">Sélectionner</option>
                                    <option value="Oui">Oui</option>
                                    <option value="Non">Non</option>
*
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
                    <h3 class="modal-title" id="exampleModalLongTitle">Modifier thème</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/themes/edit" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
    <div class="form-group w-25">
        <label for="editntheme" class="col-4 col-form-label">Nom thème</label>
            <div class="col-8">
                <input id="editntheme" name="editntheme" type="text" required="required" class="form-control" readonly>
            </div>
    </div>

    <div class="form-group w-25">
        <label for="editned" class="col-4 col-form-label">Editeur</label>
        <div class="col-8">
            <select id="editned" name="editned" class="form-control" required="required">
                <option>Sélectionner</option>
                <?php foreach($editeurs as $editeur): ?>
                    <option value="<?php echo e($editeur->Nom_Ed); ?>">
                        <?php echo e($editeur->Nom_Ed); ?>

                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group w-25">
        <label for="editcat" class="col-4 col-form-label">Catégorie</label>
        <div class="col-8">
            <select id="editcat" name="editcat" class="form-control" required="required">
                <option>Sélectionner</option>
                <?php foreach($categories as $categorie): ?>
                    <option value="<?php echo e($categorie->Nom_Cat); ?>">
                        <?php echo e($categorie->Nom_Cat); ?>

                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group w-25">
        <label for="editscat" class="col-4 col-form-label">Sous catégorie</label>
        <div class="col-8">
            <input id="editscat" name="editscat" type="text" required="required" class="form-control">

        </div>
    </div>
    <div class="form-group w-25">
        <label for="editcode" class="col-4 col-form-label">Code</label>
        <div class="col-8">
            <input id="editcode" name="editcode" type="text" required="required" class="form-control">

        </div>
    </div>
    <div class="form-group w-25">
        <label for="editex" class="col-4 col-form-label">Examen</label>
        <div class="col-8">
            <input id="editex" name="editex" type="text" required="required" class="form-control">

        </div>
    </div>
    <div class="form-group w-25">
        <label for="editoff" class="col-4 col-form-label">Officiel</label>
        <div class="col-8">
            <select id="editoff" name="editoff" class="form-control" required="required">
                <option value="">Sélectionner</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>

            </select>
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
                <form action = "/themes/delete" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                        <div class="form-group w-25">
                            <label for="deltheme" class="col-4 col-form-label">Nom Thème</label>
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

    <script type="text/javascript">
        const search = document.getElementById('search');
        const tableBody = document.getElementById('tbody');
        function getContent(){
            const searchValue = search.value;

            const xhr = new XMLHttpRequest();
            xhr.open('GET','<?php echo e(route('ThemeController.search')); ?>/?search=' + searchValue ,true);
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
            var _theme = _row.find(".tdtheme").text();
            var _ed = _row.find(".tded").text();
            var _cat = _row.find(".tdcat").text();
            var _scat = _row.find(".tdscat").text();
            var _code = _row.find(".tdcode").text();
            var _exam= _row.find(".tdexam").text();
            var _off = _row.find(".tdoff").text();



            jQuery("#editntheme").val(_theme);
            jQuery("#editned").val(_ed);
            jQuery("#editcat").val(_cat);
            jQuery("#editscat").val(_scat);
            jQuery("#editcode").val(_code);
            jQuery("#editex").val(_exam);
            jQuery("#editoff").val(_off);




        });
    </script>

    <script>
        jQuery(".btndel").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _code = _row.find(".tdtheme").text();



            jQuery("#deltheme").val(_code);




        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>