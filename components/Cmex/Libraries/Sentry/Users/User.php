<?php

namespace Cmex\Libraries\Sentry\Users;

/*
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentry\Groups\GroupInterface;
use Cartalyst\Sentry\Hashing\HasherInterface;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserAlreadyActivatedException;
use Cartalyst\Sentry\Users\UserExistsException;
*/
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser implements UserInterface {
	
	public function isInSameGroupAs(UserInterface $user)
	{
		return count(
			array_intersect(
				$this->getGroups(),
				$user->getGroups()
			)
		) > 0;
	}
	
	
}