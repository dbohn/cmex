<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication;
use View;
use Redirect;
use Input;
use Validator;
use Lang;
use Cartalyst\Sentry\Groups;

class Group extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make(
            'Admin::group.index',
            array(
                'groups' => Authentication::getGroupProvider()->findAll()
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ($this->canCreate()) {
            return View::make('Admin::group.create');
        } else {
            return Redirect::to('admin/group')
                ->with('error', 'Sie haben nicht die nötigen Rechte Gruppen zu erstellen!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
		$rules = array(
			'name' => 'required|min:3|unique:groups,name'
        );
        
        $validator = Validator::make(Input::all(), $rules);
		
        if ($validator->fails()) {
            $message = implode(
				"<br />\n",
				$validator->messages()->all()
			);
			
            return json_encode(
				array(
					'success' => 0,
					'message' => $message
				)
			);
        }
		
		$group = Authentication::getGroupProvider()->create(array(
			'name' => Input::get('name')
		));
		
        return json_encode(
			array(
				'success' => 1,
				'message' => 'Die Gruppe wurde erstellt.'
			)
		);
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
        return json_encode(
			array(
				'success' => 0,
				'message' => 'Deaktiviert...'
			)
		);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        return json_encode(
			array(
				'success' => 0,
				'message' => 'Deaktiviert...'
			)
		);
    }
    
    
    private function canCreate()
    {
        return Authentication::getUser()->hasAccess('group.create');
    }
    
    private function canEdit($id)
    {
        return Authentication::getUser()->hasAccess('group.edit');
    }
    
    private function canDelete($id)
    {
        return Authentication::getUser()->hasAccess('group.delete');
    }
}
