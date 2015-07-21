<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('client_homepage', new Route('/hello/{name}', array(
    '_controller' => 'ClientBundle:Default:index',
)));

return $collection;
