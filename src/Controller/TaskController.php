<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_index", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="task_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if( null === $task->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())
            || null !== $task->getUser() && $this->getUser() === $task->getUser() )
        {
            $form = $this->createForm(TaskType::class, $task);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addFlash('success', 'La tâche a bien été modifiée.');

                return $this->redirectToRoute('task_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('task/edit.html.twig', [
                'task' => $task,
                'form' => $form,
            ]);
        }
        $this->addFlash('error', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
        return $this->redirectToRoute('task_index');
    }

     /**
     * @Route("/task/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, EntityManagerInterface $entityManager)
    {
        $task->toggle(!$task->isDone());
        $entityManager->flush();

        if($task->isDone()) $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        else $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non faite.', $task->getTitle()));
        return $this->redirectToRoute('task_index');
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"POST"})
     */
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        //twig not display button for no athorization but for more security
        // controller make a additional verification 
        if( null === $task->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())
            || null !== $task->getUser() && $this->getUser() === $task->getUser() )
        {
            // if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
                $entityManager->remove($task);
                $entityManager->flush();
                $this->addFlash('success', 'La tâche a bien été supprimée.');
            // }   
        }
        else
        {
            $this->addFlash('error', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
        }
        return $this->redirectToRoute('task_index', [], Response::HTTP_SEE_OTHER);
    }
}
