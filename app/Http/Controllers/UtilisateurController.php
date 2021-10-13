<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UtilisateurController extends Controller
{
    public function index()
    {
        if (Auth::User())
        {
            $utilisateurs = DB::select('select name, email, role, created_at from users');

            return view('utilisateurs')->with('utilisateurs', $utilisateurs);
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
        $pwd = $request->input('pwd');
        $role = $request->input('role');
        $current_date = date('Y-m-d H:i:s');
        DB::insert('insert into users (name, email, password, role, created_at) values(?, ?, ?, ?, ?)',[$nom, $email, bcrypt($pwd), $role, $current_date]);
        return redirect(route('utilisateurs.index'));
    }
    public function edit(Request $request) {
        $nom = $request->input('editnom');
        $email = $request->input('editemail');
        $role = $request->input('editrole');

        DB::update('update users set email = ?, role = ? where name = ?',[$email, $role, $nom]);

        return redirect(route('utilisateurs.index'));

    }
    public function delete(Request $request) {
        $nuser = $request->input('deluser');
        DB::delete('delete from users where name = ?',[$nuser]);
        return redirect(route('utilisateurs.index'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {

            $output = "";

            $utilisateurs = DB::table('users')->where('name', 'LIKE', '%' . $request->search . "%")->orWhere('email', 'LIKE', '%' . $request->search . "%")->get();

            if ($utilisateurs) {

                foreach ($utilisateurs as $utilisateur) {

                    $output .= '<tr>' .

                        '<td>' . $utilisateur->name . '</td>' .

                        '<td>' . $utilisateur->email . '</td>' .

                        '<td>' . $utilisateur->role . '</td>' .

                        '<td>' . $utilisateur->created_at . '</td>';

                        if(Auth::user()->role == 'Super administrateur')
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
