<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication;
use View;
use Redirect;
use Input;
use Validator;
use Lang;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

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
        if (Authentication::getUser()->hasAccess('group.create')) {
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
        if (!Authentication::getUser()->hasAccess('group.create')) {
            return json_encode(
                array(
                    'success' => 0,
                    'message' => Lang::get('Admin::group.create.noright')
                )
            );
        }
        
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
        try {
            return Authentication::getGroupProvider()->findById($id);
        } catch (GroupNotFoundException $e) {
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
        try {
            $group = Authentication::getGroupProvider()->findById($id);
            if (Authentication::getUser()->hasAccess('group.edit')) {
                return View::make(
                    'Admin::group.edit',
                    array(
                        'group' => $group
                    )
                );
            } else {
                return Redirect::to('admin/group')
					->with(
						'error',
						Lang::get('Admin::group.edit.noright')
					);
            }
        } catch (GroupNotFoundException $e) {
            return Redirect::to('admin/group')
				->with(
					'error',
					Lang::get('Admin::group.notfound')
				);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id)
    {
        try {
            $group = Authentication::getGroupProvider()->findById($id);
            if (Authentication::getUser()->hasAccess('group.edit')) {
				$rules = array(
					'name' => 'required|min:3|unique:groups,name,' . $id
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
				
                $group->name = Input::get('name');
                $group->save();
                
                // successfully saved
                return json_encode(
					array(
						'success' => 1,
						'message' => Lang::get('Admin::group.edit.success')
					)
				);
            } else {
                return Redirect::to('admin/group')
					->with(
						'error',
						Lang::get('Admin::group.edit.noright')
					);
            }
        } catch (UserNotFoundException $e) {
            return Redirect::to('admin/group')
				->with(
					'error',
					Lang::get('Admin::group.notfound')
				);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
			$group = Authentication::getGroupProvider()->findById($id);
			if (Authentication::getUser()->hasAccess('group.delete')) {
				$group->delete();
                return json_encode(
					array(
						'success' => 0,
						'message' => Lang::get('Admin::group.delete.success')
					)
				);
			} else {
				return json_encode(
					array(
						'success' => 0,
						'message' => Lang::get('Admin::group.delete.noright')
					)
				);
			}
		} catch (GroupNotFoundException $e) {
            return json_encode(
				array(
					'success' => 0,
					'message' => Lang::get('Admin::group.notfound')
				)
			);
        }
    }
}
