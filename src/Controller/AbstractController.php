<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    use ContainerAwareTrait;

    protected function sendJSON(array $data, $status = Response::HTTP_OK)
    {
        $text = json_encode($data);

        return new Response($text, $status, [
            'Content-Type' => 'application/json',
        ]);
    }
}
