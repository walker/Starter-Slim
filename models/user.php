<?php

class User extends Model {
	public static $_table = 'users';
	
	public function delete() {
		if($this->id) {
			$this->deleted = 1;
			return $this->save();
		} else {
			return false;
		}
	}
	
	public function save() {
		// if email && ID
		if(!empty($this->email) && !empty($this->id)) {
			$user_check = \Model::factory('User')->where('email', $this->email)->find_one();
			// check that email doesn't already exist
			if(empty($user_check)) {
				// nothing
			} else {
				// or that, if it does, it's already w/ that ID.
				if($this->id!=$user_check->id) {
					$this->error = 'A different user is already using that email address.';
					return false;
					exit();
				}
			}
		// else if email && no ID, check that doesn't already exist
		} else if(!empty($this->email) && empty($this->id)) {
			$user_check = \Model::factory('User')->where('email', $this->email)->find_one();
			if(!empty($user_check)) {
				$this->error = 'A user with that email address already exists.';
				return false;
				exit();
			}
		}
		if(empty($this->id))
			$this->id = (string) \Lootils\Uuid\Uuid::createV4();
		
		if($this->is_dirty('password'))
			$this->password = sha1($this->password.SALT);
		parent::save();
		return true;
	}
}