<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;
use App\Group;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
    	if ( ($group_id = $request->get("group_id") ) ) {
    		$contacts = Contact::where('group_id', $group_id)->orderBy("id", "desc")->paginate(5);
    	}
    	else {
    		$contacts = Contact::orderBy("id", "desc")->paginate(5);
    	}

    	return view("contacts.index", [
    		'contacts' => $contacts
    	]);
    }

    public function create()
    {
      $groups = [];
      foreach(Group::all() as $group) {
        $groups[$group->id] = $group->name;
      }
      return view("contacts.create", compact('groups'));
    }

    public function store(Request $request)
    {
      $rules = [
        'name' => ['required', 'min:5'],
        'email' => ['required', 'email'],
        'company' => ['required']
      ];

      $this->validate($request, $rules);

      Contact::create($request->all());

      return redirect("contacts")->with("message", "Contact Saved!");
    }
}
