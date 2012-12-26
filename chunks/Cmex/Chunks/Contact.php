<?php

namespace Cmex\Chunks;

class Contact extends \Chunk {
    private $status = null;

    public function config() {
        return "";
    }
    
    public function show($properties = array()) {
        $form = $this->getForm();
        //var_dump($this->getForm());
        //var_dump(json_decode($this->content));
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
        $status = $this->status;
        return $form->make(function($form) use($status) {
            $form->setMethod('POST');
            $form->setClass('form-horizontal');
            if(isset($status['success'])) {
                $form->div(function($div) use ($status) {
                    $div->setClass('alert alert-success');
                    $div->putText($status['success']);
                });
            } else if(isset($status['error'])) {
                $form->div(function($div) use ($status) {
                    $div->setClass('alert alert-error');
                    $div->putText($status['error']);
                });
            }
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
        //print_r($data);
        $content = json_decode($this->content);
        // echo $content;
        if(\Mail::send($content->template, array('mailtext' => strip_tags($data['mailtext'])), function($m) use($content, $data) {
            $m->to($content->to)->subject($data['subject'])->from($data['sender']);
        })) {
            $this->status = array('success' => 'Mail wurde versandt!');
        } else {
            $this->status = array('error' => 'Mail konnte nicht versandt werden!');
        }
    }
}