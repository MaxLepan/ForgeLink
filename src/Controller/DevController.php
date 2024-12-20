<?php

namespace App\Controller;

use App\Enum\UserRoles;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DevController extends AbstractController
{
    #[Route('/dev/create-users/', name: 'app_dev_create_users')]
    public function index(UserRepository $userRepository): Response
    {
        $users[] = $userRepository->createUser(UserRoles::ROLE_LEAD_DEVELOPER);
        $users[] = $userRepository->createUser(UserRoles::ROLE_DEVELOPER);
        $users[] = $userRepository->createUser(UserRoles::ROLE_LEAD_ENGINEER);
        $users[] = $userRepository->createUser(UserRoles::ROLE_ENGINEER);
        $users[] = $userRepository->createUser(UserRoles::ROLE_LEAD_MANUFACTURER);
        $users[] = $userRepository->createUser(UserRoles::ROLE_MANUFACTURER);

        // dd($users);

        return $this->render('dev/create_users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dev/delete-users', name: 'app_dev_delete_users')]
    public function deleteUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $userRepository->getEntityManager()->remove($user);
        }
        $userRepository->getEntityManager()->flush();

        return $this->redirectToRoute('app_dev_create_users');
    }
}
