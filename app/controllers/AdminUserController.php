<?php

class AdminUserController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.userindex', array(
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
		if(self::canCreate()) {
			return View::make('admin.usercreate', array('groups' => Authentication::getGroupProvider()->findAll()));
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
		return Redirect::to('admin/user')->with('error', 'Benutzererstellen noch deaktiviert!');
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
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
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
			if(self::canEdit($id)) {
				return View::make('admin.useredit', array(
					'user' => $user,
					'groups' => Authentication::getGroupProvider()->findAll())
				);
			} else {
				return Redirect::to('admin/user')->with('error', 'Sie haben nicht die nötigen Rechte den Benutzer zu bearbeiten!');
			}
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
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
		try
		{
			$user = Authentication::getUserProvider()->findById($id);
			// update algorythm here
			return Input::json();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return null;
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
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
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
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
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
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return null;
		}
		return (Authentication::getUser()->hasAccess('admin') || Authentication::getUser()->hasAccess('superuser'));
	}
}