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
class PaymentGatewaysController extends AppController
{
    public $name = 'PaymentGateways';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'PaymentGateway.makeActive',
            'PaymentGateway.makeInactive',
            'PaymentGateway.makeTest',
            'PaymentGateway.makeLive',
            'PaymentGateway.makeDelete',
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Payment Gateways');
        $this->_redirectPOST2Named(array(
            'filter',
            'keywords'
        ));
        $conditions = array();
        if (!empty($this->request->params['named'])) {
            $this->request->data['PaymentGateway'] = array(
                'filter' => (isset($this->request->params['named']['filter'])) ? $this->request->params['named']['filter'] : '',
                'keywords' => (isset($this->request->params['named']['keywords'])) ? $this->request->params['named']['keywords'] : ''
            );
        }
        if (!empty($this->request->data['PaymentGateway']['filter'])) {
            if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Active) {
                $conditions['PaymentGateway.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Inactive) {
                $conditions['PaymentGateway.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::TestMode) {
                $conditions['PaymentGateway.is_test_mode'] = 1;
                $this->pageTitle.= __l(' - Test Mode ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::LiveMode) {
                $conditions['PaymentGateway.is_test_mode'] = 0;
                $this->pageTitle.= __l(' - Live Mode ');
            }
        }
        if (!empty($this->request->data['PaymentGateway']['keywords'])) {
            $conditions = array(
                'OR' => array(
                    'PaymentGateway.name LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                    'PaymentGateway.description LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                )
            );
        }
		if (!isPluginEnabled('Sudopay')) {
			$conditions['PaymentGateway.id != '] = ConstPaymentGateways::SudoPay;
		}
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PaymentGateway.id' => 'desc'
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.name',
                        'PaymentGatewaySetting.test_mode_value',
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        );
        $this->set('paymentGateways', $this->paginate());
        $isFilterOptions = $this->PaymentGateway->isFilterOptions;
        $this->set(compact('isFilterOptions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Payment Gateway');
        if (!empty($this->request->data)) {
            $this->PaymentGateway->create();
            if ($this->PaymentGateway->save($this->request->data)) {
                $this->Session->setFlash(__l('Payment Gateway has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Payment Gateway could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Payment Gateway');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		if (isPluginEnabled('Sudopay') && $id == ConstPaymentGateways::SudoPay) {
            App::import('Model', 'Sudopay.Sudopay');
			$this->Sudopay = new Sudopay();
            $SudoPayGatewaySettings = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set(compact('SudoPayGatewaySettings', 'id'));
        }
        if (!empty($this->request->data)) {
			$this->request->data['PaymentGateway']['is_test_mode'] = empty($this->request->data['PaymentGateway']['is_live_mode']) ? 1 : 0;
            if ($this->PaymentGateway->save($this->request->data)) {
                if (!empty($this->request->data['PaymentGatewaySetting'])) {
                    foreach($this->request->data['PaymentGatewaySetting'] as $key => $value) {
						$value['test_mode_value'] = !empty($value['test_mode_value']) ? trim($value['test_mode_value']) : '';
                        $value['live_mode_value'] = !empty($value['live_mode_value']) ? $value['live_mode_value'] : '';
                        $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                            'PaymentGatewaySetting.test_mode_value' => '\'' . trim($value['test_mode_value']) . '\'',
                            'PaymentGatewaySetting.live_mode_value' => '\'' . trim($value['live_mode_value']) . '\''
                        ) , array(
                            'PaymentGatewaySetting.id' => $key
                        ));
                    }
                }
                $this->Session->setFlash(__l('Payment Gateway has been updated') , 'default', null, 'success');
				if (isPluginEnabled('Sudopay') && $this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay) {
                    $this->redirect(array(
                        'controller' => 'sudopays',
                        'action' => 'synchronize',
                        'admin' => true
                    ));
                }
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Payment Gateway could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PaymentGateway->read(null, $id);
			$this->request->data['PaymentGateway']['is_live_mode'] = empty($this->request->data['PaymentGateway']['is_test_mode']) ? 1 : 0;
            unset($this->request->data['PaymentGatewaySetting']);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $paymentGatewaySettings = $this->PaymentGateway->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => $id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'asc'
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->request->data['PaymentGatewaySetting']) && !empty($paymentGatewaySettings)) {
            foreach($paymentGatewaySettings as $key => $paymentGatewaySetting) {
                $paymentGatewaySettings[$key]['PaymentGatewaySetting']['value'] = $this->request->data['PaymentGatewaySetting'][$paymentGatewaySetting['PaymentGatewaySetting']['id']]['value'];
            }
        }
        $this->set(compact('paymentGatewaySettings'));
        $this->pageTitle.= ' - ' . $this->request->data['PaymentGateway']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PaymentGateway->delete($id)) {
            $this->Session->setFlash(__l('Payment Gateway deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update_status($id = null, $actionId = null)
    {
        if (is_null($id) || is_null($actionId)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$paymentGateways = array(
			ConstPaymentGateways::SudoPay => 'Sudopay',
            ConstPaymentGateways::Wallet => 'Wallet',
        );
        $toggle = empty($this->request->params['named']['toggle']) ? 0 : 1;
        switch ($actionId) {
            case ConstMoreAction::Active:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_active' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
				$this->Cms = new CmsPlugin();
                $this->Cms->setController($this);
                $plugin = Inflector::camelize(strtolower($paymentGateways[$id]));
                if ($this->Cms->pluginIsActive($plugin)) {
                    $this->Cms->removePluginBootstrap($plugin);
                } else {
                    $this->Cms->addPluginBootstrap($plugin);
                }
                break;

            case ConstMoreAction::TestMode:
                $newToggle = empty($toggle) ? 1 : 0;
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_test_mode' => $newToggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstMoreAction::MassPay:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_mass_pay_enabled' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstMoreAction::PropertyListing:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_property_listing_fee'
                ));
                break;

            case ConstMoreAction::PropertyVerification:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_property_verified_fee'
                ));
                break;

            case ConstMoreAction::AddWallet:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_add_to_wallet'
                ));
                break;

            case ConstMoreAction::PropertyBooking:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_book_a_property'
                ));
                break;
			 case ConstMoreAction::SignupFee:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_signup_fee'
                ));
                break;
        }
		$this->set('id', $id);
        $this->set('actionId', $actionId);
        $this->set('toggle', $toggle);
    }
}
?>