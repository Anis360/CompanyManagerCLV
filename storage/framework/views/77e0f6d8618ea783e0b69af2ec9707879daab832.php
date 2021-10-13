<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-25 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Utilisateurs</div>

                    <div class="panel-body">

                        <div class="form-group pull-right">
                            Rechercher :
                            <input type="text" class="form-control input-search" id="search" name="search" placeholder="Nom ou Adresse courriel">

                        </div>
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead>
                            <tr class="data-row">
                                <th>Nom</th>
                                <th>Adresse courriel</th>
                                <th>Role</th>
                                <th>Date de création</th>
                                <?php if(Auth::user()->role == 'Super administrateur'): ?>
                                <th style="width:50px"><button class="btn btn-primary" data-toggle="modal" data-target="#ajout"><i class="fa fa-plus"></i></button></th>
                                <th style="width:50px"><button type="button" id="export" class="btn btn-success" onclick="tableToExcel('table', 'Utilisateurs')"><i class="fa fa-save"></i></button></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php foreach($utilisateurs as $utilisateur): ?>
                                <tr>
                                    <td class="tdnom"><?php echo e($utilisateur->name); ?></td>
                                    <td class="tdemail"><?php echo e($utilisateur->email); ?></td>
                                    <td class="tdrole"><?php echo e($utilisateur->role); ?></td>
                                    <td class="tddatecr"><?php echo e($utilisateur->created_at); ?></td>
                                    <?php if(Auth::user()->role == 'Super administrateur'): ?>
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

    <!-- Modal Ajoutttttttttttt -->
    <div class="modal fade" id="ajou" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter un utilisateur</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>">

                            <?php if($errors->has('name')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">

                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-4 control-label">Role</label>

                        <div class="col-md-6">
                            <select name="role" class="form-control" >
                                <option value="Super administrateur">Super administrateur</option>
                                <option value="Administrateur">Administrateur</option>
                                <option value="Agent">Agent</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i> Register
                        </button>
                    </div>

            </div>
        </div>
        </form>

    </div>
    </div>
    </div>



    <!-- Modal Ajout -->
    <div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Ajouter un utilisateur</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action = "/createUt" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">

                        <div class="form-group w-25">
                            <label for="nom" class="col-4 col-form-label">Nom utilisateur</label>
                            <div class="col-8">
                                <input id="nom" name="nom" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="email" class="col-4 col-form-label">Adresse courriel</label>
                            <div class="col-8">
                                <input id="email" name="email" type="text" required="required" class="form-control">
                            </div>
                            <label for="pwd" class="col-4 col-form-label">Mot de passe</label>
                            <div class="col-8">
                                <input id="pwd" name="pwd" type="password" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="role" class="col-4 col-form-label">Rôle</label>
                            <div class="col-8">
                                <select id="role" name="role" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <option value="Super administrateur">
                                        Super administrateur
                                    </option>
                                    <option value="Administrateur">
                                        Administrateur
                                    </option>
                                    <option value="Agent">
                                        Agent
                                    </option>
                                </select>
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
                <form action = "/utilisateurs/edit" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="form-group w-25">
                            <label for="editnom" class="col-4 col-form-label">Nom utilisateur</label>
                            <div class="col-8">
                                <input id="editnom" name="editnom" type="text"class="form-control" required="required" readonly>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editemail" class="col-4 col-form-label">Adresse courriel</label>
                            <div class="col-8">
                                <input id="editemail" name="editemail" type="text" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="editrole" class="col-4 col-form-label">Role</label>
                            <div class="col-8">
                                <!--if(Auth::user()->role == 'Super administrateur')
                                    <input id="editrole" name="editrole" class="form-control" required="required" readonly>
                                else-->
                                <select id="editrole" name="editrole" class="form-control" required="required">
                                    <option>Sélectionner</option>
                                    <option value="Super administrateur">
                                        Super administrateur
                                    </option>
                                    <option value="Administrateur">
                                        Administrateur
                                    </option>
                                    <option value="Agent">
                                        Agent
                                    </option>
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
                <form action = "/utilisateurs/delete" method = "post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer l'élèment suivant ?</p>
                        <div class="form-group w-25">
                            <label for="deluser" class="col-4 col-form-label">Nom inscription</label>
                            <div class="col-8">
                                <input id="deluser" name="deluser" type="text" required="required" class="form-control" readonly>
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
            xhr.open('GET','<?php echo e(route('UtilisateurController.search')); ?>/?search=' + searchValue ,true);
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

            var _row = jQuery(this).closest("tr")
            var _nom = _row.find(".tdnom").text();
            var _email= _row.find(".tdemail").text();
            var _role= _row.find(".tdrole").text();



            jQuery("#editnom").val(_nom);
            jQuery("#editemail").val(_email);
            jQuery("#editrole").val(_role);



        });
    </script>

    <script>
        jQuery(".btndel").click(function() {

            // var _button = $(e.relatedTarget);

            // console.log(_button, _button.parents("tr"));
            var _row = jQuery(this).closest("tr")
            var _nom = _row.find(".tdnom").text();



            jQuery("#deluser").val(_nom);




        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>