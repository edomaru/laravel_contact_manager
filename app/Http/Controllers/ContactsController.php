<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;
use App\Group;

class ContactsController extends Controller
{
    private $rules = [
      'name' => ['required', 'min:5'],
      'email' => ['required', 'email'],
      'company' => ['required'],
      'photo' => ['mimes:jpg,jpeg,png,gif,bmp']
    ];

    private $upload_dir;

    public function __construct()
    {
      $this->upload_dir = base_path() . '/public/uploads';
    }

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

    private function getGroups()
    {
      $groups = [];
      foreach(Group::all() as $group) {
        $groups[$group->id] = $group->name;
      }
      return $groups;
    }

    public function create()
    {
      $groups = $this->getGroups();
      return view("contacts.create", compact('groups'));
    }

    public function edit($id)
    {
      $groups = $this->getGroups();
      $contact = Contact::find($id);
      return view("contacts.edit", compact('groups', 'contact'));
    }

    public function store(Request $request)
    {
      $this->validate($request, $this->rules);

      $data = $this->get_request($request);

      Contact::create($data);

      return redirect("contacts")->with("message", "Contact Saved!");
    }

    private function get_request(Request $request)
    {
      $data = $request->all();
      
      if ($request->hasFile('photo'))
      {
        // get file name      
        $photo = $request->file('photo')->getClientOriginalName();
        // move file to server
        $destination = $this->upload_dir;
        $request->file('photo')->move($destination, $photo);

        $data['photo'] = $photo;
      }

      return $data;
    }

    public function update($id, Request $request)
    {
      $this->validate($request, $this->rules);

      $contact = Contact::find($id);
      $data = $this->get_request($request);
      $contact->update($data);

      return redirect("contacts")->with("message", "Contact Updated!");   
    }

    public function destroy($id)
    {
      $contact = Contact::find($id);

      if (!is_null($contact->photo)) 
      {
        $file_path = $this->upload_dir . '/' . $contact->photo;
        if (file_exists($file_path)) unlink($file_path);
      }

      $contact->delete();

      return redirect("contacts")->with("message", "Contact Deleted!");   
    }
}
