<?php

namespace App\Controller;

use App\Entity\Lessons;
use App\Entity\UserInfo;
use App\Form\LessonFormType;
use App\Repository\LessonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LessonsController extends AbstractController
{
    
    /**
     * @Route("/lessons", name="app_lessonList")
     */
    public function lessonList(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager, LessonsRepository $repo) : Response
    {   
        $user = $this->getUser();
        return $this->render('lessons/lessonList.html.twig',[
            'user' => $user,
            'lessons' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/lessons/new", name="app_newLesson")
     */
    public function newLesson(Request $request, EntityManagerInterface $entityManager) : Response
    {   
        $lesson = new Lessons();
        $form = $this->createForm(LessonFormType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setTeacherId($this->getUser());

            $entityManager->persist($lesson);
            $entityManager->flush();

            return $this->redirectToRoute('app_lessonList');
        }
        return $this->render('lessons/newLesson.html.twig', [
            'LessonForm' => $form->createView(),
        ]);
    }
}
