<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\UpdateFormType;
use App\Repository\UserRepository;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{

     /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    public function navBar(UserRepository $repo){
        $users = $this->security->getUser();
        if ($users==null) {
            return $this->render('navbar/_navbar.html.twig');
        }
        else{
            $user = $users->getUserIdentifier();
            $infos = $repo->findOneBy(['email'=>$user]);
            // $ui = $user->getUser();
            return $this->render('navbar/_navbar.html.twig',[
            'infos'=>$infos->getUserInfo(),
        ]);
        }
    }

    /**
     * @Route("/", name="home")
     */
    public function home(AuthenticationUtils $authenticationUtils, UserRepository $repo) : Response
    {   
            return $this->render('accueil/index.html.twig',[
        ]);
        
        
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/update/{id}", name="app_update")
     */
    public function update($id, UserRepository $repo, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        /*$user = $repo->find($id);
        $userInfo = $user->getUserInfo();
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'infos'=>$userInfo,
        ]);*/

        // $user = $repo->find($id);
        $user = $repo->find($id);
        $userInfo = $user->getUserInfo();
        $form = $this->createForm(UpdateFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if($form->get('email')->getData()!=null){
                $user->setEmail($form->get('email')->getData());
            }
            if($form->get('password')->getData()!=null) {
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            if($form->get('avatar')->getData()!=null){
                $userInfo->setAvatar($form->get('avatar')->getData());
            }
            if($form->get('username')->getData()!=null){
                $userInfo->setUsername($form->get('username')->getData());
            }

            $entityManager->persist($user);
            $entityManager->flush();


            /*$userInfo = new UserInfo();
            $userInfo->setUser($user)
                    ->setUsername("username")
                    ->setAvatar("https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png");

            $entityManager->persist($userInfo);
            $entityManager->flush();*/
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('security/update.html.twig', [
            'updateForm' => $form->createView(),
        ]);
    }
}

