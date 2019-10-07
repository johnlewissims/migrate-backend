<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AssociateUsers extends Controller
{
	public function associate(Request $request, User $user) {
		foreach($request['sponsors'] as $sponsorId) {
		    $user->sponsor()->attach($sponsorId);
		}
	}
	
	public function sponsors(User $user) {
		$sponsors = $user->sponsor()->where('role', 'S')->get()->all();
		return $sponsors;
	}	
}
