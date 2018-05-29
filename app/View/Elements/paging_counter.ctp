<p class="left-mspace no-mar">
<?php
echo $this->Paginator->counter(array(
'format' => __l('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
