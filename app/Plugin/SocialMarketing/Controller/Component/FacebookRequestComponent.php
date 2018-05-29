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
class FacebookRequestComponent extends Component
{
    function get_app_access($appId, $appSecret)
    {
        $token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $appId . "&client_secret=" . $appSecret . "&grant_type=client_credentials";
        $token = file_get_contents($token_url);
        return $token;
    }
    function getUserFromSignedRequest()
    {
        if (!empty($_REQUEST['signed_request'])) {
            $signed_request = $_REQUEST["signed_request"];
            list($encoded_sig, $payload) = explode('.', $signed_request, 2);
            $data = json_decode(base64_decode(strtr($payload, '-_', '+/')) , true);
            if (!empty($data['user_id'])) return $data['user_id'];
        }
        return null;
    }
    function __construct()
    {
        $APPLICATION_ID = Configure::read('facebook.app_id');
        $APPLICATION_SECRET = Configure::read('facebook.secrect_key');
        /*
        * Get the current user, you may use the PHP-SDK
        * or your own server-side flow implementation
        */
        $user = $this->getUserFromSignedRequest();
        $app_token = $this->get_app_access($APPLICATION_ID, $APPLICATION_SECRET);
        // We may have more than one request, so it's better to loop
        $requests = explode(',', $_REQUEST['request_ids']);
        foreach($requests as $request_id) {
            // If we have an authenticated user, this would return a recipient specific request: <request_id>_<recipient_id>
            if ($user) {
                $request_id = $request_id . "_{$user}";
            }
            // Get the request details using Graph API
            $request_content = json_decode(file_get_contents("https://graph.facebook.com/$request_id?$app_token") , TRUE);
            // An example of how to get info from the previous call
            $request_message = $request_content['message'];
            $from_id = $request_content['from']['id'];
            // An easier way to extract info from the data field
            // extract(json_decode($request_content['data'], TRUE));
            // Now that we got the $item_id and the $item_type, process them
            // Or if the recevier is not yet a member, encourage him to claims his item (install your application)!
            if (!empty($request_content['data'])) {
                $referrer['refer_id'] = $user;
                $referrer['type'] = 'User';
                $referrer['slug'] = '';
                //setcookie('CakeCookie[referrer]', json_encode($referrer), time() + 60 * 60 * 24, '/');
                App::uses('Core', 'ComponentCollection');
                $collection = new ComponentCollection();
                App::import('Component', 'Cookie');
                $this->Cookie = new CookieComponent($collection);
                $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
            }
            if ($user) {
                /*
                * When all is done, delete the requests because Facebook will not do it for you!
                * But first make sure we have a user (OR access_token - not used here)
                * because you can't delete a "general" request, you can only delete a recipient specific request
                * <request_id>_<recipient_id>
                */
                $deleted = file_get_contents("https://graph.facebook.com/$request_id?$app_token&method=delete"); // Should return true on success

            }
        }
    }
}
