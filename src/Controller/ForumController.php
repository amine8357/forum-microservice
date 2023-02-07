<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ForumRepository;

class ForumController extends AbstractController
{

 
    /**
     * @Route("/forum", name="forum_index", methods={"GET"})
     */
    public function index(ForumRepository $forumRepository): Response
    {
        $forums = $forumRepository->findAll();

        return $this->render('forum/index.html.twig', [
            'forums' => $forum,
        ]);
    }

    /**
     * @Route("/forum/new", name="forum_new", methods={"GET","POST"})
     */
    public function new(): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forum);
            $entityManager->flush();

            return $this->redirectToRoute('forum_index');
        }

        return $this->render('forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/api/forum", name="get_forum_list", methods={"GET"})
     */
    public function getForumList()
    {
        // Code to retrieve the list of forums
        // This can be done by fetching data from a database or API

        $forumsList = [
            [
                'id' => 1,
                'name' => 'Forum 1',
                'description' => 'This is the first forum',
                'created_at' => '2022-01-01'
            ],
            [
                'id' => 2,
                'name' => 'Forum 2',
                'description' => 'This is the second forum',
                'created_at' => '2022-02-01'
            ],
            [
                'id' => 3,
                'name' => 'Forum 3',
                'description' => 'This is the third forum',
                'created_at' => '2022-03-01'
            ],
        ];

        return new JsonResponse($forumList);
    }

    /**
     * @Route("/api/forum/{id}", name="get_forum_by_id", methods={"GET"})
     */
    public function getForumById($id)
    {
        // Code to retrieve a specific forum
        // This can be done by fetching data from a database or API

        // For this example, let's return a dummy forum
        $forum = [
            'id' => $id,
            'name' => 'Forum '.$id,
            'description' => 'This is the forum with id '.$id,
            'created_at' => '2022-01-01'
        ];

        return new JsonResponse($forum);
    }

    /**
     * @Route("/api/forum", name="create_forum", methods={"POST"})
     */
    public function createForum(Request $request)
    {
        // Code to create a new forum
        // This can be done by saving data to a database or sending data to an API

        // For this example, let's assume the new forum data is in the request body
        $forumData = json_decode($request->getContent(), true);

        // For demonstration purposes, let's return the same data with a new id
        $forumData['id'] = 4;
        return new JsonResponse($forumData);
    }
    
    /**
     * @Route("/api/forum/{id}", name="update_forum", methods={"PUT"})
     */
    public function updateForum($id, Request $request)
    {
        // Code to update an existing forum
        // You may persist data to a database or an external API
        $forumData = json_decode($request->getContent(), true);
        $forum = ['id' => $id, 'name' => $forumData['name']];
        
        return new JsonResponse(['data' => $forum]);
    }

    /**
     * @Route("/api/forum/{id}", name="delete_forum", methods={"DELETE"})
     */
    public function deleteForum($id)
    {
        // Code to delete a forum
        // You may delete data from a database or an external API
        return new JsonResponse(['message' => 'Forum deleted']);
    }
}
