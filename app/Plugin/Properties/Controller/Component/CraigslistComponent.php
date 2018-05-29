<?php
/**
 * Burrow
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Burrow
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class CraigslistComponent extends Component
{
	public function post($data)
	{
		set_time_limit(0);
		$market = $data['Property']['craigslist_market_id'];
		$category = $data['Property']['craigslist_category_id'];
		$content = $this->_curlGetURL('https://post.craigslist.org/');
		preg_match('/<form.*action="(.*)" method="POST">/', $content, $action_arr);
		if (!empty($action_arr[1])) {
			$form_action = $action_arr[1];
			preg_match('/<select name="([a-zA-Z0-9:_\-\.]+)"/', $content, $market_arr);
			preg_match('/<input type="hidden" name="([a-zA-Z0-9:_\-\.]+)" value="([a-zA-Z0-9:_\-\.]+)">/', $content, $hidden_arr);
			if (!empty($market_arr[1])) {
				$post_variable = $market_arr[1] . '=' . $market . '&' . $hidden_arr[1] . '=' . $hidden_arr[2] . '&go=Continue';
				$content = $this->_curlGetURL($form_action, $post_variable, true);
				preg_match('/<input type="hidden" name="([a-zA-Z0-9:_\-\.]+)" value="([a-zA-Z0-9:_\-\.]+)">/', $content, $hidden_arr);
				$post_variable = 'id=ho&' . $hidden_arr[1] . '=' . $hidden_arr[2];
				$content = $this->_curlGetURL($form_action, $post_variable, true);
				preg_match('/<input type="hidden" name="([a-zA-Z0-9:_\-\.]+)" value="([a-zA-Z0-9:_\-\.]+)">/', $content, $hidden_arr);
				$post_variable = 'id=' . $category . '&' . $hidden_arr[1] . '=' . $hidden_arr[2];
				$content = $this->_curlGetURL($form_action, $post_variable, true);
				preg_match('/<textarea.*name="([a-zA-Z0-9:_\-\.]+)" id="PostingBody"><\/textarea>/', $content, $description_arr);
				$property_variable['description'] = $description_arr[1];
				preg_match('/<input type="radio" name="([a-zA-Z0-9:_\-\.]+)"/', $content, $input_radio_arr);
				$property_variable['hide_email'] = $input_radio_arr[1];
				preg_match('/<input type="hidden" name="([a-zA-Z0-9:_\-\.]+)" value="([a-zA-Z0-9:_\-\.]+)">/', $content, $hidden_arr);
				$property_variable['hidden_name'] = $hidden_arr[1];
				$property_variable['hidden_value'] = $hidden_arr[2];
				preg_match_all('/<input type="text".*name="([a-zA-Z0-9:_\-\.]+)".*>/', $content, $input_text_arr);
				$property_variable['price'] = $input_text_arr[1][0];
				$property_variable['location'] = $input_text_arr[1][2];
				preg_match('/<input class="req".*type="text"\s*name="([a-zA-Z0-9:_\-\.]+)"/', $content, $input_title_arr);
				$property_variable['title'] = $input_title_arr[1];
				$form_content = '<form action="' . $form_action . '" class="js-post-craigslist" method="post" target="_blank">
	<input id="region" name="region" type="hidden" value="' . $data['Property']['state'] . '" />
	<input id="city" name="city" type="hidden" value="' . $data['Property']['city'] . '" />
	<input id="FromEMail" name="FromEMail" type="hidden" value="' . $data['Property']['email'] . '" />
	<input id="ConfirmEMail" name="ConfirmEMail" type="hidden" value="' . $data['Property']['email'] . '" />
	<input id="' . $property_variable['title'] . '" name="' . $property_variable['title'] . '" type="hidden" value="' . $data['Property']['title'] . '" />
	<input id="' . $property_variable['price'] . '" name="' . $property_variable['price'] . '" type="hidden" value="' . $data['Property']['price_per_night'] . '" />
	<input id="' . $property_variable['location'] . '" name="' . $property_variable['location'] . '" type="hidden" value="' . $data['Property']['city'] . '" />
	<input id="' . $property_variable['hide_email'] . '" name="' . $property_variable['hide_email'] . '" type="hidden" value="A" />
	<input id="' . $property_variable['hidden_name'] . '" name="' . $property_variable['hidden_name'] . '" type="hidden" value="' . $property_variable['hidden_value'] . '" />
	<textarea id="' . $property_variable['description'] . '" name="' . $property_variable['description'] . '">' . $data['Property']['description'] . '</textarea>
</form>';
				return $form_content;
			}
		}
	}
	function _curlGetURL($url, $data_arr = '' , $is_post = false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_arr);
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, APP . 'tmp' . DS . 'curl_cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, APP . 'tmp' . DS . 'curl_cookie.txt');
		$content = curl_exec($ch);
		if (!curl_errno($ch)) {
			curl_close($ch);
		} else {
			$content = false;
		}
		return $content;
	}
}
?>