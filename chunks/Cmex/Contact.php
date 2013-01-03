<?php

namespace Chunks\Cmex;
use Guzzle\Http\Client;

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
                    $innerform->textarea()->name($name)->rows(10)->class('span6');
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
            $form->group_text('sendername', 'Ihr Name');
            $form->group_text('sender', 'Ihre E-Mail-Adresse');
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
        
        $content = json_decode($this->content);
        $rules = array(
            'sendername'      => 'required',
            'sender'    => 'required|email',
            'subject'   => 'required',
            'mailtext'  => 'required'
            );

        $validation = \Validator::make($data, $rules);

        if($validation->fails()) {
            //echo "FAIL";
            var_dump($validation->getMessages()->first('sender'));
            // TODO: fix validation for fields
            //var_dump($validation->getMessages());
            //$this->status = array('error' => $validation->errors);
        } else {
            // echo $content;

            $apikey = 'eec041dd12d3b0ed4d12064e2825d9d0';

            $reqData = array(
                'blog' => \URL::to('/'),
                'user_ip' => \Request::getClientIp(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'referrer'  =>  $_SERVER['HTTP_REFERER'],
                'comment_type'  => 'contact'
            );

            //print_r($referrer);

            $client = new Client('http://{key}.{endpoint}/{version}', array(
                'key'       => $apikey,
                'endpoint'  => 'api.antispam.typepad.com',
                'version'   => '1.1')
            );

            $req = $client->post('comment-check', null, $reqData);

            $response = $req->send();

            if($response->getBody() != 'true') {
                if(\Mail::send($content->template, array('mailtext' => strip_tags($data['mailtext'])), function($m) use($content, $data) {
                    $m->to($content->to)->subject($data['subject'])->from($data['sender'], $data['sendername']);
                })) {
                    $this->status = array('success' => 'Mail wurde versandt!');
                } else {
                    $this->status = array('error' => 'Mail konnte nicht versandt werden!');
                }
            } else {
                $this->status = array('error' => 'Die Anfrage wurde nicht verschickt, da sie von Akismet bzw. TypePad als Spam erkannt wurde!');
            }
        }
        
    }
}