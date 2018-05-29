<div class="paging dr">
<?php
$class=(!empty($this->request->params['isAjax'])) ? " js-no-pjax" : "" ;
$model=Inflector::classify($this->request->params['controller']);
$named=$this->request->params['named'];
if(!empty($this->Paginator->params['paging'][$model]['nextPage'])){
	$named['page']=$this->Paginator->params['paging'][$model]['page']+1;
	echo $this->Html->meta('canonical',array_merge(array(
	   'controller' => $this->request->params['controller'],
	   'action' => $this->request->params['action'],
		) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'next', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
} 
if(!empty($this->Paginator->params['paging'][$model]['prevPage'])){
	$named['page']=$this->Paginator->params['paging'][$model]['page']-1;
	echo $this->Html->meta('canonical',array_merge(array(
		'controller' => $this->request->params['controller'],
		'action' => $this->request->params['action'],
	) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'prev', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
}
echo $this->Paginator->prev(' ' . __l('Prev') , array(
    'class' => 'prev '.$class,
    'escape' => false
) , null, array(
    'tag' => 'span',
    'escape' => false,
    'class' => 'prev '.$class
)), "\n";
echo $this->Paginator->numbers(array(
    'modulus' => 2,
    'first' => 3,
	'last' => 3,
	'ellipsis' => '<span class="ellipsis">&hellip;.</span>',
    'separator' => " \n",
    'before' => null,
    'after' => null,
    'escape' => false,
	'class' => $class
));
echo $this->Paginator->next(__l('Next') . ' ', array(
    'class' => 'next '.$class,
    'escape' => false
) , null, array(
    'tag' => 'span',
    'escape' => false,
    'class' => 'next '.$class
)), "\n";
?>
</div>
