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
    /** @var array Path da View */
    private array $path = [];

    public function __construct()
    {
        $this->path = ["example", sprintf("%s/%s", CONF_VIEW_PATH, CONF_VIEW_THEME)];
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

        return $this->view($response, $this->path, "example::form_ajax");
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

        return $this->view($response, $this->path, "example::form");
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
        return $this->view($response, $this->path, "example::home", ["title" => "Home"]);
    }
}
