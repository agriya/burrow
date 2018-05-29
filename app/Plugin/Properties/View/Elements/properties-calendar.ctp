<?php
    echo $this->requestAction( array('controller' => 'properties', 'action' => 'calendar', 'host', 'property_id' => !empty($property_id) ? $property_id : ''), array('return'));?>