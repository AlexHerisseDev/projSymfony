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
     * @Route("/lessons/{displayPerPage}/{page}", name="app_lessonsPaginated")
     */
    public function lessonListPaginated($displayPerPage, $page, LessonsRepository $repo): Response
    {
        $lessons = $repo->findall();
        $nbLessons = count($lessons);
        $nbPages=(int) ($nbLessons/$displayPerPage);

        return $this->render('lessons/lessonListPaginated.html.twig', [
            'lessons'=>$lessons,
            'page'=>$page,
            'nbLessons'=>$nbLessons,
            'nbPages'=>$nbPages,
            'currentDisplayPerPage'=>$displayPerPage
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
     * @Route("/lesson/lesson/{id}", name="app_lessonPage")
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
     * @Route("lessons/lesson/{id}/add", name="app_addStudenttoLesson")
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
     * @Route("lessons/lesson/{id}/remove", name="app_removeStudentfromLesson")
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
     * @Route("/lessons/lesson/{id}/update", name="app_updateLesson")
     */
    public function updateLesson($id ,EntityManagerInterface $entityManager, LessonsRepository $repo, Request $request) : Response
    {
        $lesson = $lessonOld = $repo->find($id);
        $user = $this->getUser();

        $form = $this->createForm(UpdateLessonFormType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('app_lessonList');
        }
        
        return $this->render('lessons/updateLesson.html.twig', [
            'UpdateLessonForm' => $form->createView(),
            'lesson'=>$lesson,
            'currentUser'=>$user,
        ]);
    }

    /**
     * @Route("/lessons/search", name="app_lessonSearch")
     */
    public function lessonSearch(LessonsRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {        
        $req = $request->query->all();
        $query = $entityManager->createQuery(
            "SELECT u
            FROM App\Entity\Lessons u
            WHERE u.title = :request")
            ->setParameter('request',$req);
        
        
        $result = $query->getResult();
        $user = $this->getUser();
        return $this->render('lessons/lessonList.html.twig',[
            'user' => $user,
            'lessons' => $result,
        ]);
    }
    
    public function lessonCard(LessonsRepository $repo)
    {
        $lessons = $repo->findall();

        return $this->render('lessonCard/_lessonCard.html.twig', [
            'lessons'=>$lessons,
        ]);
    }
}
