<?php

use Cmex\Media\FileNotFoundException;

class MediaController extends BaseController
{
    /**
     * This method looksup a file in the virtual file tree and
     * redirects the request towards the file
     * The option flag is there right now for things like automatic
     * image resizing (i.e. thumbnail creation) or similar
     */
    public function resolveFile($option, $path)
    {
        try {
            $file = Media::lookupFile($path);

            return Redirect::to($file->getExternPath());
        } catch (FileNotFoundException $e) {
            return Response::make($e->getMessage(), 404);
        } catch (InvalidArgumentException $e) {
            return Response::make($e->getMessage(), 404);
        }


    }
}
