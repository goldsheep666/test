<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'org_no' => 'required|exists:orgs,org_no',
            'name' => 'required',
            'birthday' => 'nullable|date_format:Y-m-d',
            'email' => 'required|email',
            'account' => 'required|unique:users',
            'password' => 'required|min:6',
            'attachment' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        $org = Org::where('org_no', $request->input('org_no'))->count();

        if($org == 0){
            // 建立帳號
            $user = new User;
            $user->org_id = $org->id;
            $user->name = $request->input('name');
            $user->birthday = $request->input('birthday');
            $user->email = $request->input('email');
            $user->account = $request->input('account');
            $user->password = Hash::make($request->input('password'));
            $user->status = '待審核';
            $user->save();

            $attachmentPath = $request->file('attachment')->store('attachments');

            $user->applyFiles()->create([
                'file_path' => $attachmentPath,
            ]);        

            return redirect('/register')->with('message', '註冊成功');
        } else {
            return redirect('/register')->with('message', '註冊失敗');
        }     
    }
}
