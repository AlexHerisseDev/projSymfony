<?php

namespace App\Controller;

use App\Entity\Lessons;
use App\Entity\UserInfo;
use App\Form\LessonFormType;
use App\Form\UpdateLessonFormType;
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



    /**
     * @Route("/lessons/{id}", name="app_lessonPage")
     */
    public function lessonPage($id, LessonsRepository $repo) : Response
    {
        $lesson = $repo->find($id);
        $user = $this->getUser();
        return $this->render('lessons/lessonPage.html.twig', [
            'lesson'=>$lesson,
            'currentUser'=>$user,
        ]);
    }

    /**
     * @Route("lessons/{id}/add", name="app_addStudenttoLesson")
     */
    public function addStudenttoLesson($id, LessonsRepository $repo, EntityManagerInterface $entityManager) : Response
    {
        $lesson = $repo->find($id);
        $user = $this->getUser();
        $lesson->addLessonsStudent($user);

        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->render('lessons/lessonPage.html.twig', [
            'lesson'=>$lesson,
            'currentUser'=>$user,
        ]);
    }

    /**
     * @Route("lessons/{id}/remove", name="app_removeStudentfromLesson")
     */
    public function removeStudentfromLesson($id, LessonsRepository $repo, EntityManagerInterface $entityManager) : Response
    {
        $lesson = $repo->find($id);
        $user = $this->getUser();
        $lesson->removeLessonsStudent($user);

        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->render('lessons/lessonPage.html.twig', [
            'lesson'=>$lesson,
            'currentUser'=>$user,
        ]);
    }

    /**
     * @Route ("/lessons/{id}/update", name="app_updateLesson")
     */
    public function updateLesson($id ,EntityManagerInterface $entityManager, LessonsRepository $repo, Request $request) : Response
    {
        $lesson = $lessonOld = $repo->find($id);
        $user = $this->getUser();

        $form = $this->createForm(UpdateLessonFormType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form["title"]->getData() == NULL){
                $lesson->setTitle($lessonOld->getTitle());

            }
            if ($form["description"]->getData() == NULL){
                $lesson->setDescription($lessonOld->getDescription());
            }
            if ($form["contactInformation"]->getData() == NULL){
                $lesson->setContactInformation($lessonOld->getContactInformation());
            }
            if ($form["availableDates"]->getData() == NULL){
                $lesson->setAvailableDates($lessonOld->getAvailableDates());
            }
            if ($form["category"]->getData() == NULL){
                $lesson->setCategory($lessonOld->getCategory());
            }

            return $this->redirectToRoute('app_lessonList');
        }
        
        $entityManager->persist($lesson);
        $entityManager->flush();
        
        return $this->render('lessons/updateLesson.html.twig', [
            'UpdateLessonForm' => $form->createView(),
            'lesson'=>$lesson,
            'currentUser'=>$user,
        ]);
    }
}
