<?php

namespace Cmex\Libraries\Validators;

use Symfony\Component\Finder\Finder;

class Page extends Base
{
    protected function setupValidator($data, $rules)
    {
        $finder = new Finder();

        \Validator::extend(
            'valid_template',
            function ($attribute, $value, $parameters) use ($finder) {

                $theme = \Config::get('cmex.template');

                $finder->files()->in(app_path() . "/../public/templates/" . $theme)->name('*.twig')->depth('== 0');

                foreach ($finder as $file) {
                    $templatename = str_replace('.twig', '', $file->getFilename());
                    if ($templatename == $value) {
                        return true;
                    }
                }

                return false;
            }
        );

        $messages = array(
            'valid_template'    => 'Das angegebene Template ist ungültig'
        );

        return \Validator::make($data, $rules, $messages);
    }

    protected function setRules()
    {
        return array(
            'title'      => 'required',
            'identifier' => 'required',
            'template'   => 'required|valid_template',
            'status'     => 'required'
        );
    }
}
