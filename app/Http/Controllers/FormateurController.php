<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormateurController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $formateurs = DB::select('select * from formateur');

            return view('formateurs')->with('formateurs', $formateurs);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $nomfrr = $request->input('nom');
        $specfrr = $request->input('spec');
        $telfrr = $request->input('tel');
        DB::insert('insert into formateur (Prenom_Nom_Formateur, Specialite_Formateur, Tel_Formateur) values(?, ?, ?)',[$nomfrr, $specfrr, $telfrr]);
        return redirect(route('formateurs.index'));
    }

    public function edit(Request $request) {
        $nomfrr = $request->input('editnom');
        $specfrr = $request->input('editspec');
        $telfrr = $request->input('edittel');


        DB::update('update formateur set Specialite_Formateur = ?, Tel_Formateur = ? where Prenom_Nom_Formateur = ?',[$specfrr, $telfrr, $nomfrr]);

        return redirect(route('formateurs.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nomfrr = $request->input('delfrr');
        DB::delete('delete from formateur where Prenom_Nom_Formateur = ?',[$nomfrr]);
        return redirect(route('formateurs.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $formateurs = DB::table('formateur')->where('Prenom_Nom_Formateur', 'LIKE', '%' . $request->search . "%")->get();

            if ($formateurs) {

                foreach ($formateurs as $formateur) {

                    $output .= '<tr>' .

                        '<td>' . $formateur->Prenom_Nom_Formateur . '</td>' .

                        '<td>' . $formateur->Specialite_Formateur . '</td>' .

                        '<td>' . $formateur->Tel_Formateur . '</td>';


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
