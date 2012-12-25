<?php

namespace Cmex\Chunks;

class ContactChunk extends \Chunk {
    public function config() {

    }
    
    public function show($properties = array()) {
        \Form::macro('group_text',function($name, $label=null)
        {
            return \Form::template('div', function($form) use($name, $label)
            {
                $form->label($label)->class('control-label');

                $form->div(function($form) use($name)
                {
                    $form->text($name)->class('span6');
                    $form->setClass('controls');
                });

                $form->setClass('control-group');
            });
        });

        \Form::macro('group_textarea',function($name, $label=null)
        {
            return \Form::template('div', function($form) use($name, $label)
            {
                $form->label($label)->class('control-label');

                $form->div(function($form) use($name)
                {
                    $form->textarea()->name($name)->class('span6');
                    $form->setClass('controls');
                });

                $form->setClass('control-group');
            });
        });

        return \Form::make(function($form) {
            $form->setMethod('POST');
            $form->setClass('form-horizontal');
            $form->group_text('sender', 'Absender');
            $form->group_text('subject', 'Betreff');
            $form->group_textarea('mailtext', 'Text');
            $form->div(function($button) {
                $button->submit('Absenden')->class('btn btn-primary');
                $button->setClass('controls');
            });
        });
    }

    public function handleInput($data) {
        // Send mail
    }
}