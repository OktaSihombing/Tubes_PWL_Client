<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Dokter;

use App\Models\Appointment;

class HomeController extends Controller
{
    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0')
            {
                $dokter = dokter::all();
                return view ('user.home', compact('dokter'));
            }
            else
            {
                return view ('admin.home');
            }

        }
        else
        {
            return redirect()->back();
        }
    }

    public function index()
    {
        if(Auth::id())
        {
            return redirect ('home');
        }
        else
        {

        $dokter = dokter::all();
        return view('user.home', compact ('dokter'));
        }
        
    }


    public function appointment (Request $request)
    {
        $data = new appointment;
        $data-> nama=$request->nama;
        $data-> email=$request->email;
        $data-> tanggal=$request->tanggal;
        $data-> telepon=$request->nomer;
        $data-> pesan=$request->pesan;
        $data-> dokter=$request->dokter;
        $data-> status='Dalam Progres';

        if(Auth::id())
        {
        $data-> user_id=Auth::user()->id;
        }

        $data->save();

        return redirect()->back()->with('message','Pembuatan Janji Berhasil. Kami Akan menghubungimu Segera');
    }

    public function myappointment()
    {
        if(Auth::id())
        {
            $userid=Auth::user()->id;
            $appoint=appointment::where('user_id',$userid)->get();
            return view('user.my_appointment',compact('appoint'));
        }
        else
        {
            return redirect()->back();
        }
        
    }

    public function cancel_appointment($id)
    {
        $data=appointment::find($id);
        $data->delete();
        return redirect()->back();
    }
}
