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
class CronsController extends AppController
{
    public $name = 'Crons';
    public $components = array(
        'Cron',
    );
    public function main()
    {
        $this->Cron->main();
		if (!empty($_GET['r'])) {
			$this->Session->setFlash(__l('Property status updated successfully') , 'default', null, 'success');
			$this->redirect(Router::url(array(
				'controller' => 'pages',
				'action' => 'display',
				'tools',
				'admin' => true
			) , true));
		}
		$this->autoRender = false;
    }
	public function daily()
	{
		$this->Cron->daily();
		if (!empty($_GET['r'])) {
			$this->Session->setFlash(__l('Currency Conversion updated successfully') , 'default', null, 'success');
			$this->redirect(Router::url(array(
				'controller' => 'pages',
				'action' => 'display',
				'tools',
				'admin' => true
			) , true));
		}
		$this->autoRender = false;
	}
	public function encode()
    {
		if (isPluginEnabled('HighPerformance')) {
			App::import('Core', 'ComponentCollection');
			$collection = new ComponentCollection();
			App::import('Component', 'HighPerformance.HighPerformanceCron');
			$this->HighPerformanceCron = new HighPerformanceCronComponent($collection);
			$this->HighPerformanceCron->encode();
			if (!empty($_GET['r'])) {
				$this->Session->setFlash(__l('Encode updated successfully') , 'default', null, 'success');
				$this->redirect(Router::url(array(
					'controller' => 'nodes',
					'action' => 'tools',
					'admin' => true
				) , true));
			}
		}
		$this->autoRender = false;
    }
}
?>