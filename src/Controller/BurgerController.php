<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\BurgerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/burger")
 */
class BurgerController extends AbstractController
{
    /**
     * @Route("/", name="burger_index", methods={"GET"})
     */
    public function index(BurgerRepository $burgerRepository): Response
    {
        return $this->render('burger/index.html.twig', [
            'burgers' => $burgerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="burger_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($burger);
            $entityManager->flush();

            return $this->redirectToRoute('burger_index');
        }

        return $this->render('burger/new.html.twig', [
            'burger' => $burger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="burger_show", methods={"GET"})
     */
    public function show(Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="burger_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Burger $burger): Response
    {
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('burger_index');
        }

        return $this->render('burger/edit.html.twig', [
            'burger' => $burger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="burger_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Burger $burger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($burger);
            $entityManager->flush();
        }

        return $this->redirectToRoute('burger_index');
    }
}
