<?php

Director::addRules(50, array(
	Payment_Controller::$URLSegment . '/$Action/$ID' => 'Payment_Controller',
));