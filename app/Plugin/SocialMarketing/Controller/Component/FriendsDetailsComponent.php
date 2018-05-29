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
class FriendsDetailsComponent extends Component
{
    public function startup(Controller $controller)
    {
        App::import('Model', 'SocialMarketing.UserFollower');
        $this->UserFollower = new UserFollower();
        if (!empty($_SESSION['Auth']['User']['id'])) {
			$userFollowers = $this->UserFollower->find('list', array(
				'conditions' => array(
					'UserFollower.user_id' => $_SESSION['Auth']['User']['id']
				) ,
				'fields' => array(
					'UserFollower.id',
					'UserFollower.followed_user_id',
				),
				'recursive' => -1,
			));
			Configure::write('site.friend_ids', $userFollowers);
		}
    }
}
