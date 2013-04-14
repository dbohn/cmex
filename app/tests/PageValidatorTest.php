<?php

use \Cmex\Libraries\Validators\Page as PageValidator;

class PageValidatorTest extends TestCase
{
    public function testPassesReturnsResultOfSuccessCallbackOnSuccess()
    {
        $input = array('title' => 'Page title', 'identifier' => 'page_title', 'template' => 'main', 'status' => 'live');

        $trueify = function () {
            return true;
        };

        $validator = new PageValidator($input);

        $this->assertTrue($validator->passes($trueify));
    }

    public function testPassesReturnsFalseOnFailure()
    {
        $input = array('title' => 'Page title', 'identifier' => 'page_title', 'template' => 'main');

        $trueify = function () {
            return true;
        };

        $validator = new PageValidator($input);

        $this->assertFalse($validator->passes($trueify));
    }

    public function testPassesExecutesFailCallbackOnFail()
    {
        $input = array('title' => 'Page title', 'identifier' => 'page_title', 'template' => 'main');

        $trueify = function () {
            return true;
        };

        $falseify = function () {
            return "Validation Error";
        };

        $validator = new PageValidator($input);

        $this->assertEquals($falseify(), $validator->passes($trueify, $falseify));
    }

    public function testErrorsOnFailure()
    {
        // \Illuminate\Support\MessageBag
        $input = array('title' => 'Page title', 'identifier' => 'page_title', 'template' => 'main');

        $trueify = function () {
            return true;
        };

        $validator = new PageValidator($input);

        $this->assertFalse($validator->errors());

        $validator->passes($trueify);

        $this->assertInstanceOf('\Illuminate\Support\MessageBag', $validator->errors());
    }

    public function testCustomErrorForTemplate()
    {
        $input = array('title' => 'Page title', 'identifier' => 'page_title', 'template' => 'gibt_s_nicht');

        $trueify = function () {
            return true;
        };

        $validator = new PageValidator($input);

        $validator->passes($trueify);

        $errors = $validator->errors();

        $this->assertTrue($errors->has('template'));

        $this->assertEquals('Das angegebene Template ist ungültig', $errors->first('template'));
    }
}
