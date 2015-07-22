<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('client_homepage', new Route('/', array(
    '_controller' => 'ClientBundle:Default:index',
)));

$collection->add('client_cadastro', new Route('/cadastro', array(
    '_controller' => 'ClientBundle:Default:cadastro',
)));

$collection->add('client_login', new Route('/login', array(
    '_controller' => 'ClientBundle:Default:login',
)));

$collection->add('client_login_exec', new Route('/login/exec', array(
    '_controller' => 'ClientBundle:Default:loginExec',
)));

$collection->add('client_usuarios', new Route('/usuarios', array(
    '_controller' => 'ClientBundle:Default:usuarios',
)));

$collection->add('client_delete', new Route('/delete', array(
    '_controller' => 'ClientBundle:Default:delete',
)));

$collection->add('client_sair', new Route('/sair', array(
    '_controller' => 'ClientBundle:Default:sair',
)));

return $collection;
