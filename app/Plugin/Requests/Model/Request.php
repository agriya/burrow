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
class Request extends AppModel
{
    public $name = 'Request';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'title'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'title',
                'description',
                'tag',
                'address',
                'mobile',
            )
        ) ,
        'FindInSet' => array(
            'setField' => array(
                'Amenity',
                'HolidayType'
            )
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'PropertyType' => array(
            'className' => 'Properties.PropertyType',
            'foreignKey' => 'property_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'RoomType' => array(
            'className' => 'Properties.RoomType',
            'foreignKey' => 'room_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'BedType' => array(
            'className' => 'Properties.BedType',
            'foreignKey' => 'bed_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'RequestFavorite' => array(
            'className' => 'RequestFavorites.RequestFavorite',
            'foreignKey' => 'request_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertiesRequest' => array(
            'className' => 'Requests.PropertiesRequest',
            'foreignKey' => 'request_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'RequestFlag' => array(
            'className' => 'RequestFlags.RequestFlag',
            'foreignKey' => 'request_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'RequestView' => array(
            'className' => 'Requests.RequestView',
            'foreignKey' => 'request_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'HolidayTypeRequest' => array(
            'className' => 'Requests.HolidayTypeRequest',
            'foreignKey' => 'request_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );    
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
			'Chart',
		);
        $this->moreActions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Approved => __l('Approved') ,
            ConstMoreAction::Disapproved => __l('Disapproved') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
        $this->moreMyRequestsActions = array(
			ConstMoreAction::Active => __l('Enable') ,
            ConstMoreAction::Inactive => __l('Disable') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'title' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                )
            ) ,
            'description' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                )
            ) ,
            'address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Please select proper address')
                )
            ) ,
            'address1' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Please enter the address')
            ) ,
            'price_per_night' => array(
                'rule3' => array(
                    'rule' => array(
                        '_validatePrice',
                        'price_per_night'
                    ) ,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Enter valid format')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'checkin' => array(
                'rule2' => array(
                    'rule' => '_isValidCheckinDate',
                    'message' => __l('Oops, seems you given wrong date or greater than checkout date or less than current date, please check it!') ,
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'message' => __l('Should be valid date')
                )
            ) ,
            'checkout' => array(
				'rule3' => array(
                    'rule' => '_isValidCheckinoutDate',
                    'message' => __l('Oops, seems you given wrong date or same date as checkin date , please check it!') ,
                ) ,
                'rule2' => array(
                    'rule' => '_isValidCheckoutDate',
                    'message' => __l('Oops, seems you given wrong date or less than checkin date or less than current date, please check it!') ,
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'message' => __l('Should be valid date')
                )
            ) ,
        );
    }
    function _updateCityRequestCount()
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cityRequests = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1,
            ) ,
            'contain' => array(
                'Request' => array(
                    'conditions' => array(
                        'Request.is_active' => 1,
                        'Request.is_approved' => 1,
                        'Request.checkin >=' => date('Y-m-d') ,
                    ) ,
                    'fields' => array(
                        'Request.id',
                    ) ,
                ) ,
            ) ,
            'recursive' => 2
        ));
        $this->City->updateAll(array(
            'City.request_count' => 0,
        ), array(
		));
        foreach($cityRequests as $cityRequest) {
            if (!empty($cityRequest['Request'])) {
                $this->City->updateAll(array(
                    'City.request_count' => count($cityRequest['Request']) ,
                ) , array(
                    'City.id' => $cityRequest['City']['id']
                ));
            }
        }
    }
    function _validatePrice($field1 = array() , $field2 = null)
    {
        if (isset($this->data[$this->name][$field2]) && $this->data[$this->name][$field2] < 0) {
            return false;
        }
        return true;
    }
    function _isValidCheckinDate()
    {
        if (strtotime($this->data[$this->name]['checkin']) >= strtotime(date('Y-m-d'))) {
            return true;
        } else {
            return false;
        }
    }
    function _isValidCheckoutDate()
    {
        if (strtotime($this->data[$this->name]['checkout']) >= strtotime($this->data[$this->name]['checkin'])) {
            return true;
        } else {
            return false;
        }
    }
	function _isValidCheckinoutDate()
    {
		if (Configure::read('property.days_calculation_mode') == 'Night') {
			if (strtotime($this->data[$this->name]['checkout']) == strtotime($this->data[$this->name]['checkin'])) {
		        return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
    }
    function getSearchKeywords($hash_keyword = '', $salt = '')
    {
        App::import('Model', 'Properties.SearchKeyword');
        $this->SearchKeyword = new SearchKeyword();
        if (!empty($hash_keyword) && !empty($salt)) {
            //decoding
            $keyword_id = hexdec($hash_keyword);
            //checking valid one using encoding format
            $check_hash = dechex($keyword_id);
            $salty = $keyword_id+786;
            $check_salt = substr(dechex($salty) , 0, 2);
            if ($check_hash == $hash_keyword && $check_salt == $salt) {
                $searchKeyword = $this->SearchKeyword->find('first', array(
                    'conditions' => array(
                        'SearchKeyword.id =' => $keyword_id
                    ) ,
                    'fields' => array(
                        'SearchKeyword.id',
                        'SearchKeyword.keyword',
                    ) ,
                    'recursive' => -1,
                ));
                $querystring = $searchKeyword['SearchKeyword']['keyword'];
                $query_string_array = explode('/', $querystring);
                $query_string_array = array_filter($query_string_array);
                $named_array = array();
                foreach($query_string_array as $key => $val) {
                    $split_array = explode(':', $val);
                    $named_array[$split_array[0]] = !empty($split_array[1]) ? $split_array[1] : '';
                    unset($split_array);
                }
                return $named_array;
            }
        }
    }
}
?>