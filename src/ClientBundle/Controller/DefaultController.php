<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller {

    public function indexAction() {
        $session = $this->getRequest()->getSession();

        if ($session->has('usuario') == null) {
            return new RedirectResponse($this->generateUrl('client_login'));
        } else {
            return $this->render('ClientBundle:Default:index.html.twig', array('session' => $session));
        }
    }

    private static function curlExec($link, $data) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));

        $response = curl_exec($ch);

        return $response;
    }

    public function cadastroAction() {

        $request = $this->getRequest();

        $nome = $request->request->get("nome");
        $senha = $request->request->get("senha");

        if (!empty($nome) && !empty($senha)) {
            $link = 'http://app.server/cadastro';

            $data = array(
                'nome' => $nome,
                'senha' => $senha
            );
            $retorno = true;

            $response = self::curlExec($link, $data);
        }
        return new JsonResponse($response);
    }

    public function deleteAction() {
        $request = $this->getRequest();

        $id = $request->get('id');

        $data = array(
            'id' => $id
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://app.server/delete');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        $response = json_decode($response);

        return new JsonResponse($response);
    }

    public function usuariosAction() {

        $session = $this->getRequest()->getSession();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://app.server/usuarios');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $response = curl_exec($ch);

        if ($session->has('usuario') == null) {
            return new RedirectResponse($this->generateUrl('client_login'));
        } else {
            return $this->render('ClientBundle:Default:usuarios.html.twig', array('retorno' => json_decode($response)));
        }
    }

    public function loginAction() {
        return $this->render('ClientBundle:Default:login.html.twig', array('mensagem' => ''));
    }

    public function loginExecAction() {
        $session = $this->getRequest()->getSession();

        $request = $this->getRequest();

        $nome = $request->request->get('nome');
        $senha = $request->request->get('senha');

        if (!empty($nome) && !empty($senha)) {

            $data = array(
                'nome' => $nome,
                'senha' => $senha
            );

            $link = 'http://app.server/login';
            $response = self::curlExec($link, $data);

            $response = json_decode($response);

            if (!is_null($response) && $response->erro == false) {
                $session->set('usuario', $response->retorno);
            } else {
                $session->set('usuario', null);
            }
        } else {
            
        }
        return new JsonResponse($response);
    }

    public function sairAction() {
        $session = $this->getRequest()->getSession();
        $session->invalidate();
    }

}
