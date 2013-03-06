<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication, View, Redirect, Input, Validator, Lang;

class User extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('Admin::userindex', array(
			'users' => Authentication::getUserProvider()->findAll()
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if($this->canCreate()) {
			return View::make('Admin::usercreate', array('groups' => Authentication::getGroupProvider()->findAll()));
		} else {
			return Redirect::to('admin/user')->with('error', 'Sie haben nicht die nötigen Rechte Benutzer zu erstellen!');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(!$this->canCreate())
			return json_encode(array('success' => 0, 'message' => Lang::get('user.noright.create')));
		
		$rules = array(
			'lastName' => 'required|min:3',
			'firstName' => 'required|min:3',
			'email' => 'required|email|unique:users,email',
			'password' => 'min:5|same:password_confirm'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		// check input data, abort if validation fails
		if($validator->fails()) {
			$message = implode("<br />\n", $validator->messages()->all());
			return json_encode(array('success' => 0, 'message' => $message));
		}
		Authentication::getUserProvider()->create(Input::only('lastName', 'firstName', 'email', 'password'));
		return json_encode(array('success' => 1, 'message' => 'Der Benutzer wurde hinzugefügt!'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		try
		{
			return Authentication::getUserProvider()->findById($id);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return null;
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		try
		{
			$user = Authentication::getUserProvider()->findById($id);
			if($this->canEdit($id)) {
				return View::make('Admin::useredit', array(
					'user' => $user,
					'groups' => Authentication::getGroupProvider()->findAll())
				);
			} else {
				return Redirect::to('admin/user')->with('error', Lang::get('user.noright.edit'));
			}
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('admin/user')->with('error', Lang::get('user.notfound'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		try
		{
			$user = Authentication::getUserProvider()->findById($id);
			if($this->canEdit($id)) {
				$rules = array(
					'lastName' => 'required|min:3',
					'firstName' => 'required|min:3',
					'email' => 'required|email|unique:users,email,' . $id,
					'password' => 'min:5|same:password_confirm'
				);
				
				$validator = Validator::make(Input::all(), $rules);
				
				// check input data, abort if validation fails
				if($validator->fails()) {
					$message = implode("<br />\n", $validator->messages()->all());
					return json_encode(array('success' => 0, 'message' => $message));
				}
				
				// data validation succeded, now saving data
				$user->last_name = Input::get('lastName');
				$user->first_name = Input::get('firstName');
				
				$user->email = Input::get('email');
				
				if(Input::has('password')) {
					$user->attemptResetPassword($user->getResetPasswordCode(), Input::get('password'));
				}
				
				$user->activated = Input::get('activated', 0);
				
				$user->save();
				
				// successfully saved
				return json_encode(array('success' => 1, 'message' => Lang::get('user.edited')));
				
			} else {
				return json_encode(array('success' => 0, 'message' => Lang::get('user.noright.edit')));
			}
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return json_encode(array('success' => 0, 'message' => Lang::get('user.notfound')));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			$user = Authentication::getUserProvider()->findById($id);
			return $user->delete();
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return null;
		}
	}
	
	private function canCreate() {
		return (Authentication::getUser()->hasAccess('admin') || Authentication::getUser()->hasAccess('superuser'));
	}
	
	private function canEdit($id) {
		try
		{
			$user = Authentication::getUserProvider()->findById($id);
			
			if(Authentication::getUser()->hasAccess('superuser'))
				return true;
			if(Authentication::getUser()->hasAccess('admin') && !$user->hasAccess('superuser'))
				return true;
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return false;
		}
		return false;
	}
	
	private function canDelete($id) {
		try
		{
			return Authentication::getUserProvider()->findById($id);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return null;
		}
		return (Authentication::getUser()->hasAccess('admin') || Authentication::getUser()->hasAccess('superuser'));
	}
}