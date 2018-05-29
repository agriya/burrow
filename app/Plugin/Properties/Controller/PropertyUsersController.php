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
class PropertyUsersController extends AppController
{
    public $name = 'PropertyUsers';
	public $permanentCacheAction = array(
		'user' => array(
			'index',
			'view',
			'add',
			'manage',
			'process_checkinout',
			'check_qr',
		) ,
    );
    public function beforeFilter()
    {
        if (in_array($this->request->action, array(
			'index',
            'update_property'
        ))) {
            $this->Security->validatePost = false;
        }
        $this->Security->disabledFields = array(
            'PropertyUser.property_id',
            'PropertyUser.property_slug',
            'PropertyUser.checkinout.day',
            'PropertyUser.checkinout.month',
            'PropertyUser.checkinout.year',
            'PropertyUser.contact',
            'Payment.contact',
            'Property.property',
            'Property.price_per_night',
            'Property.price_per_week',
            'Property.price_per_month',
            'Property.type',
            'Property.status',
			'PropertyUser.price'
        );
        parent::beforeFilter();
    }
    public function index()
    {
        // @todo "iCalendar"
        $order = array(
            'PropertyUser.checkin' => 'asc'
        );
        $this->pageTitle = __l('Property Users');
        if (!empty($this->request->data)) {
            $property_ids = array();
            foreach($this->request->data['Property'] as $properties) {
                if (!empty($properties['property']) && is_array($properties)) {
                    $property_ids[] = $properties['property'];
                }
            }
            if (!empty($property_ids)) {
                $this->request->params['named']['property_id'] = implode(',', $property_ids);
            }
            if (!empty($this->request->data['PropertyUser']['type'])) {
                $this->request->params['named']['type'] = $this->request->data['PropertyUser']['type'];
            }
            if (!empty($this->request->data['PropertyUser']['status'])) {
                $this->request->params['named']['status'] = $this->request->data['PropertyUser']['status'];
            }
        }
        if (!empty($this->request->params['named']['type'])) { // Type
            $conditions = array();
            $filter_count = $this->PropertyUser->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if ($this->request->params['named']['type'] == 'mytours') { // Buyer
                $all_count = $filter_count['User']['travel_expired_count']+$filter_count['User']['travel_rejected_count']+$filter_count['User']['travel_canceled_count']+$filter_count['User']['travel_review_count']+$filter_count['User']['travel_completed_count']+$filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']+$filter_count['User']['travel_waiting_for_acceptance_count']+$filter_count['User']['travel_payment_pending_count']+$filter_count['User']['travel_payment_cleared_count'];
                $this->set('all_count', $all_count);
                $status_count = array(
                    __l('Current / Upcoming') . ': ' . ($filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']) => 'in_progress',
                    __l('Waiting for Review') . ': ' . $filter_count['User']['travel_review_count'] => 'waiting_for_review',
                    __l('Past') . ': ' . $filter_count['User']['travel_completed_count'] => 'completed',
                    __l('Waiting for Acceptance') . ': ' . $filter_count['User']['travel_waiting_for_acceptance_count'] => 'waiting_for_acceptance',
                    __l('Canceled') . ': ' . $filter_count['User']['travel_canceled_count'] => 'canceled',
                    __l('Rejected') . ': ' . $filter_count['User']['travel_rejected_count'] => 'rejected',
                    __l('Expired') . ': ' . $filter_count['User']['travel_expired_count'] => 'expired',
                    __l('Negotiation') . ': ' . $filter_count['User']['travel_negotiation_count'] => 'negotiation',
                    __l('Arrived') . ': ' . $filter_count['User']['travel_arrived_count'] => 'arrived',
                    __l('Payment Pending') . ': ' . $filter_count['User']['travel_payment_pending_count'] => 'payment_pending',
                );
                $this->set('moreActions', $status_count);
                if (!empty($this->request->params['named']['status'])) {
                    $order_status = array(
                        'waiting_for_acceptance' => 1,
                        'confirmed' => 2,
                        'rejected' => 3,
                        'canceled' => 4,
                        'arrived' => 5,
                        'waiting_for_review' => 6,
                        'payment_cleared' => 7,
                        'completed' => 8,
                        'Expired' => 9,
                        'negotiation_requested' => 10,
                        'negotiation_rejected' => 11,
                        'negotiation_confirmed' => 12,
                        'arrived' => 13,
                        'payment_pending' => 14,
                    );
                    $propertyStatusClass = array(
                        'waiting_for_acceptance' => 'waitingforacceptance',
                        'confirmed' => 'confirmed',
                        'completed' => 'completed',
                        'canceled' => 'cancelled',
                        'rejected' => 'rejected',
                        'expired' => 'expired',
                        'waiting_for_review' => 'waitingforyourreview',
                        'in_progress' => 'currentorupcoming',
                        'negotiation' => 'negotiationrequested',
                        'arrived' => 'arrived',
                        'payment_pending' => 'paymentpending',
                    );
                    $this->set('propertyStatusClass', $propertyStatusClass);
                    if ($this->request->params['named']['status'] == 'completed') {
                        // @todo "Auto review" add condition CompletedAndClosedByAdmin
                        $status = array(
                            ConstPropertyUserStatus::Completed,
                        );
                    } else if ($this->request->params['named']['status'] == 'rejected') {
                        $status = array(
                            ConstPropertyUserStatus::Rejected,
                        );
                    } else if ($this->request->params['named']['status'] == 'canceled') {
                        $status = array(
                            ConstPropertyUserStatus::Canceled,
                            ConstPropertyUserStatus::CanceledByAdmin,
                        );
                    } else if ($this->request->params['named']['status'] == 'expired') {
                        $status = array(
                            ConstPropertyUserStatus::Expired,
                        );
                    } else if ($this->request->params['named']['status'] == 'in_progress') {
                        $status = array(
                            ConstPropertyUserStatus::Confirmed,
                            ConstPropertyUserStatus::Arrived,
                        );
                    } else if ($this->request->params['named']['status'] == 'payment_pending') {
                        $status = array(
                            ConstPropertyUserStatus::PaymentPending,
                        );
                    } else if ($this->request->params['named']['status'] == 'payment_cleared') {
                        $conditions['PropertyUser.is_payment_cleared'] = 1;
                    } else if ($this->request->params['named']['status'] == 'waiting_for_review') {
                        $status = array(
                            ConstPropertyUserStatus::WaitingforReview,
                        );
                    } else if ($this->request->params['named']['status'] == 'waiting_for_acceptance') {
                        $status = array(
                            ConstPropertyUserStatus::WaitingforAcceptance,
                        );
                    } else if ($this->request->params['named']['status'] == 'arrived') {
                        $status = array(
                            ConstPropertyUserStatus::Arrived,
                        );
                    } else {
                        $status = strtr($this->request->params['named']['status'], $order_status);
                    }
                    if ($this->request->params['named']['status'] == 'negotiation') {
                        $conditions['PropertyUser.is_negotiation_requested'] = 1;
                        $conditions['PropertyUser.user_id >'] = 0;
                        $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
                    } elseif (!empty($status) && $status != 'all') {
                        $conditions['PropertyUser.property_user_status_id'] = $status;
                    }
                } else {
                    $conditions['OR'][]['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Confirmed;
                    $conditions['OR'][]['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Arrived;
                }
                $conditions['Not']['PropertyUser.property_user_status_id'] = array(
                    0
                );
                $this->pageTitle = __l('Trips');
                $conditions['PropertyUser.user_id'] = $this->Auth->user('id');
            }
            if ($this->request->params['named']['type'] == 'myworks') { // Seller
                $countcal_conditions['OR']['NOT']['PropertyUser.property_user_status_id'] = 0;
                $countcal_conditions['OR']['NOT']['PropertyUser.property_user_status_id'] = array(
                            0,
                            ConstPropertyUserStatus::PaymentPending
                        );
                        $countcal_conditions['PropertyUser.user_id >'] = 0;
                        $countcal_conditions['OR']['AND'] = array(
                            'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                            'PropertyUser.is_negotiation_requested' => 1
                        );
                 $countcal_conditions['PropertyUser.owner_user_id'] = $this->Auth->user('id');
                 $all_count = $this->PropertyUser->find('count', array(
                 'conditions' => $countcal_conditions,
                 'recursive' => -1
                   ));
                $this->set('all_count', $all_count);
                $status_count = array(
                    __l('Waiting for Acceptance') . ': ' . $filter_count['User']['host_waiting_for_acceptance_count'] => 'waiting_for_acceptance',
                    __l('Waiting for Review') . ': ' . $filter_count['User']['host_review_count'] => 'waiting_for_review',
                    __l('Confirmed') . ': ' . $filter_count['User']['host_confirmed_count'] => 'confirmed',
                    __l('Past') . ': ' . $filter_count['User']['host_completed_count'] => 'completed',
                    __l('Canceled') . ': ' . $filter_count['User']['host_canceled_count'] => 'canceled',
                    __l('Rejected') . ': ' . $filter_count['User']['host_rejected_count'] => 'rejected',
                    __l('Expired') . ': ' . $filter_count['User']['host_expired_count'] => 'expired',
                    __l('Negotiation') . ': ' . $filter_count['User']['host_negotiation_count'] => 'negotiation',
                    __l('Arrived') . ': ' . $filter_count['User']['host_arrived_count'] => 'arrived',
                    __l('Payment Cleared') . ': ' . $filter_count['User']['host_payment_cleared_count'] => 'payment_cleared',
                );
                $data_status_count = array(
                    'waiting_for_acceptance' => array(
                        'label' => __l('Waiting for Acceptance') ,
                        'count' => $filter_count['User']['host_waiting_for_acceptance_count']
                    ) ,
                    'waiting_for_review' => array(
                        'label' => __l('Waiting for Review') ,
                        'count' => $filter_count['User']['host_review_count']
                    ) ,
                    'confirmed' => array(
                        'label' => __l('Confirmed') ,
                        'count' => $filter_count['User']['host_confirmed_count']
                    ) ,
                    'completed' => array(
                        'label' => __l('Past') ,
                        'count' => $filter_count['User']['host_completed_count']
                    ) ,
                    'canceled' => array(
                        'label' => __l('Canceled') ,
                        'count' => $filter_count['User']['host_canceled_count']
                    ) ,
                    'rejected' => array(
                        'label' => __l('Rejected') ,
                        'count' => $filter_count['User']['host_rejected_count']
                    ) ,
                    'expired' => array(
                        'label' => __l('Expired') ,
                        'count' => $filter_count['User']['host_expired_count']
                    ) ,
                    'negotiation' => array(
                        'label' => __l('Negotiation') ,
                        'count' => $filter_count['User']['host_negotiation_count']
                    ) ,
                    'arrived' => array(
                        'label' => __l('Arrived') ,
                        'count' => $filter_count['User']['host_arrived_count']
                    ) ,
                    'payment_cleared' => array(
                        'label' => __l('Payment Cleared') ,
                        'count' => $filter_count['User']['host_payment_cleared_count']
                    ) ,
                );
                $this->set('data_status_count', $data_status_count);
                $propertyStatusClass = array(
                    'waiting_for_acceptance' => 'waitingforacceptance',
                    'confirmed' => 'confirmed',
                    'completed' => 'completed',
                    'canceled' => 'cancelled',
                    'rejected' => 'rejected',
                    'expired' => 'expired',
                    'waiting_for_review' => 'waitingforyourreview',
                    'in_progress' => 'currentorupcoming',
                    'negotiation' => 'negotiationrequested',
                    'arrived' => 'arrived',
                    'payment_pending' => 'paymentpending',
                    'payment_cleared' => 'confirmed',
                );
                $this->set('propertyStatusClass', $propertyStatusClass);
                $this->set('moreActions', $status_count);
                if (!empty($this->request->params['named']['status'])) {
                    $order_status = array(
                        'waiting_for_acceptance' => 1,
                        'confirmed' => 2,
                        'rejected' => 3,
                        'canceled' => 4,
                        'arrived' => 5,
                        'waiting_for_review' => 6,
                        'payment_cleared' => 7,
                        'completed' => 8,
                        'Expired' => 9,
                        'negotiation_requested' => 10,
                        'negotiation_rejected' => 11,
                        'negotiation_confirmed' => 12,
                        'payment_cleared' => 13,
                    );
                    if ($this->request->params['named']['status'] == 'completed') {
                        // @todo "Auto review" add condition CompletedAndClosedByAdmin
                        $status = array(
                            ConstPropertyUserStatus::Completed,
                        );
                    } else if ($this->request->params['named']['status'] == 'rejected') {
                        $status = array(
                            ConstPropertyUserStatus::Rejected,
                        );
                    } else if ($this->request->params['named']['status'] == 'canceled') {
                        $status = array(
                            ConstPropertyUserStatus::Canceled,
                            ConstPropertyUserStatus::CanceledByAdmin,
                        );
                    } else if ($this->request->params['named']['status'] == 'expired') {
                        $status = array(
                            ConstPropertyUserStatus::Expired,
                        );
                    } else if ($this->request->params['named']['status'] == 'confirmed') {
                        $status = array(
                            ConstPropertyUserStatus::Confirmed,
                        );
                    } else if ($this->request->params['named']['status'] == 'confirmed') {
                        $status = array(
                            ConstPropertyUserStatus::Arrived,
                        );
                    } else if ($this->request->params['named']['status'] == 'pipeline') {
                        $status = array(
                            ConstPropertyUserStatus::Arrived,
							ConstPropertyUserStatus::Confirmed,
							ConstPropertyUserStatus::WaitingforReview,
                            ConstPropertyUserStatus::PaymentCleared,
                            ConstPropertyUserStatus::Completed,
                        );
						$conditions['PropertyUser.is_payment_cleared'] = 0;
                    } else if ($this->request->params['named']['status'] == 'waiting_for_acceptance') {
                        $status = array(
                            ConstPropertyUserStatus::WaitingforAcceptance,
                        );
                    } else if ($this->request->params['named']['status'] == 'payment_cleared') {
                        $conditions['PropertyUser.is_payment_cleared'] = 1;
                    } else if ($this->request->params['named']['status'] == 'waiting_for_review') {
                        $status = array(
                            ConstPropertyUserStatus::WaitingforReview,
                            ConstPropertyUserStatus::PaymentCleared,
                            ConstPropertyUserStatus::Completed,
                        );
                        $conditions['PropertyUser.is_host_reviewed'] = 0;
						$conditions['PropertyUser.is_auto_checkout'] = 1;
                    } else {
                        $status = strtr($this->request->params['named']['status'], $order_status);
                    }
                    if ($this->request->params['named']['status'] == 'negotiation') {
                        $conditions['PropertyUser.is_negotiation_requested'] = 1;
                        $conditions['PropertyUser.user_id >'] = 0;
                        $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
                    } elseif (!empty($status) && $status != 'all') {
                        $conditions['PropertyUser.property_user_status_id'] = $status;
                    }
                } else {
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::WaitingforAcceptance;
                }
                if (!empty($this->request->params['named']['slug'])) {
                    $conditions['Property.slug'] = $this->request->params['named']['slug'];
                }
                if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] != 'negotiation') {
                    $conditions['OR']['NOT']['PropertyUser.property_user_status_id'] = 0;
                    if ($this->request->params['named']['status'] == 'all') {
                        $conditions['OR']['NOT']['PropertyUser.property_user_status_id'] = array(
                            0,
                            ConstPropertyUserStatus::PaymentPending
                        );
                        $conditions['PropertyUser.user_id >'] = 0;
                        $conditions['OR']['AND'] = array(
                            'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                            'PropertyUser.is_negotiation_requested' => 1
                        );
                        
                    }
                }
                $this->pageTitle = __l('Calendar');
                $conditions['PropertyUser.owner_user_id'] = $this->Auth->user('id');
            }
        } else {
            $conditions['Property.user_id'] = $this->Auth->user('id');
			// todo -> type missing that Invalid request set
			throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['property_id'])) {
            $property = $this->PropertyUser->Property->find('count', array(
                'conditions' => array(
                    'Property.id' => $this->request->params['named']['property_id'],
                    'Property.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (!$property) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Property.id'] = explode(',', $this->request->params['named']['property_id']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.blocked_amount',
                        'User.cleared_amount',
                    )
                ) ,
                'PropertyUserStatus' => array(
                    'fields' => array(
                        'PropertyUserStatus.id',
                        'PropertyUserStatus.name',
                        'PropertyUserStatus.property_user_count',
                        'PropertyUserStatus.slug',
                    )
                ) ,
                'Message',
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.created',
                        'Property.title',
                        'Property.slug',
                        'Property.property_type_id',
                        'Property.user_id',
                        'Property.description',
                        'Property.property_type_id',
                        'Property.checkin',
                        'Property.checkout',
                        'Property.user_id',
                        'Property.latitude',
                        'Property.longitude',
                        'Property.address',
                        'Property.security_deposit',
                    ) ,
                    'User' => array(
                        'UserAvatar',
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.blocked_amount',
                            'User.cleared_amount',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2'
                        )
                    ) ,
                    'PropertyType',
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.filename',
                            'Attachment.dir',
                            'Attachment.width',
                            'Attachment.height'
                        ) ,
                        'limit' => 1,
                    ) ,
                ) ,
            ) ,
            'order' => $order,
            'recursive' => 3,
            'limit' => 15,
        );
        $propertyUsers = $this->paginate();
        $this->set('propertyUsers', $propertyUsers);
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $response = Cms::dispatchEvent('Controller.PropertyUser.listing', $this, array(
				'data' => $propertyUsers
			));
        }
        $user = $this->PropertyUser->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1,
        ));
        $this->set('user', $user);
        // For iPhone App code -->
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myworks') {
            $this->pageTitle = __l('Calendar');
            $this->render('index');
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mytours') {
            $this->pageTitle = __l('Trips');
            if (isset($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'list') {
                   $this->render('my_order_lists');
            } else {
				$this->render('my_orders');
            }
        }
    }
    public function update_property()
    {
        if (!empty($this->request->data)) {
            $data = array();
            foreach($this->request->data['Property'] as $property) {
                if (isset($property['id'])) {
                    $data['Property']['id'] = $property['id'];
                    $data['Property']['price_per_night'] = $property['price_per_night'];
                    $data['Property']['price_per_week'] = $property['price_per_week'];
                    $data['Property']['price_per_month'] = $property['price_per_month'];
                    $this->PropertyUser->Property->save($data, false);
                }
            }
            $this->Session->setFlash(__l('Property info updated successfully') , 'default', null, 'success');
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect(array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'myworks',
                    'status' => 'waiting_for_acceptance'
                ));
            } else {
                exit;
            }
        }
    }
    public function view($id = null)
    {
        $this->pageTitle = __l('Ticket');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions['PropertyUser.id'] = $id;
        if ($this->Auth->user('role_id') == ConstUserTypes::User) {
            $conditions['PropertyUser.user_id'] = $this->Auth->user('id');
        }
        $propertyUser = $this->PropertyUser->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'Property' => array(
                    'CancellationPolicy',
                    'Attachment',
                    'User' => array(
                        'UserProfile'
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.id',
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.id',
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                ) ,
                'User' => array(
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.id',
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.id',
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.id',
                                'Country.name',
                            )
                        ) ,
                    ) ,
                )
            ) ,
            'recursive' => 3
        ));
        if (empty($propertyUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $propertyUser['Property']['title'];
        $this->set('propertyUser', $propertyUser);
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print') {
			if(empty($propertyUser['PropertyUser']['is_payment_cleared'])){
				throw new NotFoundException(__l('Invalid request'));
			}
            $this->layout = 'print';
            $this->render('view-print');
        }
    }
    public function add()
    {
        $this->pageTitle = __l('Add Property User');
        if (!empty($this->request->data)) {
            if (Configure::read('property.days_calculation_mode') == 'Night') {
				list($this->request->data['PropertyUser']['checkout']['year'], $this->request->data['PropertyUser']['checkout']['month'], $this->request->data['PropertyUser']['checkout']['day']) = explode('-', date('Y-m-d', strtotime($this->request->data['PropertyUser']['checkout']['year'] . '-' . $this->request->data['PropertyUser']['checkout']['month'] . '-' . $this->request->data['PropertyUser']['checkout']['day'] . '-1 day')));
            }
            // @todo "Guest details"
            // Additional Guest Price Calculation
            $property = $this->PropertyUser->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $this->request->data['PropertyUser']['property_id']
                ) ,
                'fields' => array(
                    'Property.id',
                    'Property.additional_guest',
                    'Property.security_deposit',
                    'Property.additional_guest_price',
                    'Property.user_id',
                    'Property.maximum_nights',
                    'Property.minimum_nights',
                ) ,
                'recursive' => -1
            ));
            //already booked or not conditions
            $checkin = $this->request->data['PropertyUser']['checkin']['year'] . '-' . $this->request->data['PropertyUser']['checkin']['month'] . '-' . $this->request->data['PropertyUser']['checkin']['day'];
            $checkout = $this->request->data['PropertyUser']['checkout']['year'] . '-' . $this->request->data['PropertyUser']['checkout']['month'] . '-' . $this->request->data['PropertyUser']['checkout']['day'];
            $booking_conditions['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived
            );
            $booking_conditions['PropertyUser.property_id'] = $this->request->data['PropertyUser']['property_id'];
            $booking_conditions['PropertyUser.checkin <='] = $checkout;
            $booking_conditions['PropertyUser.checkout >='] = $checkin;
            $booking_list = $this->PropertyUser->find('list', array(
                'conditions' => $booking_conditions,
                'fields' => array(
                    'PropertyUser.id',
                    'PropertyUser.property_id'
                ) ,
                'recursive' => -1
            ));
            $custom_conditions['CustomPricePerNight.is_available'] = ConstPropertyStatus::NotAvailable;
            $custom_conditions['CustomPricePerNight.property_id'] = $this->request->data['PropertyUser']['property_id'];
            $custom_conditions['CustomPricePerNight.start_date <='] = $checkout;
            $custom_conditions['CustomPricePerNight.end_date >='] = $checkin;
            $not_available_list = $this->PropertyUser->Property->CustomPricePerNight->find('list', array(
                'conditions' => $custom_conditions,
                'fields' => array(
                    'CustomPricePerNight.id',
                    'CustomPricePerNight.property_id'
                ) ,
                'recursive' => -1
            ));
            $booking_list = array_merge($booking_list, $not_available_list);
            $booked_ids = array();
            if (count($booking_list) > 0) {
                foreach($booking_list as $booking) {
                    $booked_ids[] = $booking;
                }
            }
            //booked this property already
            if (count($booked_ids) > 0) {
                $this->Session->setFlash(__l('Property not available on the specified date. Please, try for some other dates.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $this->request->data['PropertyUser']['property_slug']
                ));
            }
            //booked or not conditions ends here
            // Total Price Calculation
            // @todo "Discount percentage"
            if ($this->request->data['PropertyUser']['booking_option'] == 'price_per_week') {
                /* checkCustomWeekPrice(startdate,enddate,propertyId,additionalGustCount)  */
                $this->request->data['PropertyUser']['price'] = $this->PropertyUser->Property->checkCustomWeekPrice($checkin, getCheckoutDate($checkout) , $this->request->data['PropertyUser']['property_id'], $this->request->data['PropertyUser']['guests']);
            } elseif ($this->request->data['PropertyUser']['booking_option'] == 'price_per_night') {
                /* checkCustomPrice(startdate,enddate,propertyId,additionalGustCount)  */
                $this->request->data['PropertyUser']['price'] = $this->PropertyUser->Property->checkCustomPrice($checkin, getCheckoutDate($checkout) , $this->request->data['PropertyUser']['property_id'], $this->request->data['PropertyUser']['guests']);
            } elseif ($this->request->data['PropertyUser']['booking_option'] == 'price_per_month') {
                /* checkCustomMonthPrice(startdate,enddate,propertyId,additionalGustCount)  */
                $this->request->data['PropertyUser']['price'] = $this->PropertyUser->Property->checkCustomMonthPrice($checkin, getCheckoutDate($checkout) , $this->request->data['PropertyUser']['property_id'], $this->request->data['PropertyUser']['guests']);
            }
            $this->request->data['PropertyUser']['original_price'] = $this->request->data['PropertyUser']['price'];
            $days = getCheckinCheckoutDiff($this->request->data['PropertyUser']['checkin']['year'] . '-' . $this->request->data['PropertyUser']['checkin']['month'] . '-' . $this->request->data['PropertyUser']['checkin']['day'], getCheckoutDate($this->request->data['PropertyUser']['checkout']['year'] . '-' . $this->request->data['PropertyUser']['checkout']['month'] . '-' . $this->request->data['PropertyUser']['checkout']['day']));
            if ($property['Property']['maximum_nights'] > 0) {
                if ($days > $property['Property']['maximum_nights']) {
                    $this->Session->setFlash(__l('Number of nights exceeded the property maximum nights, so please choose within a limit') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $this->request->data['PropertyUser']['property_slug']
                    ));
                }
            }
            if ($property['Property']['minimum_nights'] > 0) {
                if ($days < $property['Property']['minimum_nights']) {
                    $this->Session->setFlash(__l('Number of nights should maximum of the property minimum nights, so please choose within a limit') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $this->request->data['PropertyUser']['property_slug']
                    ));
                }
            }
            $this->PropertyUser->create();
            if ($this->Auth->user('id') != '') {
                $this->request->data['PropertyUser']['user_id'] = $this->Auth->user('id');
            } else {
                $this->request->data['PropertyUser']['user_id'] = 0;
            }
            // @todo "What goodies I want (Host)"
            $this->request->data['PropertyUser']['is_delayed_chained_payment'] = 0;
            $this->request->data['PropertyUser']['is_preapproval_payment'] = 0;
            $this->request->data['PropertyUser']['owner_user_id'] = $property['Property']['user_id'];
            $this->request->data['PropertyUser']['top_code'] = $this->_uuid();
            $this->request->data['PropertyUser']['security_deposit'] = $property['Property']['security_deposit'];
            $this->request->data['PropertyUser']['bottum_code'] = $this->_unum();
            $this->request->data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
            $this->request->data['PropertyUser']['traveler_service_amount'] = $this->request->data['PropertyUser']['price']*(Configure::read('property.booking_service_fee') /100);
            $hosting_fee = $this->request->data['PropertyUser']['price']*(Configure::read('property.host_commission_amount') /100);
            $this->request->data['PropertyUser']['host_service_amount'] = $hosting_fee;
            if (isset($this->request->data['PropertyUser']['contact'])) {
                $this->request->data['PropertyUser']['is_negotiation_requested'] = 1;
            }
            $this->PropertyUser->set($this->request->data);
            if ($this->PropertyUser->validates()) {
                $this->PropertyUser->save($this->request->data);
                $property_user_id = $this->PropertyUser->getLastInsertId();
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
					'_trackEvent' => array(
						'category' => 'PropertyUser',
						'action' => 'Bookit',
						'label' => 'Step 1',
						'value' => '',
					) ,
					'_setCustomVar' => array(
						'ud' => $this->Auth->user('id'),
						'rud' => $this->Auth->user('referred_by_user_id'),
					)
				));
				if ($this->RequestHandler->isAjax()) {
                    $this->Session->setFlash(__l('Property has been booked') , 'default', null, 'success');
                    if (isset($this->request->data['PropertyUser']['contact'])) {
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'order',
                            $this->request->data['PropertyUser']['property_id'],
                            'order_id' => $property_user_id,
                            'type' => __l('contact') ,
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'order',
                            $this->request->data['PropertyUser']['property_id'],
                            'order_id' => $property_user_id,
                        ));
                    }
                } else {
                    if (isset($this->request->data['PropertyUser']['contact'])) {
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'order',
                            $this->request->data['PropertyUser']['property_id'],
                            'order_id' => $property_user_id,
                            'type' => __l('contact') ,
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'order',
                            $this->request->data['PropertyUser']['property_id'],
                            'order_id' => $property_user_id,
                        ));
                    }
                }
            } else {
                if (isset($this->PropertyUser->validationErrors['checkin'])) {
                    $this->Session->setFlash($this->PropertyUser->validationErrors['checkin'][0], 'default', null, 'error');
                } elseif (isset($this->PropertyUser->validationErrors['checkout'])) {
                    $this->Session->setFlash($this->PropertyUser->validationErrors['checkout'][0], 'default', null, 'error');
                } elseif (isset($this->PropertyUser->validationErrors['checkinout'])) {
                    $this->Session->setFlash($this->PropertyUser->validationErrors['checkinout'][0], 'default', null, 'error');
                } elseif (isset($this->PropertyUser->validationErrors['guests'])) {
                    $this->Session->setFlash(__l('Maximum guest allowed for this property is ') . $property['Property']['additional_guest'], 'default', null, 'error');
                } else {
                    $this->Session->setFlash(__l('Property  not available on the specified date . Please, try for some other dates.') , 'default', null, 'error');
                }
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $this->request->data['PropertyUser']['property_slug']
                ));
            }
        }
        $paymentGateways = $this->PropertyUser->PaymentGateway->find('list');
        $this->set(compact('paymentGateways'));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'role_id',
            'filter_id',
            'q'
        ));
        $this->pageTitle = __l('Property Bookings');
        $conditions = array();
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'traveler_cleared') {
            $conditions['PropertyUser.property_user_status_id !='] = ConstPropertyUserStatus::PaymentPending;
        } elseif (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'host_cleared') {
            // @todo "Auto review" add condition CompletedAndClosedByAdmin
            $conditions['or'] = array(
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Completed,
                ) ,
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentCleared,
                ) ,
            );
        } elseif (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'traveler_pipeline') {
            $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
        } elseif (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'host_pipeline') {
            $conditions['or'] = array(
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Confirmed,
                ) ,
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Arrived,
                ) ,
            );
        } elseif (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'host_lost') {
            $conditions['or'] = array(
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Rejected,
                ) ,
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Canceled,
                ) ,
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Expired,
                ) ,
                array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::CanceledByAdmin,
                )
            );
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['PropertyUser.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - booked today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['PropertyUser.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - booked in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['PropertyUser.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - booked in this month');
        }
        if (isset($this->request->params['named']['property_id'])) {
            $conditions['PropertyUser.property_id'] = $this->request->params['named']['property_id'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            $this->request->data['PropertyUser']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['PropertyUser']['filter_id'])) {
            switch ($this->request->data['PropertyUser']['filter_id']) {
                case ConstPropertyUserStatus::PaymentPending:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
                    $this->pageTitle.= __l(' - Payment Pending');
                    break;

                case ConstPropertyUserStatus::WaitingforAcceptance:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::WaitingforAcceptance;
                    $this->pageTitle.= __l(' - Waiting for Acceptance');
                    break;

                case ConstPropertyUserStatus::Confirmed:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Confirmed;
                    $this->pageTitle.= __l(' - Confirmed');
                    break;

                case ConstPropertyUserStatus::Rejected:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstPropertyUserStatus::Canceled:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Canceled;
                    $this->pageTitle.= __l(' - Canceled');
                    break;

                case ConstPropertyUserStatus::Arrived:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Arrived;
                    $this->pageTitle.= __l(' - Arrived');
                    break;

                case ConstPropertyUserStatus::WaitingforReview:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
                    $this->pageTitle.= __l(' - Waiting for Review');
                    break;

                case ConstPropertyUserStatus::Completed:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Completed;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstPropertyUserStatus::Expired:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::Expired;
                    $this->pageTitle.= __l(' - Expired');
                    break;

                case ConstPropertyUserStatus::CanceledByAdmin:
                    $conditions['PropertyUser.property_user_status_id'] = ConstPropertyUserStatus::CanceledByAdmin;
                    $this->pageTitle.= __l(' - Canceled by Admin');
                    break;

                case ConstPropertyUserStatus::PaymentCleared:
                    $conditions['PropertyUser.is_payment_cleared'] = 1;
                    $this->pageTitle.= __l(' - Payment Cleared');
                    break;

                case ConstPropertyUserStatus::HostReviewed:
                    $conditions['PropertyUser.is_host_reviewed'] = 1;
                    $this->pageTitle.= __l(' - Payment Cleared');
                    break;
                    // @todo "Auto review" add new case CompletedAndClosedByAdmin

            }
            $this->request->params['named']['filter_id'] = $this->request->data['PropertyUser']['filter_id'];
		}
		if (isset($this->request->params['named']['q'])) {
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyUserStatus.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['OwnerUser.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$this->request->data['PropertyUser']['q'] = $this->request->params['named']['q'];
			$this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
		}
		$this->paginate = array(
			'conditions' => $conditions,
				'contain' => array(
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.blocked_amount',
							'User.cleared_amount',
						)
					) ,
					'OwnerUser' => array(
						'fields' => array(
							'OwnerUser.id',
							'OwnerUser.username',
						)
					) ,
					'PropertyUserStatus' => array(
						'fields' => array(
							'PropertyUserStatus.id',
							'PropertyUserStatus.name',
							'PropertyUserStatus.property_user_count',
							'PropertyUserStatus.slug',
						)
					) ,
					'Message',
					'Property' => array(
						'fields' => array(
							'Property.id',
							'Property.created',
							'Property.title',
							'Property.slug',
							'Property.property_type_id',
							'Property.user_id',
							'Property.description',
							'Property.property_type_id',
							'Property.checkin',
							'Property.checkout',
							'Property.user_id',
							'Property.latitude',
							'Property.longitude',
							'Property.address',
							'Property.security_deposit',
						) ,
						'User' => array(
							'UserAvatar',
							'fields' => array(
								'User.id',
								'User.username',
								'User.blocked_amount',
								'User.cleared_amount',
							)
						) ,
						'Country' => array(
							'fields' => array(
								'Country.name',
								'Country.iso_alpha2'
							)
						) ,
						'PropertyType',
						'Attachment' => array(
							'fields' => array(
								'Attachment.id',
								'Attachment.filename',
								'Attachment.dir',
								'Attachment.width',
								'Attachment.height'
							) ,
							'limit' => 1,
						) ,
					) ,
				) ,
			'recursive' => 2,
			'order' => array(
				'PropertyUser.id' => 'desc'
			)
		);
		$propertyUserStatuses = $this->PropertyUser->PropertyUserStatus->find('list');
		foreach($propertyUserStatuses as $id => $propertyUserStatus) {
			$count_conditions = array();
			if ($id == ConstPropertyUserStatus::PaymentCleared) {
				$count_conditions['PropertyUser.is_payment_cleared'] = 1;
			} else {
				$count_conditions['PropertyUser.property_user_status_id'] = $id;
			}
			$propertyUserStatusesCount[$id] = $this->PropertyUser->find('count', array(
				'conditions' => $count_conditions,
				'recursive' => -1
			));
		}
		$count_conditions = array();
		$count_conditions['PropertyUser.is_host_reviewed'] = 1;
		$propertyUserStatusesCount[ConstPropertyUserStatus::HostReviewed] = $this->PropertyUser->find('count', array(
			'conditions' => $count_conditions,
			'recursive' => -1
		));
		$this->set('propertyUserStatusesCount', $propertyUserStatusesCount);
		$this->set('propertyUserStatuses', $propertyUserStatuses);
		$this->set('propertyUsers', $this->paginate());
		$this->set('total_count', $this->PropertyUser->find('count'));
		$filters = $this->PropertyUser->isFilterOptions;
		$moreActions = $this->PropertyUser->moreActions;
		$this->set(compact('moreActions', 'filters'));
	}
	public function admin_delete($id = null)
	{
		if (is_null($id)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$conditions = array();
		$conditions['PropertyUser.id'] = $id;
		$conditions['PropertyUser.property_user_status_id'] = array(
			ConstPropertyUserStatus::WaitingforAcceptance,
			ConstPropertyUserStatus::Confirmed
		);
		$check_order = $this->PropertyUser->find('first', array(
			'conditions' => $conditions,
			'recursive' => -1
		));
		if (empty($check_order)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		if ($this->PropertyUser->updateStatus($id, ConstPropertyUserStatus::CanceledByAdmin)) {
			$this->Session->setFlash(__l('Booking has been canceled and refunded.') , 'default', null, 'success');
			$this->redirect(array(
				'controller' => 'property_users',
				'action' => 'index',
				'admin' => true
			));
		} else {
			throw new NotFoundException(__l('Invalid request'));
		}
	}
	public function track_order($id = null)
	{
		if (is_null($id)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$propertyOrder = $this->PropertyUser->find('first', array(
			'conditions' => array(
				'PropertyUser.id' => $id,
				'PropertyUser.user_id' => $this->Auth->user('id')
			) ,
			'contain' => array(
				'Property' => array(
					'fields' => array(
						'Property.id',
						'Property.title',
						'Property.user_id',
						'Property.no_of_days',
						'Property.slug',
						'Property.amount',
						'Property.address',
						'Property.mobile',
						'Property.property_type_id',
					) ,
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.email',
							'User.blocked_amount',
							'User.cleared_amount',
						)
					)
				) ,
				'User' => array(
					'fields' => array(
						'User.id',
						'User.username',
						'User.email',
						'User.blocked_amount',
						'User.cleared_amount',
					)
				) ,
			) ,
			'recursive' => 2,
		));
		$relatedMessages = $this->PropertyUser->Message->find('all', array(
			'conditions' => array(
				'Message.property_user_id =' => $id,
				'Message.is_review =' => 1,
				'Message.is_sender =' => 0
			) ,
			'contain' => array(
				'MessageContent' => array(
					'fields' => array(
						'MessageContent.id',
						'MessageContent.created',
						'MessageContent.subject',
						'MessageContent.message',
					) ,
					'Attachment'
				) ,
				'Property' => array(
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.email',
						)
					) ,
					'fields' => array(
						'Property.id',
						'Property.created',
						'Property.user_id',
					)
				)
			) ,
			'recursive' => 2,
		));
		if (empty($propertyOrder)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$this->pageTitle = __l('Status of your booking No') . '#' . $propertyOrder['PropertyUser']['id'];
		if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print') {
			$this->pageTitle = __l('Booking') . '# ' . $propertyOrder['PropertyUser']['id'];
			$this->layout = 'print';
		}
		$this->set(compact('propertyOrder', 'relatedMessages'));
	}
	public function manage()
	{
		$conditions = array();
		if (!empty($this->request->data)) {
			$is_sucess = false;
			$conditions['PropertyUser.id'] = $this->request->data['PropertyUser']['id'];
			$order = $this->PropertyUser->find('first', array(
				'conditions' => $conditions,
				'contain' => array(
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.email',
						) ,
					) ,
					'OwnerUser' => array(
						'fields' => array(
							'OwnerUser.id',
							'OwnerUser.username',
							'OwnerUser.email',
						) ,
					) ,
					'Property' => array(
						'fields' => array(
							'Property.id',
							'Property.title',
							'Property.slug',
						) ,
						'PropertyType'
					) ,
				) ,
				'recursive' => 2
			));
		} else {
			$conditions['PropertyUser.id'] = $this->request->params['named']['property_user_id'];
			$this->request->data['PropertyUser']['id'] = $this->request->params['named']['property_user_id'];
		}
		$order = $this->PropertyUser->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				'User' => array(
					'fields' => array(
						'User.id',
						'User.username',
					)
				) ,
				'Property' => array(
					'fields' => array(
						'Property.id',
						'Property.title',
						'Property.slug',
						'Property.user_id',
						'Property.price_per_night',
						'Property.property_type_id',
					) ,
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
						)
					) ,
				) ,
				'PropertyUserStatus'
			) ,
			'recursive' => 2
		));
		if (empty($order)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$reports = array(
			2 => 'Dispute'
		);
		$this->request->data['PropertyUser']['report_id'] = 0;
		$this->set('reports', $reports);
		$this->set('order', $order);
	}
	public function update_order($property_user_id, $order, $from = null)
	{
		$propertyUser = $this->PropertyUser->find('first', array(
			'conditions' => array(
				'PropertyUser.id' => $property_user_id
			) ,
			'recursive' => -1
		));
		if (empty($propertyUser)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		if ($order == 'accept') {
			$other_accepted_count = $this->PropertyUser->find('count', array(
				'conditions' => array(
					'PropertyUser.id !=' => $propertyUser['PropertyUser']['id'],
					'PropertyUser.property_id' => $propertyUser['PropertyUser']['property_id'],
					'PropertyUser.property_user_status_id' => array(
						ConstPropertyUserStatus::Confirmed,
						ConstPropertyUserStatus::Arrived
					) ,
					'PropertyUser.checkin <= ' => $propertyUser['PropertyUser']['checkout'],
					'PropertyUser.checkout >= ' => $propertyUser['PropertyUser']['checkin'],
				) ,
				'recursive' => -1
			));
			if (!empty($other_accepted_count)) {
				$this->Session->setFlash(__l('Already an order was accepted within this check in and check out date. So please reject this order.') , 'default', null, 'error');
				$this->redirect(array(
					'controller' => 'property_users',
					'action' => 'index',
					'type' => 'myworks',
					'status' => 'waiting_for_acceptance'
				));
			}
		}
		$success = '0';
		App::import('Model', 'Payment');
		$this->Payment = new Payment();	
		if (!empty($order)) {
			$processed_order = array();
			if($order == 'accept') {
				$processed_order['redirect'] = 'myworks';
				$processed_order['flash_message'] = __l('You have successfully accepted the booking request');
				$processed_order['ajax_repsonse'] = 'accepted';
				$processed_order['status'] = 'confirmed';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Confirmed);
			} else if($order == 'cancel') {
				$processed_order['redirect'] = 'mytours';
				$processed_order['flash_message'] = __l('You have successfully canceled your booking.');
				$processed_order['ajax_repsonse'] = 'canceled';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Canceled);
			} else if($order == 'arrived') {
				$processed_order['redirect'] = 'myworks';
				$processed_order['flash_message'] = __l('You have successfully changed the status to arrived.');
				$processed_order['ajax_repsonse'] = 'canceled';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Arrived);
			} else if($order == 'reject') {
				$processed_order['redirect'] = 'myworks';
				$processed_order['flash_message'] = __l('You have rejected the booking successfully');
				$processed_order['ajax_repsonse'] = 'rejected';
				$processed_order['status'] = 'rejected';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Rejected);
			} else if($order == 'review') {
				$processed_order['redirect'] = 'myworks';
				$processed_order['flash_message'] = __l('Your work has been delivered successfully!');
				$processed_order['ajax_repsonse'] = 'waiting_for_Review';
				$processed_order['status'] = 'waiting_for_Review';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::WaitingforReview);
			} else if($order == 'completed') {
				$processed_order['redirect'] = 'mytours';
				$processed_order['flash_message'] = __l('You have completed the booking, please give review and rate the property!');
				$processed_order['ajax_repsonse'] = 'completed';
				$processed_order['status'] = 'completed';
				$this->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Completed);
			}
			if (!empty($processed_order['redirect'])) {
				// <-- For iPhone App code
				if ($this->RequestHandler->prefers('json')) {
					$response = Cms::dispatchEvent('Controller.PropertyUser.UpdateOrder', $this, array(
						'results' => 1
					));
				} // For iPhone App code -->
				else {
					if (!empty($processed_order['flash_message'])) {
						$this->Session->setFlash($processed_order['flash_message'], 'default', null, 'success');
					}
					if ($this->RequestHandler->isAjax() && ($processed_order['ajax_repsonse'] == 'failed' || $this->request->params['named']['view_type'] == 'activities')) {
						$ajax_url = Router::url(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $processed_order['order_id'],
							'type' => $processed_order['redirect'],
							'status' => !empty($processed_order['status']) ? $processed_order['status'] : __l('all') ,
						) , true);
						$success_msg = 'redirect*' . $ajax_url;
						echo $success_msg;
						exit;
					}
					if ($this->RequestHandler->isAjax() && $processed_order['ajax_repsonse'] != 'failed') {
						echo $processed_order['ajax_repsonse'];
						exit;
					}
					$this->redirect(array(
						'action' => 'index',
						'type' => $processed_order['redirect'],
						'status' => !empty($processed_order['status']) ? $processed_order['status'] : __l('all')
					));
				}
			} else {
				// <-- For iPhone App code
				if ($this->RequestHandler->prefers('json')) {
					$response = Cms::dispatchEvent('Controller.PropertyUser.UpdateOrder', $this, array(
						'results' => 0
					));
				} // For iPhone App code -->
				else {
					if (!empty($processed_order['flash_message'])) {
						$this->Session->setFlash($processed_order['flash_message'], 'default', null, 'error');
					}
					$this->redirect(array(
						'action' => 'index',
						'type' => $processed_order['redirect'],
						'status' => !empty($processed_order['status']) ? $processed_order['status'] : __l('all')
					));
				}
			}
		} else {
			$this->redirect(array(
				'controller' => 'properties',
				'action' => 'index',
			));
		}
	}
	public function process_checkinout()
	{
		$this->PropertyUser->set($this->request->data);
		if (!empty($this->request->data)) {
			$property_user = $this->PropertyUser->find('first', array(
				'conditions' => array(
					'PropertyUser.id' => $this->request->data['PropertyUser']['order_id']
				) ,
				'recursive' => -1
			));
			if (empty($property_user)) {
				throw new NotFoundException(__l('Invalid request'));
			}
			$this->PropertyUser->set($this->request->data);
            if ($this->PropertyUser->validates()) {
				$data = array();
				if (isset($this->request->data['PropertyUser']['via'])) {
					$data['via'] = $this->request->data['PropertyUser']['via'];
				}
				$str = $this->request->data['PropertyUser']['checkinout']['year'] . '-' . $this->request->data['PropertyUser']['checkinout']['month'] . '-' . $this->request->data['PropertyUser']['checkinout']['day'] . ' ' . (!empty($this->request->data['PropertyUser']['checkinout']['hour']) ? $this->request->data['PropertyUser']['checkinout']['hour'] : '') . (!empty($this->request->data['PropertyUser']['checkinout']['min']) ? ':' . $this->request->data['PropertyUser']['checkinout']['min'] : '') . ' ' . (!empty($this->request->data['PropertyUser']['checkinout']['meridian']) ? $this->request->data['PropertyUser']['checkinout']['meridian'] : '');
				$data['checkinout'] = _formatDate('Y-m-d H:i:s', $str, true);
				if (!empty($this->request->data['PropertyUser']['p_action']) && $this->request->data['PropertyUser']['p_action'] == 'check_in' && in_array($property_user['PropertyUser']['property_user_status_id'], array(ConstPropertyUserStatus::Confirmed, ConstPropertyUserStatus::Arrived))) {
					$this->PropertyUser->updateStatus($this->request->data['PropertyUser']['order_id'], ConstPropertyUserStatus::Arrived, '', $data);
				}
				if (!empty($this->request->data['PropertyUser']['p_action']) && $this->request->data['PropertyUser']['p_action'] == 'check_out' && in_array($property_user['PropertyUser']['property_user_status_id'], array(ConstPropertyUserStatus::WaitingforReview, ConstPropertyUserStatus::Arrived, ConstPropertyUserStatus::PaymentCleared))) {
					if($property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived || $property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
						$this->PropertyUser->updateStatus($this->request->data['PropertyUser']['order_id'], ConstPropertyUserStatus::WaitingforReview, '', $data);
					} elseif($property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview ) {
						$this->PropertyUser->updateStatus($this->request->data['PropertyUser']['order_id'], ConstPropertyUserStatus::Completed, '', $data);
					}
				}
				// Save Private Note //
				if (!empty($this->request->data['PropertyUser']['private_note'])) {
					$message_sender_user_id = $this->Auth->user('id');
					$subject = 'Private note';
					$message = $this->request->data['PropertyUser']['private_note'];
					$property_id = $property_user['PropertyUser']['property_id'];
					$order_id = $property_user['PropertyUser']['id'];
					$message_id = $this->PropertyUser->Message->sendNotifications($message_sender_user_id, $subject, $message, $order_id, $is_review = 0, $property_id, ConstPropertyUserStatus::PrivateConversation);
				}
				$this->Session->setFlash(__l('Status changed successfully') , 'default', null, 'success');
				if ($this->RequestHandler->isAjax()) {
					if (isset($this->request->data['PropertyUser']['via']) && $this->request->data['PropertyUser']['via'] == 'ticket') {
						$ajax_url = Router::url(array(
							'controller' => 'property_users',
							'action' => 'check_qr',
							$property_user['PropertyUser']['top_code'],
							$property_user['PropertyUser']['bottum_code'],
							'admin' => false,
						) , true);
					} else {
						$ajax_url = Router::url(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $property_user['PropertyUser']['id'],
							'admin' => false,
						) , true);
					}
					$success_msg = 'redirect*' . $ajax_url;
					echo $success_msg;
					exit;
				} else {
					if (isset($this->request->data['PropertyUser']['via']) && $this->request->data['PropertyUser']['via'] == 'ticket') {
						$ajax_url = Router::url(array(
							'controller' => 'property_users',
							'action' => 'check_qr',
							$property_user['PropertyUser']['top_code'],
							$property_user['PropertyUser']['bottum_code'],
							'admin' => false,
						) , true);
						$this->redirect(array(
							'controller' => 'property_users',
							'action' => 'check_qr',
							$property_user['PropertyUser']['top_code'],
							$property_user['PropertyUser']['bottum_code'],
							'admin' => false,
						));
					} else {
						$this->redirect(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $property_user['PropertyUser']['id'],
							'admin' => false,
						));
					}
				}
			} else {
				if ($property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
					$this->Session->setFlash(__l('Selected check in date should be after or on  the booked check in date and before or on the booked checkout date') , 'default', null, 'error');
					
				}
				if ($property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview || $property_user['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
					$this->Session->setFlash(__l('Selected check out date should be after or on the booked check out date') , 'default', null, 'error');
				}
				$this->redirect(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $property_user['PropertyUser']['id'],
							'admin' => false,
						));
			}
		}
		if (empty($this->request->data)) {
			if (!empty($this->request->params['named']['order_id'])) {
				$propertyUser = $this->PropertyUser->find('first', array(
					'conditions' => array(
						'PropertyUser.id' => $this->request->params['named']['order_id']
					) ,
					'recursive' => -1
				));
				if (!empty($propertyUser)) {
					if ($this->Auth->user('id') == $propertyUser['PropertyUser']['owner_user_id']) {
						$message = !empty($propertyUser['PropertyUser']['host_private_note']) ? $propertyUser['PropertyUser']['host_private_note'] : '';
					} elseif ($this->Auth->user('id') == $propertyUser['PropertyUser']['user_id']) {
						$message = !empty($propertyUser['PropertyUser']['traveler_private_note']) ? $propertyUser['PropertyUser']['traveler_private_note'] : '';
					}
					$this->request->data['PropertyUser']['private_note'] = $message;
				}
			}
			$this->request->data['PropertyUser']['checkinout'] = date('Y-m-d H:i:s');
			if (!empty($this->request->params['named']['via'])) {
				$this->request->data['PropertyUser']['via'] = $this->request->params['named']['via'];
			}
		}
	}
	public function check_qr()
	{
		$top_code = $this->request->params['pass'][0];
		$bottum_code = $this->request->params['pass'][1];
		if (is_null($top_code) || is_null($bottum_code)) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$this->pageTitle = __l('Property user ticket');
		$conditions['PropertyUser.top_code'] = $top_code;
		$conditions['PropertyUser.bottum_code'] = $bottum_code;
		$propertyUser = $this->PropertyUser->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				'User',
				'Property',
				'PropertyUserStatus',
			) ,
			'recursive' => 3
		));
		if (empty($propertyUser)) {
			$this->Session->setFlash(__l('Invalid ticket') , 'default', null, 'error');
			$this->redirect(Router::url('/', true));
		}
		if ($this->Auth->user('id') != $propertyUser['PropertyUser']['owner_user_id']) {
			$this->Session->setFlash(__l('You have no authorized to view this page') , 'default', null, 'error');
			$this->redirect(Router::url('/', true));
		}
		$this->set('propertyUser', $propertyUser);
	}
}
?>