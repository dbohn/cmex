<?php

namespace Cmex\Chunks\Contact;

use Guzzle\Http\Client;
use Cmex\Libraries\Chunks\Chunk;

class Form extends Chunk {
    private $status = null;
    
    public function show() {
        return \View::make('Contact.views.contactForm', array(
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
            $messages = $validation->messages();
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

    public function annotate()
    {
        return array();
    }

    private function validateUser()
    {
        // TODO: make a library out of that!
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