<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    //
    public function viewTest()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $data = Personal::all()
        ->orderBy("created_at", 'asc');
        return view('form.form',compact('data'));
    }
    // save
    public function viewTestSave(Request $request)
    {
        $request->validate([
            'username'=>'required|max:100',
            'email'   =>'required|email|unique:personals',
            'phone'   =>'required|min:11|numeric',
        ]);
    
        try{

            $username = $request->username;
            $email    = $request->email;
            $phone    = $request->phone;
            
            $Personal = new Personal();
            $Personal->username = $username;
            $Personal->email    = $email;
            $Personal->phone    = $phone;
            $Personal->save();
            return redirect()->back()->with('insert','Data has been insert successfully!.');

        }catch(\Exception $e){

            return redirect()->back()->with('error','Data has been insert fail!.');
        }
    }
    // update
    public function update(Request $request)
    {
        $update =[

            'id'      =>$request->id,
            'username'=>$request->name,
            'email'   =>$request->email,
            'phone'   =>$request->phone,
        ];
        Personal::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function delete($id)
    {
        $delete = Personal::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }
    
}
