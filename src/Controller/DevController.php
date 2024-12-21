<?php

namespace App\Controller;

use App\Entity\Project;
use App\Enum\UserRoles;
use App\Repository\ProjectRepository;
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
        $users[] = $userRepository->createUser(UserRoles::ROLE_PROJECT_MANAGER);

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

    #[Route('/dev/create-projects', name: 'app_dev_create_projects')]
    public function createProject(ProjectRepository $projectRepository): Response
    {
        $project = new Project();
        $project->setTitle('DJI Mavic 3 recon drone with thermals');
        $project->setDescription('A drone that can be used for reconnaissance and surveillance with thermal imaging capabilities');
        
        $users = $projectRepository->getEntityManager()->getRepository('App\Entity\User')->findAll();
        foreach ($users as $user) {
            $project->addTeamMember($user);
        }
        $project = $projectRepository->createProject($project);

        $project2 = new Project();
        $project2->setTitle('Baba Yaga Bomber Drone');
        $project2->setDescription('A drone that can be used for fire support missions. It carries a custom carousel of 6 30mm grenades, themselves modified with 3D printed fins for better aerodynamics');

        $users = $projectRepository->getEntityManager()->getRepository('App\Entity\User')->findAll();
        foreach ($users as $user) {
            $project2->addTeamMember($user);
        }
        $project2 = $projectRepository->createProject($project2);

        return $this->redirectToRoute('app_dashboard_index');
    }

    #[Route('/dev/delete-projects', name: 'app_dev_delete_projects')]
    public function deleteProjects(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        foreach ($projects as $project) {
            $projectRepository->getEntityManager()->remove($project);
        }
        $projectRepository->getEntityManager()->flush();

        return $this->redirectToRoute('app_dev_create_projects');
    }
}
