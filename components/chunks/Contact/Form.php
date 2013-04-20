<?php

namespace Cmex\Chunks\Contact;

use Guzzle\Http\Client;
use Cmex\Libraries\Chunks\Chunk;

class Form extends Chunk
{
    private $status = null;
    
    public function show()
    {
        return \View::make(
            'Chunks/Contact::contactForm',
            array(
                'status' => $this->status,
                'me'     => $this->identifier
            )
        );
    }

    public function handleInput($data)
    {
        // Send mail
        $content = json_decode($this->content);

        $validator = new Validators\ContactMail($data);
        
        $this->status = $validator->passes(
            function ($validation) use ($content, $data) {
                $mailfunction = function ($m) use ($content, $data) {
                    $m->to($content->to);
                    $m->subject($data['subject']);
                    $m->from(
                        $data['email'],
                        $data['name']
                    );
                };

                if (\Mail::send(
                    $content->template,
                    array('mailmessage' => strip_tags($data['message'])),
                    $mailfunction
                )
                ) {
                    return array('success' => 'Mail wurde versandt!');
                } else {
                    return array('error' => 'Mail konnte nicht versandt werden!');
                }
            },
            function ($validation) {
                $messages = $validation->messages();

                $error = "<p>Folgende Fehler sind aufgetreten: </p><ul>";
                $error .= implode('', $messages->all('<li>:message</li>')) . "</ul>";

                return array('error' => $error);
            }
        );
    }

    public function annotate()
    {
        return array();
    }
}
