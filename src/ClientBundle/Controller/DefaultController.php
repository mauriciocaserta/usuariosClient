<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('ClientBundle:Default:index.html.twig', array('name' => $name));
    }

    public function curlAction($link, $data) {

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

            $response = $this->curlAction($link, $data);
        }
        return new JsonResponse($response);
    }
    
}
