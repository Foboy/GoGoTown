<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:52:16
 * 商家账号以及收银员账号表
 */
use Gregwar\Captcha\CaptchaBuilder;
class UsersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query ( "SET NAMES utf8" ); // 设置数据库编码
	}
	
	// 根据ID删除users
	public function delete($id) {
		$sql = " delete from crm_users where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id 
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询users
	public function searchByPages($name, $shop_id, $type, $state, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex * $pagesize;
		
		$sql = " select id,name,shop_id,type,account,password,last_login,state,faileds,last_failed,token,create_time from crm_users where  ( name = :name or :name=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and  ( account = :account or :account='' )  and  ( password = :password or :password='' )  and  ( last_login = :last_login or :last_login=0 )  and  ( state = :state or :state=0 )  and  ( faileds = :faileds or :faileds=0 )  and  ( last_failed = :last_failed or :last_failed=0 )  and  ( token = :token or :token='' )  and  ( create_time = :create_time or :create_time=0 )  limit $lastpagenum,$pagesize";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':name' => $name,
				':shop_id' => $shop_id,
				':type' => $type,
				':state' => $state 
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_users where  ( name = :name or :name=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and   ( state = :state or :state=0 )   " );
		$query->execute ( array (
				':name' => $name,
				':shop_id' => $shop_id,
				':type' => $type,
				':state' => $state 
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
	// 不分页查询全部users
	public function search($name, $shop_id, $type) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Users where  ( name = :name or :name='' )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )   " );
		$query->execute ( array (
				':name' => $name,
				':shop_id' => $shop_id,
				':type' => $type
		) );
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
	// 根据ID获取users
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Users WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
	// 修改usersState
	public function updateUserState($state, $id) {
		$sql = " update crm_users set state = :state where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id,
				':state' => $state
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 修改usersName
	public function updateShopName($name, $id) {
		$sql = " update crm_users set name = :name where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id,
				':name' => $name 
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	public function setNewPassword($user_id, $user_password_hash) {
		// write users new password hash into database, reset user_password_reset_hash
		$query = $this->db->prepare ( "UPDATE crm_users
                                        SET password = :user_password_hash
                                      WHERE id = :id" );
		
		$query->execute ( array (
				':user_password_hash' => $user_password_hash,
				':id' => $user_id 
		) );
		
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	public function login() {
		
		// we do negative-first checks here
		if (! isset ( $_POST ['user_name'] ) or empty ( $_POST ['user_name'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_FIELD_EMPTY;
			return false;
		}
		if (! isset ( $_POST ['user_password'] ) or empty ( $_POST ['user_password'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_FIELD_EMPTY;
			return false;
		}
		
		// get user's data
		// (we check if the password fits the password_hash via password_verify() some lines below)
		$sth = $this->db->prepare ( "SELECT
									`crm_users`.`ID`,
									`crm_users`.`Shop_ID`,
									`crm_users`.`Type`,
									`crm_users`.`Account`,
									`crm_users`.`Password`,
									`crm_users`.`Last_Login`,
									`crm_users`.`State`,
									`crm_users`.`Faileds`,
									`crm_users`.`Last_Failed`
									FROM `gogotowncrm`.`crm_users`
                                   WHERE Account = :user_name" );
		// DEFAULT is the marker for "normal" accounts (that have a password etc.)
		// There are other types of accounts that don't have passwords etc. (FACEBOOK)
		$sth->execute ( array (
				':user_name' => $_POST ['user_name'] 
		) );
		$count = $sth->rowCount ();
		
		// if there's NOT one result
		if ($count != 1) {
			// was FEEDBACK_USER_DOES_NOT_EXIST before, but has changed to FEEDBACK_LOGIN_FAILED
			// to prevent potential attackers showing if the user exists
			$_SESSION ["feedback_negative"] [] = FEEDBACK_LOGIN_FAILED;
			return false;
		}
		
		// fetch one row (we only have one result)
		$result = $sth->fetch ();
		
		// block login attempt if somebody has already failed 3 times and the last login attempt is less than 30sec ago
		if (($result->Faileds >= 3) and ($result->Last_Failed > (time () - 30))) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_WRONG_3_TIMES;
			return false;
		}
		
		// check if hash of provided password matches the hash in the database
		if (password_verify ( $_POST ['user_password'], $result->Password )) {
			
			if ($result->State != UserState::Active) {
				$_SESSION ["feedback_negative"] [] = FEEDBACK_ACCOUNT_NOT_ACTIVATED_YET;
				return false;
			}
			
			// login process, write the user data into session
			Session::init ();
			Session::set ( 'user_logged_in', true );
			Session::set ( 'user_id', $result->ID );
			Session::set ( 'user_name', $result->Account );
			Session::set ( 'user_shop', $result->Shop_ID );
			Session::set ( 'user_type', $result->Type );
			// put native avatar path into session
			// Session::set('user_avatar_file', $this->getUserAvatarFilePath());
			// put Gravatar URL into session
			// $this->setGravatarImageUrl($result->user_email, AVATAR_SIZE);
			
			// reset the failed login counter for that user (if necessary)
			if ($result->Last_Failed > 0) {
				$sql = "UPDATE crm_users SET Faileds = 0, Last_Failed = NULL
						WHERE ID = :user_id AND Faileds != 0";
				$sth = $this->db->prepare ( $sql );
				$sth->execute ( array (
						':user_id' => $result->ID 
				) );
			}
			
			// generate integer-timestamp for saving of last-login date
			$user_last_login_timestamp = time ();
			// write timestamp of this login into database (we only write "real" logins via login form into the
			// database, not the session-login on every page request
			$sql = "UPDATE crm_users SET Last_Login = :user_last_login_timestamp WHERE ID = :user_id";
			$sth = $this->db->prepare ( $sql );
			$sth->execute ( array (
					':user_id' => $result->ID,
					':user_last_login_timestamp' => $user_last_login_timestamp 
			) );
			
			// if user has checked the "remember me" checkbox, then write cookie
			if (isset ( $_POST ['user_rememberme'] )) {
				
				// generate 64 char random string
				$random_token_string = hash ( 'sha256', mt_rand () );
				
				// write that token into database
				$sql = "UPDATE crm_users SET Token = :user_rememberme_token WHERE ID = :user_id";
				$sth = $this->db->prepare ( $sql );
				$sth->execute ( array (
						':user_rememberme_token' => $random_token_string,
						':user_id' => $result->ID 
				) );
				
				// generate cookie string that consists of user id, random string and combined hash of both
				$cookie_string_first_part = $result->ID . ':' . $random_token_string;
				$cookie_string_hash = hash ( 'sha256', $cookie_string_first_part );
				$cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;
				
				// set cookie
				setcookie ( 'rememberme', $cookie_string, time () + COOKIE_RUNTIME ); // , '/', COOKIE_DOMAIN
			}
			
			// return true to make clear the login was successful
			return true;
		} else {
			// increment the failed login counter for that user
			$sql = "UPDATE crm_users
									SET Faileds = Faileds+1, Last_Failed = :user_last_failed_login
									WHERE Account = :user_name";
			$sth = $this->db->prepare ( $sql );
			$sth->execute ( array (
					':user_name' => $_POST ['user_name'],
					':user_last_failed_login' => time () 
			) );
			// feedback message
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_WRONG;
			return false;
		}
		
		// default return
		return false;
	}
	
	/**
	 * performs the login via cookie (for DEFAULT user account, FACEBOOK-accounts are handled differently)
	 *
	 * @return bool success state
	 */
	public function loginWithCookie() {
		$cookie = isset ( $_COOKIE ['rememberme'] ) ? $_COOKIE ['rememberme'] : '';
		
		// do we have a cookie var ?
		if (! $cookie) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_COOKIE_INVALID;
			return false;
		}
		
		// check cookie's contents, check if cookie contents belong together
		list ( $user_id, $token, $hash ) = explode ( ':', $cookie );
		if ($hash !== hash ( 'sha256', $user_id . ':' . $token )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_COOKIE_INVALID;
			return false;
		}
		
		// do not log in when token is empty
		if (empty ( $token )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_COOKIE_INVALID;
			return false;
		}
		
		// get real token from database (and all other data)
		$query = $this->db->prepare ( "SELECT
	`crm_users`.`ID`,
	`crm_users`.`Shop_ID`,
	`crm_users`.`Type`,
	`crm_users`.`Account`,
	`crm_users`.`Password`,
	`crm_users`.`Last_Login`,
	`crm_users`.`State`,
		`crm_users`.`Faileds`,
									`crm_users`.`Last_Failed`
										FROM `gogotowncrm`.`crm_users`
										WHERE ID = :user_id
										AND Token = :user_rememberme_token
										AND Token IS NOT NULL" );
		$query->execute ( array (
				':user_id' => $user_id,
				':user_rememberme_token' => $token 
		) );
		$count = $query->rowCount ();
		if ($count == 1) {
			// fetch one row (we only have one result)
			$result = $query->fetch ();
			// TODO: this block is same/similar to the one from login(), maybe we should put this in a method
			// write data into session
			Session::init ();
			Session::set ( 'user_logged_in', true );
			Session::set ( 'user_id', $result->ID );
			Session::set ( 'user_name', $result->Account );
			Session::set ( 'user_shop', $result->Shop_ID );
			Session::set ( 'user_type', $result->Type );
			// put native avatar path into session
			// Session::set('user_avatar_file', $this->getUserAvatarFilePath());
			// put Gravatar URL into session
			// $this->setGravatarImageUrl($result->user_email, AVATAR_SIZE);
			
			// generate integer-timestamp for saving of last-login date
			$user_last_login_timestamp = time ();
			// write timestamp of this login into database (we only write "real" logins via login form into the
			// database, not the session-login on every page request
			$sql = "UPDATE crm_users SET Last_Login = :user_last_login_timestamp WHERE ID = :user_id";
			$sth = $this->db->prepare ( $sql );
			$sth->execute ( array (
					':user_id' => $result->ID,
					':user_last_login_timestamp' => $user_last_login_timestamp 
			) );
			
			// NOTE: we don't set another rememberme-cookie here as the current cookie should always
			// be invalid after a certain amount of time, so the user has to login with username/password
			// again from time to time. This is good and safe ! ;)
			$_SESSION ["feedback_positive"] [] = FEEDBACK_COOKIE_LOGIN_SUCCESSFUL;
			return true;
		} else {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_COOKIE_INVALID;
			return false;
		}
	}
	
	/**
	 * Log out process, deletes cookie, deletes session
	 */
	public function logout() {
		// set the remember-me-cookie to ten years ago (3600sec * 365 days * 10).
		// that's obviously the best practice to kill a cookie via php
		// @see http://stackoverflow.com/a/686166/1114320
		setcookie ( 'rememberme', false, time () - (3600 * 3650) ); // , '/', COOKIE_DOMAIN
		                                                            
		// delete the session
		Session::destroy ();
	}
	
	/**
	 * Deletes the (invalid) remember-cookie to prevent infinitive login loops
	 */
	public function deleteCookie() {
		// set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
		// that's obviously the best practice to kill a cookie via php
		// @see http://stackoverflow.com/a/686166/1114320
		setcookie ( 'rememberme', false, time () - (3600 * 3650) ); // , '/', COOKIE_DOMAIN
	}
	
	/**
	 * Returns the current state of the user's login
	 *
	 * @return bool user's login status
	 */
	public function isUserLoggedIn() {
		return Session::get ( 'user_logged_in' );
	}
	
	/**
	 * handles the entire registration process for DEFAULT users (not for people who register with
	 * 3rd party services, like facebook) and creates a new user in the database if everything is fine
	 *
	 * @return boolean Gives back the success status of the registration
	 */
	public function registerNewUser() {
		
		
		// perform all necessary form checks
		if (! $this->checkCaptcha ()) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_CAPTCHA_WRONG;
		}elseif (empty ( $_POST ['user_type'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_FIELD_EMPTY;
		}elseif (empty ( $_POST ['user_acount'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_FIELD_EMPTY;
		} elseif (empty ( $_POST ['user_name'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_FIELD_EMPTY;
		} elseif (empty ( $_POST ['user_password_new'] ) or empty ( $_POST ['user_password_repeat'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_FIELD_EMPTY;
		} elseif (empty ( $_SESSION["user_shop"] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_SHOPID_FIELD_EMPTY;
		} elseif ($_POST ['user_password_new'] !== $_POST ['user_password_repeat']) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_REPEAT_WRONG;
		} elseif (strlen ( $_POST ['user_password_new'] ) < 6) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_PASSWORD_TOO_SHORT;
		} elseif (strlen ( $_POST ['user_name'] ) > 64 or strlen ( $_POST ['user_name'] ) < 2) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
		} elseif (! preg_match ( '/^[a-z\d]{2,64}$/i', $_POST ['user_name'] )) {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
		} elseif (! empty ( $_POST ['user_name'] ) and strlen ( $_POST ['user_name'] ) <= 64 and strlen ( $_POST ['user_name'] ) >= 2  and preg_match ( '/^[a-z\d]{2,64}$/i', $_POST ['user_name'] ) and ! empty ( $_POST ['user_password_new'] ) and ! empty ( $_POST ['user_password_repeat'] ) and ($_POST ['user_password_new'] === $_POST ['user_password_repeat'])) {
			
			// clean the input
			$user_name = strip_tags ( $_POST ['user_name'] );
			$user_acount = strip_tags ( $_POST ['user_acount'] );
			$user_type = intval ( $_POST ['user_type'] );
			$shop_id = intval ( $_SESSION["user_shop"] );
			
			// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character
			// hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4,
			// by the password hashing compatibility library. the third parameter looks a little bit shitty, but that's
			// how those PHP 5.5 functions want the parameter: as an array with, currently only used with 'cost' => XX
			$hash_cost_factor = (defined ( 'HASH_COST_FACTOR' ) ? HASH_COST_FACTOR : null);
			$user_password_hash = password_hash ( $_POST ['user_password_new'], PASSWORD_DEFAULT, array (
					'cost' => $hash_cost_factor 
			) );
			
			// check if username already exists
			$query = $this->db->prepare ( "SELECT * FROM crm_users WHERE Account = :user_name" );
			$query->execute ( array (
					':user_name' => $user_name 
			) );
			$count = $query->rowCount ();
			if ($count == 1) {
				$_SESSION ["feedback_negative"] [] = FEEDBACK_USERNAME_ALREADY_TAKEN;
				return false;
			}
			
			// generate random hash for email verification (40 char string)
			$user_activation_hash = sha1 ( uniqid ( mt_rand (), true ) );
			// generate integer-timestamp for saving of account-creating date
			$user_creation_timestamp = time ();
			
			// write new users data into database
			$sql = "INSERT INTO crm_users (Name,Account, Shop_ID, Password, Type, State, Create_Time)
		VALUES (:user_name,:user_acount :user_shop_id, :user_password_hash, :user_type, 1, :user_create_time)";
			$query = $this->db->prepare ( $sql );
			$query->execute ( array (
					':user_name' => $user_name,
					':user_acount' => $user_acount,
					':user_shop_id' => $shop_id,
					':user_password_hash' => $user_password_hash,
					':user_type' => $user_type,
					':user_create_time' => $user_creation_timestamp 
			) );
			$count = $query->rowCount ();
			if ($count != 1) {
				$_SESSION ["feedback_negative"] [] = FEEDBACK_ACCOUNT_CREATION_FAILED;
				return false;
			}
			
			// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
			$query = $this->db->prepare ( "SELECT ID FROM crm_users WHERE Account = :user_name" );
			$query->execute ( array (
					':user_name' => $user_name 
			) );
			if ($query->rowCount () != 1) {
				$_SESSION ["feedback_negative"] [] = FEEDBACK_UNKNOWN_ERROR;
				return false;
			}
			$result_user_row = $query->fetch ();
			$user_id = $result_user_row->ID;
			
			$_SESSION ["feedback_positive"] [] = FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED;
			return true;
		} else {
			$_SESSION ["feedback_negative"] [] = FEEDBACK_UNKNOWN_ERROR;
		}
		// default return, returns only true of really successful (see above)
		return false;
	}
	
	
	/**
	 * Generates the captcha, "returns" a real image,
	 * this is why there is header('Content-type: image/jpeg')
	 * Note: This is a very special method, as this is echoes out binary data.
	 * Eventually this is something to refactor
	 */
	public function generateCaptcha() {
		// create a captcha with the CaptchaBuilder lib
		$builder = new CaptchaBuilder ();
		$builder->build ();
		
		// write the captcha character into session
		$_SESSION ['captcha'] = $builder->getPhrase ();
		
		// render an image showing the characters (=the captcha)
		header ( 'Content-type: image/jpeg' );
		$builder->output ();
	}
	
	/**
	 * Checks if the entered captcha is the same like the one from the rendered image which has been saved in session
	 * 
	 * @return bool success of captcha check
	 */
	private function checkCaptcha() {
		return true;
		if (isset ( $_POST ["captcha"] ) and ($_POST ["captcha"] == $_SESSION ['captcha'])) {
			return true;
		}
		// default return
		return false;
	}
	
	/**
	 * Generate unique user_name from facebook-user's username appended with a number
	 * 
	 * @param string $existing_name
	 *        	$facebook_user_data stuff from the facebook class
	 * @return string unique user_name not in database yet
	 */
	public function generateUniqueUserNameFromExistingUserName($existing_name) {
		// strip any dots, trailing numbers and white spaces
		$existing_name = str_replace ( ".", "", $existing_name );
		$existing_name = preg_replace ( '/\s*\d+$/', '', $existing_name );
		
		// loop until we have a new username, adding an increasing number to the given string every time
		$n = 0;
		do {
			$n = $n + 1;
			$new_username = $existing_name . $n;
			$query = $this->db->prepare ( "SELECT user_id FROM users WHERE user_name = :name_with_number" );
			$query->execute ( array (
					':name_with_number' => $new_username 
			) );
		} while ( $query->rowCount () == 1 );
		
		return $new_username;
	}
}

?>