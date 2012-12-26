<?php

namespace Cmex\Chunks;

class ContactChunk extends \Chunk {
    public function config() {
        return "";
    }
    
    public function show($properties = array()) {
        $form = $this->getForm();
        //var_dump($this->getForm());
        $form->macro('group_text',function($name, $label=null) use($form)
        {
            return $form->template('div', function($innerform) use($name, $label, $form)
            {
                $innerform->label($label)->class('control-label');

                $innerform->div(function($innerform) use($name)
                {
                    $innerform->text($name)->class('span6');
                    $innerform->setClass('controls');
                });

                $innerform->setClass('control-group');
            });
        });

        $form->macro('group_textarea',function($name, $label=null) use($form)
        {
            return $form->template('div', function($innerform) use($name, $label)
            {
                $innerform->label($label)->class('control-label');

                $innerform->div(function($innerform) use($name)
                {
                    $innerform->textarea()->name($name)->class('span6');
                    $innerform->setClass('controls');
                });

                $innerform->setClass('control-group');
            });
        });

        return $form->make(function($form) {
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
        echo "Es wurde was gepostet!";
    }
}