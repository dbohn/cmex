<?php

namespace Chunks\Cmex;
use Guzzle\Http\Client;

class Contact extends \Chunk {
    private $status = null;

    public function config() {
        return "";
    }
    
    public function show($properties = array()) {
        return \View::make('Cmex.Contact.contactForm', array(
            'openForm' => $this->openForm("post", "contactForm", null, "", false, array('class' => 'form-horizontal'), true),
            'status' => $this->status));
    }

    public function handleInput($data) {
        // Send mail
        
        $content = json_decode($this->content);
        $rules = array(
            'sendername'    => 'required',
            'sender'        => 'required|email',
            'subject'       => 'required',
            'mailtext'      => 'required'
        );

        $validation = \Validator::make($data, $rules);

        if($validation->fails()) {
            //var_dump($validation->getMessages()->first('sender'));
            $messages = $validation->messages();
            //$this->status = array('error' => $validation->errors);
            $error = "<p>Folgende Fehler sind aufgetreten: </p><ul>";
            foreach($messages->all() as $msg)
            {
                $error .= "<li>".$msg."</li>";
            }

            $error .= "</ul>";

            $this->status = array('error' => $error);
        } else {

            if($this->validateUser()) {
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

    private function validateUser()
    {
        // TODO: store this key outside of this method!
        $apikey = \Config::get('cmex.spam_apikey');

        if (!\Config::get('cmex.spam_enable_check'))
        {
            return true;
        }

        $reqData = array(
            'blog' => \URL::to('/'),
            'user_ip' => \Request::getClientIp(),
            'user_agent' => \Request::server('HTTP_USER_AGENT'),
            'referrer'  =>  \Request::server('HTTP_REFERER'),
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

        return ($response->getBody() != 'true') ? true : false;
    }
}