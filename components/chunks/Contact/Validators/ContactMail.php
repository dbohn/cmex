<?php

namespace Cmex\Chunks\Contact\Validators;

use \Cmex\Libraries\Validators\Base as BaseValidator;
use Guzzle\Http\Client;

class ContactMail extends BaseValidator
{
    protected function setupValidator($data, $rules)
    {
        \Validator::extend(
            'spamcheck',
            function ($attribute, $value, $parameters) {

                $apikey = \Config::get('cmex.spam_apikey');

                if (!\Config::get('cmex.spam_enable_check')) {
                    return true;
                }

                $reqData = array(
                    'blog' => \URL::to('/'),
                    'user_ip' => \Request::getClientIp(),
                    'user_agent' => \Request::server('HTTP_USER_AGENT'),
                    'referrer'  =>  \Request::server('HTTP_REFERER'),
                    'comment_type'  => 'contact'
                );

                $client = new Client(
                    'http://{key}.{endpoint}/{version}',
                    array(
                        'key'       => $apikey,
                        'endpoint'  => 'api.antispam.typepad.com',
                        'version'   => '1.1'
                    )
                );

                $req = $client->post('comment-check', null, $reqData);

                $response = $req->send();

                return ($response->getBody() != 'true') ? true : false;
            }
        );
    
        $messages = array(
            'spamcheck' => 'Die E-Mail Adresse ist als Spam-E-Mail bekannt!'
        );

        return \Validator::make($data, $rules, $messages);
    }
    protected function setRules()
    {
        return array(
            'name'      => 'required',
            'email'     => 'required|email|spamcheck',
            'subject'   => 'required',
            'message'   => 'required'
        );
    }
}
