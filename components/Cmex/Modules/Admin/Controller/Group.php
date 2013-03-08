<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication, View, Redirect, Input, Validator, Lang, Cartalyst\Sentry\Groups;

class Group extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('Admin::group.index', array(
			'groups' => Authentication::getGroupProvider()->findAll()
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
			return View::make('Admin::group.create');
		} else {
			return Redirect::to('admin/group')->with('error', 'Sie haben nicht die nötigen Rechte Benutzer zu erstellen!');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return json_encode(array('success' => 0, 'message' => 'Deaktiviert...'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		return json_encode(array('success' => 0, 'message' => 'Deaktiviert...'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		return json_encode(array('success' => 0, 'message' => 'Deaktiviert...'));
	}
	
	
	private function canCreate() {
		return Authentication::getUser()->hasAccess('group.create');
	}
	
	private function canEdit($id) {
		return Authentication::getUser()->hasAccess('group.edit');
	}
	
	private function canDelete($id) {
		return Authentication::getUser()->hasAccess('group.delete');
	}
}