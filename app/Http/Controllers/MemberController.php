<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Helpers\HelperClass;
use PHPUnit\TextUI\Help;

class MemberController extends Controller
{
    /**
     * Display a listing of the users
     *
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request, Member $member)
    {

        if ($request->search == 1) {

            if (!empty($request->name)) {

                $name = $request->name;
                $members = $member->where('name', $name)->get();
                
                $data = [
                    'members' => $members,
                    'search' => '1',
                    'name' => $name,
                
                    ];
            }

        } else{
            

       $data = [
        'members' => $member->paginate(15),
        'search' => '',
        'name' => '',
    
        ];

        }
       return view('members.index', $data);
    }

    public function add()
    {
        return view('members.add', []);
    }


    public function save(Request $request)
    {
        //dd($request->all());

        $member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;

        //check if email or phone already exists
        if ($request->email) {
            if (HelperClass::checkUserByEmail($request->email)) {
                return redirect()->route('member')->with('error', 'Email already exists');
            }
        }

        if ($request->phone) {
            if (HelperClass::checkUserByPhone($request->phone)) {
                return redirect()->route('member')->with('error', 'Phone number already exists');
            }
        }

        if ($request->hasFile('photo')) {
            $fileName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $fileName);
            $member->photo = 'images/' . $fileName;
        }


        $member->date_of_birth = $request->date_of_birth;
        $member->date_became_member = $request->date_became_member;
        $member->save();

        return redirect()->route('member')->with('success', 'Member added successfully');;
    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;

        if ($request->hasFile('photo')) {
            $fileName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $fileName);
            $member->photo = 'images/' . $fileName;
        }


        $member->date_of_birth = $request->date_of_birth;
        $member->date_became_member = $request->date_became_member;
        $member->save();

        return redirect()->route('member')->with('success', 'Member updated successfully');;
    }

    public function edit($id)
    {
        $member = Member::find($id);

        return view('members.edit', ['member' => $member]);
    }
    public function delete($id)
    {
        $member = Member::find($id);
        $member->delete();

        return redirect()->route('member')->with('success', 'Member deleted successfully');;
    }
}
