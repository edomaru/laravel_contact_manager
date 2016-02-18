<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
    	if ( ($group_id = $request->get("group_id") ) ) {
    		$contacts = Contact::where('group_id', $group_id)->paginate(5);
    	}
    	else {
    		$contacts = Contact::paginate(5);
    	}
    	
    	return view("contacts.index", [
    		'contacts' => $contacts
    	]);
    }
}
