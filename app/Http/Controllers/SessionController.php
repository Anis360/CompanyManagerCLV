<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\session;

class SessionController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $sessions = DB::select('select * from sessions');
            $fr = DB::select('select Prenom_Nom_Formateur from formateur');
            $themes = DB::select('select * from theme');
            $salles = DB::select('select Nom_SF from salle_formation');
            return view('sessions')->with('sessions', $sessions)->with('fr', $fr)->with('salles', $salles)->with('themes', $themes);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $theme = $request->input('theme');
        $datedebut = $request->input('datedebut');
        $datefin = $request->input('datefin');
        $frr1 = $request->input('frr1');
        $frr2 = $request->input('frr2');
        $salle = $request->input('salle');
        $etat = $request->input('etat');
        $comm = $request->input('comm');
        DB::insert('insert into sessions (Theme_Session, Date_Debut, Date_Fin, Nom_Formateur1, Nom_Formateur2, Nom_SF, Etat, Commentaire) values(?, ?, ?, ?, ?, ?, ?, ?)',[$theme, $datedebut, $datefin, $frr1, $frr2, $salle, $etat, $comm]);
        return redirect(route('sessions.index'));
    }

    public function edit(Request $request) {
        //$id = $request->input('theme');
        $ntheme = $request->input('edittheme');
        $datedebut = $request->input('editdatedebut');
        $datefin = $request->input('editdatefin');
        $frr1 = $request->input('editfrr1');
        $frr2 = $request->input('editfrr2');
        $salle = $request->input('editsalle');
        $etat = $request->input('editetat');
        $comm = $request->input('editcomm');


        DB::update('update sessions set Date_Debut = ?, Date_Fin = ?, Nom_Formateur1 = ?, Nom_Formateur2 = ?, Nom_SF = ?, Etat = ?, Commentaire = ? where Theme_Session = ?',[$datedebut, $datefin, $frr1, $frr2, $salle, $etat, $comm, $ntheme]);

        return redirect(route('sessions.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $ntheme = $request->input('deltheme');
        DB::delete('delete from sessions where Theme_Session = ?',[$ntheme]);
        return redirect(route('sessions.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

                $output = "";

                $sessions = DB::table('sessions')->where('Theme_Session', 'LIKE', '%' . $request->search . "%")->get();

                if ($sessions) {

                    foreach ($sessions as $session) {

                        $output .= '<tr>' .

                            //'<td>' . $session->ID_Session . '</td>' .

                            '<td>' . $session->Theme_Session . '</td>' .

                            '<td>' . $session->Date_Debut . '</td>' .

                            '<td>' . $session->Date_Fin . '</td>' .

                            '<td>' . $session->Nom_Formateur1 . '</td>' .

                            '<td>' . $session->Nom_Formateur2 . '</td>' .

                            '<td>' . $session->Nom_SF . '</td>' .

                            '<td>' . $session->Etat . '</td>' .

                            '<td>' . $session->Commentaire . '</td>';

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


