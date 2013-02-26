<?php

class AdminUserController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.userindex', array('users' => Authentication::getUserProvider()->findAll()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.usercreate');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		return Authentication::getUserProvider()->findById($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		if($user = User::find($id)) {
			return View::make('admin.useredit', array('user' => $user));
		} else {
			return Redirect::to('admin/user')->with('error', 'Der Benutzer wurde nicht gefunden!');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		// Update
		return Redirect::to('admin/user/' . $id . '/edit')->with('error', 'Das Updaten wird derzeit noch nicht unterstützt!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		if($user = User::find($id)) {
			return View::make('admin.userdelete', array('user' => $user));
		} else {
			return Redirect::to('admin/user')->with('error', 'Der Benutzer wurde nicht gefunden!');
		}
	}
	
	
	public function missingMethod($parameters)
	{
		print_r($parameters);
	}
}