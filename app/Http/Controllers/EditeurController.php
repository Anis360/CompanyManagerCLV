<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditeurController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $editeurs = DB::select('select * from editeur');

            return view('editeurs')->with('editeurs', $editeurs);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $nom = $request->input('nom');
        $email = $request->input('email');
        $tel = $request->input('tel');

        DB::insert('insert into editeur (Nom_Ed, Email_Ed, Tel_Ed) values(?, ?, ?)',[$nom, $email, $tel]);
        return redirect(route('editeurs.index'));
    }

    public function edit(Request $request) {
        $nom = $request->input('editnom');
        $email = $request->input('editemail');
        $tel = $request->input('edittel');


        DB::update('update editeur set Email_Ed = ?, Tel_Ed = ? where Nom_Ed = ?',[$email, $tel, $nom]);

        return redirect(route('editeurs.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nom= $request->input('deledit');
        DB::delete('delete from editeur where Nom_Ed = ?',[$nom]);
        return redirect(route('editeurs.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $editeurs = DB::table('editeur')->where('Nom_Ed', 'LIKE', '%' . $request->search . "%")->get();

            if ($editeurs) {

                foreach ($editeurs as $editeur) {

                    $output .= '<tr>' .

                        '<td>' . $editeur->Nom_Ed . '</td>' .

                        '<td>' . $editeur->Email_Ed. '</td>' .

                        '<td>' . $editeur->Tel_Ed . '</td>';


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
