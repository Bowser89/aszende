<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\UserFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    public function __construct(
        private readonly UserFetcher $userFetcher,
    ) {
    }

    /**
     * @Route("/aszende/users", name="get_users", methods={"GET"})
     */
    public function getUsers(): JsonResponse
    {
        try {
            $users = $this->userFetcher->getUsers();

            return new JsonResponse($users, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
