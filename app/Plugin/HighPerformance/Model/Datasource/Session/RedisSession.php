<?php
/**
 * Redis Session Store for CakePHP
 *
 * @version	  0.1.1
 * @author	  Kjell Bublitz <m3nt0r.de@gmail.com>
 * @license	  MIT License
 * @copyright 2011-2013, Kjell Bublitz
 * @package	  redis_session
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require_once 'iRedis.php';
App::uses('CakeSessionHandlerInterface', 'Model/Datasource/Session');
App::uses('ClassRegistry', 'Utility');
 
if (!class_exists('RedisSession')){
/**
 * Redis Session Store Class
 */
class RedisSession implements CakeSessionHandlerInterface {
  
	static $store; 
	static $timeout;
	static $prefix;
	
	public static function init() {
		$name = Configure::read('Session.cookie');
		$level = Configure::read('Security.level');
		$timeout = Configure::read('Session.timeout');

		self::$timeout = $timeout * Security::inactiveMins();
		self::$prefix = $name;

		if ($level == 'high') {
			$cookieLifeTime = 0;
		} else {
			$cookieLifeTime = Configure::read('Session.timeout') * (Security::inactiveMins() * 60);
		}

		if (empty($_SESSION) && function_exists('ini_set')) {
			ini_set('session.use_trans_sid', 0);
			ini_set('url_rewriter.tags', '');
			ini_set('session.save_handler', 'user');
			ini_set('session.serialize_handler', 'php');
			ini_set('session.use_cookies', 1);
			ini_set('session.name', $name);
			ini_set('session.cookie_lifetime', $cookieLifeTime);
			ini_set('session.cookie_path', '/');
			ini_set('session.auto_start', 0);
		}

		session_set_save_handler( 
			array('RedisSession', 'open'), 
			array('RedisSession', 'close'), 
			array('RedisSession', 'read'), 
			array('RedisSession', 'write'), 
			array('RedisSession', 'destroy'), 
			array('RedisSession', 'gc') 
		);

	}
  
	/**
	 * OPEN
	 * - Connect to Redis
	 * - Calculate and set timeout for SETEX
	 * - Set session_name as key prefix
	 */
	public function open() {
		$hostname = Configure::read('RedisSession.hostname');
		$port = Configure::read('RedisSession.port');
		
		if ($hostname !== null && $port !== null) {
			$redis = new iRedisForRedisSession(compact('hostname', 'port'));
		} else {
			$redis = new iRedisForRedisSession();
		}
		
		self::$store = $redis;
	}
  
	/**
	 * CLOSE
	 * - Disconnect from Redis
	 */
	public function close() {
		self::$store->disconnect();
		return true;
	}
  
	/**
	 * READ
	 * - Make key from session_id and prefix
	 * - Return whatever is stored in key
	 */	 
	public function read($id) {
		$key = self::$prefix. '_' . $id;
		return self::$store->get($key);
	}
  
	/**
	 * WRITE
	 * - Make key from session_id and prefix
	 * - SETEX data with timeout calculated in open()
	 */
	public function write($id, $data) {
		$key = self::$prefix. '_' . $id;
		self::$store->setex($key, self::$timeout, $data);
		return true;
	}
  
	/**
	 * DESTROY
	 * - Make key from session_id and prefix
	 * - DEL the key from store
	 */
	public function destroy($id) {
		$key = self::$prefix. '_' . $id;
		self::$store->del($key);
		return true;
	}
  
	/**
	 * GARBAGE COLLECTION
	 * not needed as SETEX automatically removes itself after timeout
	 * ie. works like a cookie
	 */
	public function gc($expires = null) {
		return true;
	}
	
  }// enddef RedisSession
}// endif class-exists RedisSession

// Setup RedisSession
RedisSession::init();
?>