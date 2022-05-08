<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\dokter;

use App\Models\Appointment;

class AdminController extends Controller
{
   public function addview ()
   {
       return view('admin.add_doctor');

   }

   public function upload(Request $request)
   {
       $dokter=new dokter;
       $image=$request->file;

    $imagename=time().'.'.$image->getClientoriginalextension();
    
    $request->file->move('doctorimage',$imagename);
       $dokter->image=$imagename;

       $dokter->nama=$request->nama;
       $dokter->nomer=$request->nomer;
       $dokter->ruangan=$request->ruangan;
       $dokter->spesialis=$request->spesialis;


       $dokter->save();

       return redirect()->back()->with('message','Dokter Berhasil Ditambahkan');

}

    public function showappointment()
    {
        $data=appointment::all();
        return view('admin.showappointment',compact('data'));
    }

    public function approved($id)
    {
        $data=appointment::find($id);

        $data->status='approved';

        $data->save();

        return redirect()->back();
    }

    public function canceled($id)
    {
        $data=appointment::find($id);

        $data->status='canceled';

        $data->save();

        return redirect()->back();
    }

    public function showdoctor()
    {

        $data = dokter::all();


        return view('admin.showdoctor', compact('data'));
    }

    public function deletedoctor($id)
    {
        $data=dokter::find($id);

        $data->delete();

        return redirect()->back();
    }

    public function updatedoctor($id)
    {
        $data = dokter::find($id);
        return view('admin.update_doctor',compact('data'));
    }

    public function editdoctor(Request $request, $id)
    {
        $dokter = dokter::find($id);

        $dokter->nama=$request->nama;

        $dokter->nomer=$request->nomer;

        $dokter->spesialis=$request->spesialis;

        $dokter->ruangan=$request->ruangan;

        $image=$request->file;

        if($image)
        {
            $imagename=time().'.'.$image->getOriginalClientExtension();

            $request->file->move('doctorimage',$imagename);
            
            $dokter->image=$imagename;

        }

        $dokter->save();

        return redirect()->back()->with('message',' Indentitas Dokter Berhasil Diedit');
    }
}
