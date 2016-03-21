<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Group;

class GroupsController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	]);
    	
    	$group = Group::create($request->all());
    	return response()->json(['success' => true, 'group' => $group]);
    }
}
