<?php

namespace Cmex\Libraries\Chunks\Editors;

interface EditorInterface
{
    /**
     * This method is called, if a chunk can be edited and the frontend editor
     * is initialized and requests the data for editing.
     * @return string The JSON-encoded data object
     */
    public function getDataForEdit();

    /**
     * After editing, this method is called to prepare and save all
     * incoming data.
     * @throws \Cmex\Libraries\Chunks\Editors\EditorSaveException
     * @return bool true on success
     */
    public function setData();

    /**
     * To quickly retrieve the needed frontend editing module
     * this static method is used to retrieve the name of the JS-file.
     * @return string filename of the Editor class
     */
    public static function frontendEditor();
}
