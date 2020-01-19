<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeedController
{
    public function index(Request $request): Response
    {
        return new Response('OK', Response::HTTP_OK, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
