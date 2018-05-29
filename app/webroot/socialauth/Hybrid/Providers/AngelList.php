<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/
/**
 * Hybrid_Providers_AngelList provider adapter based on OAuth2 protocol
 *
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_AngelList.html
 */
class Hybrid_Providers_AngelList extends Hybrid_Provider_Model_OAuth2
{
    // default permissions
    public $scope = "";
    /**
     * IDp wrappers initializer
     */
    function initialize()
    {
        parent::initialize();
        // Provider api end-points
        $this->api->authorize_url = "https://angel.co/api/oauth/authorize";
        $this->api->token_url = "https://angel.co/api/oauth/token";
    }
    /**
     * begin login step
     */
    function loginBegin()
    {
        $parameters = array(
            "scope" => $this->scope,
            "access_type" => "offline"
        );
        $optionals = array(
            "scope",
            "access_type",
            "redirect_uri",
            "approval_prompt"
        );
        foreach($optionals as $parameter) {
            if (isset($this->config[$parameter]) && !empty($this->config[$parameter])) {
                $parameters[$parameter] = $this->config[$parameter];
            }
        }
        Hybrid_Auth::redirect($this->api->authorizeUrl($parameters));
    }
    /**
     * load the user profile from the IDp api client
     */
    function getUserProfile()
    {
        // refresh tokens if needed
        $this->refreshToken();
        // ask AngelList api for user infos
        $response = $this->api->api("https://api.angel.co/1/me");
        if (!isset($response->id) || isset($response->error)) {
            throw new Exception("User profile request failed! {$this->providerId} returned an invalide response.", 6);
        }
        $this->user->profile->identifier = (property_exists($response, 'id')) ? $response->id : "";
        $this->user->profile->name = (property_exists($response, 'name')) ? $response->name : "";
        $this->user->profile->photoURL = (property_exists($response, 'image')) ? $response->image : "";
        $this->user->profile->profileURL = (property_exists($response, 'angellist_url')) ? $response->angellist_url : "";
        $this->user->profile->email = (property_exists($response, 'email')) ? $response->email : "";
        return $this->user->profile;
    }
}
