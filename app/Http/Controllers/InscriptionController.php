<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $inscriptions = DB::select('select * from inscription');
            $stagiaires = DB::select('select Prenom_Nom_Stgre from stagiaire');
            $themes= DB::select('select Nom_Theme from theme');

            return view('inscriptions')->with('inscriptions', $inscriptions)->with('stagiaires', $stagiaires)->with('themes', $themes);
        }
        else
        {
            return redirect()->guest('login');
        }
    }
    public function insert(Request $request)
    {
        $code = $request->input('code');
        $nomstgre = $request->input('nomstgre');
        $thmss = $request->input('thmss');
        $stt = $request->input('stt');
        DB::insert('insert into inscription (Code_Inscription, Nom_Stgre, Theme_Session, Statut) values(?, ?, ?, ?)',[$code, $nomstgre, $thmss, $stt]);
        return redirect(route('inscriptions.index'));
    }

    public function edit(Request $request) {
        //$id = $request->input('theme');
        $editcode = $request->input('editcode');
        $editnomstgre = $request->input('editnomstgre');
        $editthmss = $request->input('editthmss');
        $editstt = $request->input('editstt');

        DB::update('update inscription set Nom_Stgre = ?, Theme_Session = ?, Statut = ? where Code_Inscription = ?',[$editnomstgre, $editthmss, $editstt, $editcode]);

        return redirect(route('inscriptions.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nins = $request->input('delins');
        DB::delete('delete from inscription where Code_Inscription = ?',[$nins]);
        return redirect(route('inscriptions.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $inscriptions = DB::table('inscription')->where('Code_Inscription', 'LIKE', '%' . $request->search . "%")->orWhere('Nom_Stgre', 'LIKE', '%' . $request->search . "%")->get();

            if ($inscriptions) {

                foreach ($inscriptions as $inscription) {

                    $output .= '<tr>' .

                        '<td>' . $inscription->Code_Inscription . '</td>' .

                        '<td>' . $inscription->Nom_Stgre . '</td>' .

                        '<td>' . $inscription->Theme_Session . '</td>' .

                        '<td>' . $inscription->Statut . '</td>';


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
