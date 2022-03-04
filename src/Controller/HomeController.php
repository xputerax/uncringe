<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    protected $templates;
    protected $response;

    public function __construct(\League\Plates\Engine $templates, ResponseInterface $response)
    {
        $this->templates = $templates;
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request)
    {
        $template = $this->templates->make('index');

        $this->response->getBody()->write(
            $template->render());

        return $this->response;
    }
}