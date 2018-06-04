<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;

class UserController extends Controller
{
    public function index($perPage)
    {
        $data = User::select('id', 'nama', 'username', 'email', 'status')->where('role', '<>', 'manager')->orderBy('nama', 'asc')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'nama'      => 'required|string',
            'username'  => 'required|string|unique:users,username',
            'email'     => 'required|string|email|unique:users,email'
        ]);

        User::create([
            'nama'      => ucwords($request->nama),
            'username'  => strtolower($request->username),
            'email'     => strtolower($request->email),
            'role'      => 'apoteker',
            'status'    => 'aktif',
            'password'  => bcrypt($this->randomPassword(7))
        ]);

        $data = array(
            'nama'      => ucwords($request->nama),
            'username'  => strtolower($request->username),
            'email'     => strtolower($request->email),
            'password'  => $this->randomPassword(7),
            'time'      => $this->getTime()
        );

        Mail::send('templates.user-created', $data, function($message) use ($data) {
            $message->to($data['email'], $data['nama'])->subject('Klinik Pratama Rolas Medika');
            $message->from('roismaruf0@gmail.com', 'Manager');
        });

        return $this->index($perPage);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required|string',
            'username'  => 'required|string|unique:users,username,'.$request->id.'',
            'email'     => 'required|string|email|unique:users,email,'.$request->id.'',
        ]);
        
        User::where('id', $id)->update([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email
        ]);

        $data = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function setStatus(Request $request, $id)
    {
        $status = $request->status == true ? 0 : 1;
        User::where('id', $id)->update([
            'status'    => $status
        ]);

        $data = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function checkForm(Request $request, $form)
    {
        if($form == 'nama'){
            $request->validate([
                'nama'      => 'required|string',
            ]);
        }elseif($form == 'username'){
            $request->validate([
                'username'  => 'required|string|unique:users,username,'.$request->id.'',
            ]);
        }elseif($form == 'email'){
            $request->validate([
                'email'     => 'required|string|email|unique:users,email,'.$request->id.'',
            ]);
        }
    }

    public function getTime()
    {
        date_default_timezone_set("Asia/Jakarta");
        $hour = date("G", time());

        if ($hour >= 0 && $hour <= 11) {
            return "Selamat Pagi";
        } elseif ($hour > 11 && $hour <= 14) {
            return "Selamat Siang";
        } elseif ($hour > 14 && $hour <= 17) {
            return "Selamat Sore";
        } elseif ($hour > 17 && $hour <= 23) {
            return "Selamat Malam";
        }
    }

    public function randomPassword($length)
    {
        $char = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789@";
        $result = "";

        for($i = 0; $i < $length; $i++){
            $pos = rand(0, strlen($char) - 1);
            $result .= $char{$pos};
        }

        return $result;
    }
}
