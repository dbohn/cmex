<?php

namespace Cmex\Libraries\Validators;

use Closure;

/**
 * This class is a Base-Validator
 * By inheriting from this class you can create
 * easy-to-use, controller-shrinking validators
 * for your data structures
 */
abstract class Base
{

    protected $data;

    protected $rules;

    protected $errors;

    /**
     * Constructor for validation class
     * @param array $data The input data to validate
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->rules = $this->setRules();
    }

    /**
     * Runs the validation with the defined rules.
     * If validation succeeds, the success callback will be called,
     * otherwise, if declared, the fail callback
     * @param  Closure  $callback_success Callback, to call, if validation passes
     * @param  Closure  $callback_fail    Callback to call, if validation fails, or null
     * @return mixed                      Closure result or false, if validation fails and $callback_fail is not specified
     */
    public function passes(Closure $callback_success, Closure $callback_fail = null)
    {
        $validator = $this->setupValidator($this->data, $this->rules);

        if ($validator->passes()) {
            return $callback_success($validator);
        }

        $this->errors = $validator->errors();

        return ($callback_fail) ? $callback_fail($validator) : false;
    }

    /**
     * Runs the validation with the defined rules.
     * If validation fails, the fail callback will be called,
     * otherwise, if passed, the success callback
     * @param  Closure  $callback_fail    Callback to call, if validation fails
     * @param  Closure  $callback_success Callback, to call, if validation passes or null
     * @return mixed                      Closure result or false, if validation passes and $callback_success is not specified
     */
    public function fails(Closure $callback_fail, Closure $callback_success = null)
    {
        $validator = $this->setupValidator($this->data, $this->rules);

        if ($validator->fails()) {
            return $callback_fail($validator);
        }

        return ($callback_success) ? $callback_success($validator) : false;
    }

    public function errors()
    {
        return ($this->errors) ? $this->errors : false;
    }

    protected function setupValidator($data, $rules)
    {
        return \Validator::make($data, $rules);
    }

    abstract protected function setRules();
}
