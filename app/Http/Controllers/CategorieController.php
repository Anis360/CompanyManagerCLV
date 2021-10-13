<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $categories = DB::select('select * from categorie');

            return view('categories')->with('categories', $categories);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $nomcat = $request->input('nom');
        $commcat = $request->input('comm');
        DB::insert('insert into categorie (Nom_Cat, Comm_Cat) values(?, ?)',[$nomcat, $commcat]);
        return redirect(route('categories.index'));
    }

    public function edit(Request $request) {
        //$id = $request->input('theme');
        $nomcat = $request->input('editnom');
        $commcat = $request->input('editcomm');


        DB::update('update categorie set Comm_Cat = ? where Nom_Cat = ?',[$commcat, $nomcat]);

        return redirect(route('categories.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $nomcat = $request->input('delcat');
        DB::delete('delete from categorie where Nom_Cat = ?',[$nomcat]);
        return redirect(route('categories.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $sessions = DB::table('categorie')->where('Nom_Cat', 'LIKE', '%' . $request->search . "%")->get();

            if ($sessions) {

                foreach ($sessions as $session) {

                    $output .= '<tr>' .

                        '<td>' . $session->Nom_Cat . '</td>' .

                        '<td>' . $session->Comm_Cat . '</td>';

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
