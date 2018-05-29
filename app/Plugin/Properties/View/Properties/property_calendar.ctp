<div>
 <?php
echo $this->requestAction(array('controller' => 'properties', 'action' => 'datafeed','method'=>'guest','startdate'=> mktime(0, 0, 0, date('n'), date('1'),date('Y')),'enddate'=>mktime(0, 0, 0, date('n'), date('t'),date('Y')),'property_id'=>$id,'year'=>date('Y'),'month'=>date('m')), array('return')); ?>
</div>