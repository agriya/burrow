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
class BannedIp extends AppModel
{
    public $name = 'BannedIp';
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                )
            ) ,
            'range' => array(
                'rule1' => array(
                    'rule' => 'isRangeRequired',
                    'message' => __l('Required')
                )
            ) ,
            'duration_time' => array(
                'rule1' => array(
                    'rule' => 'isDurationRequired',
                    'message' => __l('Enter number higher than 0')
                )
            ) ,
            'redirect' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkDomainUrl'
                    ) ,
                    'message' => __l('You cannot add your own domain in redirect URL') ,
                    'allowEmpty' => true
                ) ,
                'rule2' => array(
                    'rule' => 'url',
                    'message' => __l('Must be a valid URL') ,
                    'allowEmpty' => true
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'custom',
                        '/^http:\/\//'
                    ) ,
                    'message' => __l('Must be a valid URL, starting with http://') ,
                    'allowEmpty' => true
                )
            )
        );
        $this->ipTypesOptions = array(
            ConstBannedTypes::SingleIPOrHostName => __l('Single IP or hostname') ,
            ConstBannedTypes::IPRange => __l('IP Range') ,
            ConstBannedTypes::RefererBlock => __l('Referer block')
        );
        $this->ipTimeOptions = array(
            ConstBannedDurations::Permanent => __l('Permanent') ,
            ConstBannedDurations::Days => __l('Day(s)') ,
            ConstBannedDurations::Weeks => __l('Week(s)')
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
    // Function to check the given ip is in banned lists or not
    function checkIsIpBanned($ip = null)
    {
        $ip = ip2long($ip);
        $bannedIp = $this->find('first', array(
            'conditions' => array(
                'OR' => array(
                    'BannedIp.address' => $ip,
                    'BannedIp.range' => $ip,
                    'AND' => array(
                        'BannedIp.address >= ' => $ip,
                        'BannedIp.range <= ' => $ip,
                    ) ,
                    array(
                        'AND' => array(
                            'BannedIp.address <= ' => $ip,
                            'BannedIp.range >= ' => $ip,
                        )
                    )
                )
            ) ,
            'recursive' => -1
        ));
        if (!empty($bannedIp)) {
            return $bannedIp;
        }
        return false;
    }
    function _checkDomainUrl()
    {
        $redirect_url_arr = explode('/', str_replace('http://', '', $this->data['BannedIp']['redirect']));
        $url = $redirect_url_arr[0];
        $site_url_arr = explode('/', str_replace('http://', '', Router::url('/', true)));
        $site_url = $site_url_arr[0];
        if ($url == $site_url) {
            return false;
        }
        return true;
    }
    function checkRefererBlocked($url = null)
    {
        if (!empty($url)) {
            $referer_url_arr = explode('/', str_replace('http://', '', $url));
            $url = $referer_url_arr[0];
            $site_url_arr = explode('/', str_replace('http://', '', Router::url('/', true)));
            $site_url = $site_url_arr[0];
            if ($url != $site_url) {
                $bannedIp = $this->find('first', array(
                    'conditions' => array(
                        'BannedIp.referer_url' => $url
                    ) ,
                    'recursive' => -1
                ));
            }
            if (!empty($bannedIp)) {
                return $bannedIp;
            }
        }
        return false;
    }
    function isRangeRequired()
    {
        if ($this->data['BannedIp']['type_id'] == ConstBannedTypes::IPRange) {
            if (empty($this->data['BannedIp']['range'])) {
                return false;
            }
        }
        return true;
    }
    function isDurationRequired()
    {
        if ($this->data['BannedIp']['duration_id'] != ConstBannedDurations::Permanent) {
            if (empty($this->data['BannedIp']['duration_time']) || $this->data['BannedIp']['duration_time'] <= 0) {
                return false;
            }
        }
        return true;
    }
}
?>