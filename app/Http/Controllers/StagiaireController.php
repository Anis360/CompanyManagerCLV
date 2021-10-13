<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StagiaireController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $stagiaires = DB::select('select * from stagiaire');

            return view('stagiaires')->with('stagiaires', $stagiaires);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $nom = $request->input('nom');
        $ste = $request->input('ste');
        $fn = $request->input('fn');
        $tel = $request->input('tel');
        $email = $request->input('email');

        DB::insert('insert into stagiaire (Prenom_Nom_Stgre, Societe_Stgre, Fonction_Stgre, Tel_Stgre, Email_Stgre) values(?, ?, ?, ?, ?)',[$nom, $ste, $fn, $tel, $email]);
        return redirect(route('stagiaires.index'));
    }

    public function edit(Request $request) {
        $nom = $request->input('editnom');
        $ste = $request->input('editste');
        $fn = $request->input('editfn');
        $tel = $request->input('edittel');
        $email = $request->input('editemail');


        DB::update('update stagiaire set Societe_Stgre = ?, Fonction_Stgre = ?, Tel_Stgre = ?, Email_Stgre = ? where Prenom_Nom_Stgre = ?',[$ste, $fn, $tel, $email, $nom]);

        return redirect(route('stagiaires.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nomstg = $request->input('delstg');
        DB::delete('delete from stagiaire where Prenom_Nom_Stgre = ?',[$nomstg]);
        return redirect(route('stagiaires.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $stagiaires = DB::table('stagiaire')->where('Prenom_Nom_Stgre', 'LIKE', '%' . $request->search . "%")->get();

            if ($stagiaires) {

                foreach ($stagiaires as $stagiaire) {

                    $output .= '<tr>' .

                        '<td>' . $stagiaire->Prenom_Nom_Stgre . '</td>' .

                        '<td>' . $stagiaire->Societe_Stgre . '</td>' .

                        '<td>' . $stagiaire->Fonction_Stgre . '</td>' .

                        '<td>' . $stagiaire->Tel_Stgre . '</td>' .

                        '<td>' . $stagiaire->Email_Stgre . '</td>';

                    if(Auth::user()->role != 'Agent')
                    {
                        $output .= '<td style="width:50px"><button id ="idbtnedit" class="btn btn-warning btnedit" data-toggle="modal" data-target="#modifier" data-item-id="1"><i class="fa fa-pencil"></i></button></td>' .

                            '<td style="width:50px"><button type="button" class="btn btn-danger btndel" data-toggle="modal" data-target="#delmodal"><i class="fa fa-trash"></i></button></td>';
                    }
                    $output .= '</tr>';

                }


                return $output;

            }

        }
    }
}
