<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    public function index()
    {

        if (Auth::User())
        {
            $themes = DB::select('select * from theme');
            $editeurs = DB::select('select Nom_Ed from editeur');
            $categories = DB::select('select Nom_Cat from categorie');
            return view('themes')->with('themes', $themes)->with('editeurs', $editeurs)->with('categories', $categories);
        }
        else
        {
            return redirect()->guest('login');
        }
    }

    public function insert(Request $request)
    {
        $ntheme = $request->input('ntheme');
        $ned = $request->input('ned');
        $cat = $request->input('cat');
        $scat = $request->input('scat');
        $code = $request->input('code');
        $ex = $request->input('ex');
        $off = $request->input('off');
        DB::insert('insert into theme (Nom_Theme, Nom_Ed, Categorie, Sous_Categorie, Code, Examen, Officiel) values(?, ?, ?, ?, ?, ?, ?)',[$ntheme, $ned, $cat, $scat, $code, $ex, $off]);
        return redirect(route('themes.index'));
    }

    public function edit(Request $request) {
        $ntheme = $request->input('editntheme');
        $ned = $request->input('editned');
        $cat = $request->input('editcat');
        $scat = $request->input('editscat');
        $code = $request->input('editcode');
        $ex = $request->input('editex');
        $off = $request->input('editoff');


        DB::update('update theme set Nom_Ed = ?, Categorie = ?, Sous_Categorie = ?, Code = ?, Examen = ?, Officiel = ? where Nom_Theme = ?',[$ned, $cat, $scat, $code, $ex, $off, $ntheme]);

        return redirect(route('themes.index'));

    }

    public function delete(Request $request) {
        //$id = $request->input('theme');
        $ntheme = $request->input('deltheme');
        DB::delete('delete from theme where Nom_Theme = ?',[$ntheme]);
        return redirect(route('themes.index'));
    }



    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $themes = DB::table('theme')->where('Nom_Theme', 'LIKE', '%' . $request->search . "%")->get();

            if ($themes) {

                foreach ($themes as $theme) {

                    $output .= '<tr>' .

                        '<td>' . $theme->Nom_Theme . '</td>' .

                        '<td>' . $theme->Nom_Ed . '</td>' .

                        '<td>' . $theme->Categorie . '</td>' .

                        '<td>' . $theme->Sous_Categorie . '</td>' .

                        '<td>' . $theme->Code . '</td>' .

                        '<td>' . $theme->Examen . '</td>' .

                        '<td>' . $theme->Officiel . '</td>';


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
