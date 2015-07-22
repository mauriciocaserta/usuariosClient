<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

    public function indexAction() {
        $mensagem = "";
        return $this->render('ClientBundle:Default:index.html.twig', array('mensagem'=>$mensagem));
    }

    private static function curlExec($link, $data) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));

        $response = curl_exec($ch);

        print_r($response);
        die();
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

}
