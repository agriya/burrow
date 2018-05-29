<?php
$TransactionCount = $transactions->Transaction->find('count', array(
	'conditions' => $conditions,
	'recursive' => -1,
));
$page = ceil($TransactionCount / 20);
$offset =0;
for($i=1;$i<=$page;$i++) {
if($i!=1){
 $offset=$offset+20;
 }
	$transactions->request->params['named']['page'] = $i;
	$transactions->paginate = array(
		'conditions' => $conditions,
		'contain' => array(
	        'User',
            'TransactionType',
        ) ,
		'offset' => $offset,
		'order' => array(
			'Transaction.id' => 'desc'
		) ,
		'recursive' => 3
	);
	$Transactions = $transactions->paginate();
	if ($Transactions) {
		$data = array();
		foreach($Transactions as $transaction) {
			if ($transaction['TransactionType']['is_credit']) {
				$credit = $transaction['Transaction']['amount'];
				$debit = '--';
			} else {
				$credit = '--';
				$debit = $transaction['Transaction']['amount'];
			}
			$data[]['Transaction'] = array(
				'Date' => $transaction['Transaction']['created'],
				'User' => $transaction['User']['username'],
				'Description' => $transaction['TransactionType']['name'],
				'Credit (' . Configure::read('site.currency') . ')' => $credit,
				'Debit (' . Configure::read('site.currency') . ')' => $debit
			);
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