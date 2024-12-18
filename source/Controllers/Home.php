<?php

namespace Source\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Source\Core\Controller;

/**
 * Home Controllers
 * @package Source\Controllers
 */
class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function formAjax(Request $request, Response $response)
    {
        if ($this->getServer()->getServerByKey("REQUEST_METHOD") == "POST") {
            $request = $this->getRequests()->configureDataPost()->setRequiredFields([
                "writeName",
                "csrfToken"
            ])->getAllPostData();
            
            $response->getBody()->write(json_encode($request));
            return $response->withStatus(200);
        }

        $response->getBody()->write($this->view->render("form_ajax", []));
        return $response;
    }

    public function form(Request $request, Response $response)
    {
        if ($this->getServer()->getServerByKey("REQUEST_METHOD") == "POST") {
            $request = $this->getRequests()->configureDataPost()->setRequiredFields([
                "writeName",
                "csrfToken"
            ])->getAllPostData();
            
            print_r($request ?? []);
            die;
        }

        $response->getBody()->write($this->view->render("form", []));
        return $response;
    }

    /**
     * Index Home
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write($this->view->render("home", [
            "title" => "Home"
        ]));
        return $response;
    }
}
