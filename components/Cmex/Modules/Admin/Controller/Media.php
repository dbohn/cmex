<?php

namespace Cmex\Modules\Admin\Controller;

use BaseController;
use Authentication;
use View;

class Media extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Authentication::getUser();

        return View::make(
            'Admin::mediamanager',
            array('user' => $user)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
        // Reconvert the path, check validity, get listing
        return \Media::cleanFilePath(urldecode($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
