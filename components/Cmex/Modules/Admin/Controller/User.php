<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication;
use View;
use Redirect;
use Input;
use Validator;
use Lang;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Users\UserInterface;

class User extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make(
            'Admin::user.index',
            array(
                'users' => Authentication::getUserProvider()->findAll()
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
            return View::make(
                'Admin::user.create',
                array(
                    'groups' => Authentication::getGroupProvider()->findAll()
                )
            );
        } else {
            return Redirect::to('admin/user')
                ->with(
                    'error',
                    Lang::get('Admin::user.create.noright')
                );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!$this->canCreate()) {
            return json_encode(
                array(
                    'success' => 0,
                    'message' => Lang::get('Admin::user.create.noright')
                )
            );
        }
        
        $rules = array(
            'last_name' => 'required|min:3',
            'first_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:password_confirm',
            'password_confirm' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        
        // check input data, abort if validation fails
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
        Authentication::getUserProvider()
			->create(
				Input::only(
					'last_name',
					'first_name',
					'email',
					'password'
				)
			);
		
        return json_encode(
			array(
				'success' => 1,
				'message' => Lang::get('Admin::user.create.success')
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
            return Authentication::getUserProvider()->findById($id);
        } catch (UserNotFoundException $e) {
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
            $user = Authentication::getUserProvider()->findById($id);
            if (Authentication::getUser()->hasGroupAccess('user.edit', $user)) {
                return View::make(
                    'Admin::user.edit',
                    array(
                        'user' => $user,
                        'groups' => Authentication::getGroupProvider()->findAll()
                    )
                );
            } else {
                return Redirect::to('admin/user')
					->with(
						'error',
						Lang::get('Admin::user.edit.noright')
					);
            }
        } catch (UserNotFoundException $e) {
            return Redirect::to('admin/user')
				->with(
					'error',
					Lang::get('Admin::user.notfound')
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
            $user = Authentication::getUserProvider()->findById($id);
            if (Authentication::getUser()->hasGroupAccess('user.edit', $user)) {
                $rules = array(
                    'last_name' => 'required|min:3',
                    'first_name' => 'required|min:3',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'password' => 'min:5|same:password_confirm'
                );
                
                $validator = Validator::make(Input::all(), $rules);
                
                // check input data, abort if validation fails
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
                
                // data validation succeded, now saving data
                $user->last_name = Input::get('last_name');
                $user->first_name = Input::get('first_name');
                
                $user->email = Input::get('email');
                
                if (Input::has('password')) {
                    $user->attemptResetPassword(
						$user->getResetPasswordCode(),
						Input::get('password')
					);
                }
                
                $user->activated = Input::get('activated', 0);
                
                $user->save();
                
				if(Input::has('groups')) {
					foreach(Input::get('groups') as $key => $value) {
						try {
							$group = Authentication::getGroupProvider()->findById($id);
							$user->addGroup($group);
						} catch (GroupNotFoundException $e) {
							// do something
						}
					}
				}
				
                // successfully saved
                return json_encode(
					array(
						'success' => 1,
						'message' => Lang::get('Admin::user.edit.success')
					)
				);
            } else {
                return json_encode(
					array(
						'success' => 0,
						'message' => Lang::get('Admin::user.edit.noright')
					)
				);
            }
        } catch (UserNotFoundException $e) {
            return json_encode(
				array(
					'success' => 0,
					'message' => Lang::get('Admin::user.notfound')
				)
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
			$user = Authentication::getUserProvider()->findById($id);
			if (Authentication::getUser()->hasGroupAccess('user.delete', $user)) {
				$user->delete();
                return json_encode(
					array(
						'success' => 0,
						'message' => Lang::get('Admin::user.delete.success')
					)
				);
			} else {
				return json_encode(
					array(
						'success' => 0,
						'message' => Lang::get('Admin::user.delete.noright')
					)
				);
			}
		} catch (UserNotFoundException $e) {
            return json_encode(
				array(
					'success' => 0,
					'message' => Lang::get('Admin::user.notfound')
				)
			);
        }
    }
    
    private function canCreate()
    {
        return Authentication::getUser()->hasAccess('user.create');
    }
    
    private function canEdit(UserInterface $user)
    {
        return Authentication::getUser()->hasAccess('user.edit');
    }
    
    private function canDelete(UserInterface $user)
    {
        if($user->isSuperUser())
			return false;
		return Authentication::getUser()->hasAccess('user.delete');
    }
}
