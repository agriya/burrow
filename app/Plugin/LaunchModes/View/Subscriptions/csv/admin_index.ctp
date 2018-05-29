<?php
$SubscriptionCount = $subscription->Subscription->find('count', array(
  'conditions' => $conditions,
  'recursive' => -1,
));
$page = ceil($SubscriptionCount / 20);
for($i=1;$i<=$page;$i++) {
  $subscription->request->params['named']['page'] = $i;
  $subscription->paginate = array(
    'conditions' => $conditions,
    'order' => array(
      'Subscription.id' => 'desc'
    ) ,
    'recursive' => 0
  );
  $Subscriptions = $subscription->paginate();
  if (!empty($Subscriptions)) {
    $data = array();
    foreach($Subscriptions as $key => $Subscription) {
	if($this->request->params['named']['filter_id'] ==  ConstMoreAction::PrelaunchSubscribed){
      $data[]['Subscription'] = array(
      __l('Email') => $Subscription['Subscription']['email'],
	  __l('Invitation Sent') => ($Subscription['Subscription']['is_sent_private_beta_mail']==1)?"Yes":"No",
	  __l('Subscribed On') => $Subscription['Subscription']['created'],
	  __l('IP') => $Subscription['Ip']['ip'],	 
        );
    }
	else if($this->request->params['named']['filter_id'] ==  ConstMoreAction::PrivateBetaSubscribed){
	  $data[]['Subscription'] = array(
      __l('Email') => $Subscription['Subscription']['email'], 
	  __l('Registered') => ($Subscription['Subscription']['is_sent_private_beta_mail']==1)?"Yes":"No",
	  __l('Registration From Friends Invite') => ($Subscription['Subscription']['is_invite']==1)?"Yes":"No",
	  __l('Invited Friends Count') => ($Subscription['User']['invite_count'] == null)?'0':$Subscription['User']['invite_count'],
	  __l('IP') => $Subscription['Ip']['ip'],
	  __l('Created') => $Subscription['Subscription']['created'],
        );
    }
	}
    if ($i == 1) {
      $this->Csv->addGrid($data);
    } else {
      $this->Csv->addGrid($data, false);
    }
  }
}
echo $this->Csv->render(true);
?>