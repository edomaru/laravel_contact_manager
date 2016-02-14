<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;

class ContactsController extends Controller
{
    public function index()
    {
    	$contacts = Contact::all();
    	return view("contacts.index", [
    		'contacts' => $contacts
    	]);
    }
}
