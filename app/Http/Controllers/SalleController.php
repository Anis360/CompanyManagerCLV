<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalleController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $salles = DB::select('select * from salle_formation');

            return view('salles')->with('salles', $salles);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $nom = $request->input('nom');
        $cap = $request->input('cap');

        DB::insert('insert into salle_formation (Nom_SF, Capacite_SF) values(?, ?)',[$nom, $cap]);
        return redirect(route('salles.index'));
    }

    public function edit(Request $request) {
        $nom = $request->input('editnom');
        $cap = $request->input('editcap');


        DB::update('update salle_formation set Capacite_SF = ? where Nom_SF = ?',[$cap, $nom]);

        return redirect(route('salles.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nom= $request->input('delsf');
        DB::delete('delete from salle_formation where Nom_SF = ?',[$nom]);
        return redirect(route('salles.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $salles = DB::table('salle_formation')->where('Nom_SF', 'LIKE', '%' . $request->search . "%")->get();

            if ($salles) {

                foreach ($salles as $salle) {

                    $output .= '<tr>' .

                        '<td>' . $salle->Nom_SF . '</td>' .

                        '<td>' . $salle->Capacite_SF. '</td>';


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
