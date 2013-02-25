<?php

namespace Cmex\Media;

interface DriverInterface {
    
    /**
     * Adds a file to the media repository at path $path.
     * @param $path Path where to store the file in virtual file tree
     * @param $file The file handle
     * @return id of the added file under which the file is referenced
     * @throws FileNotFoundException if the path could not be found
     * @throws InvalidArgumentException if the given file is not a file handle
     * @throws WriteErrorException if the file could not be added to the storage
     */
    public function addFile($path, $file);

    /**
     * Deletes the file, which is located at the given path.
     * @param $path Path of the file in the virtual directory tree
     * @return true on success, otherwise Exception
     * @throws FileNotFoundException if the file was not found
     * @throws NotAFileException if the file is not a file but a directory
     * @throws PermissionDeniedException if there is currently no permission to do the action (unauthenticated or User not allowed...)
     */
    public function removeFile($path);

    /**
     * Creates a directory in the virtual file tree.
     * @param $path The path where the directory is created, i.e. it has to
     * contain the name of the created Directory!
     * @return true on success, otherwise Exception
     * @throws FileNotFoundException if there's a part of the path missing
     * @throws PermissionDeniedException if there is currently no permission to do the action
     */
    public function createDirectory($path);

    /**
     * Removes a directory and, according to the flag, all it's contents.
     * @param $path the path to the directory
     * @param $withContents true if all contents of a directory shall be deleted
     * @return true on success, ohterwise Exception
     * @throws FileNotFoundException if the directory wasn't found
     * @throws PermissionDeniedException if the is currently no permission to do the action
     * @throws InvalidArgumentException if the directory is not empty but the $withContents-flag is false
     */
    public function removeDirectory($path, $withContents);

    /**
     * Checks if a directory located at the given path is empty.
     * @param $path path to the directory, which is to check
     * @return true if it is empty, else false
     * @throws FileNotFoundException if the directory wasn't found
     */
    public function isEmptyDirectory($path);

    /**
     * Checks if a file exists.
     * @param $path path to the file, which is to check
     * @return true if the file exists, else false
     * @throws FileNotFoundException if the file wasn't found
     */
    public function fileExists($path);

    /**
     * Returns the file which is stored by the given id.
     * Might also be removed...
     * @param $id the file id
     * @return \Cmex\Media\File
     * @throws FileNotFoundException if the file wasn't found
     */
    public function getFileForId($id);

    /**
     * Returns the file which is stored at the given path.
     * @param $path the path
     * @return \Cmex\Media\File
     * @throws FileNotFoundException if the file wasn't found
     */
    public function getFileForPath($path);

    /**
     * Builds the directory tree for the interface with $root as root node.
     * This tree is obviously cached and will only be refreshed after ops.
     * So don't worry if this operation might take a bit longer!
     * @param $root the root directory for the tree
     * @return FileTree
     * @throws FileNotFoundException if the root was not found
     */
    public function getDirectoryTree($root);

    /**
     * The virtual first directory is used to determine the used
     * driver. Note here, to which virtual directory this driver
     * belongs. If there are collisions, the rules is: first come
     * first serve.
     * @return string name of the first directory
     */
    public function respondsToKey();
}