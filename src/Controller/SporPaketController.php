<?php

namespace App\Controller;

use App\Entity\SporPaket;
use App\Form\SporPaket1Type;
use App\Repository\SporPaketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/packets")
 */
class SporPaketController extends AbstractController
{
    /**
     * @Route("/", name="user_spor_paket_index", methods={"GET"})
     */
    public function index(SporPaketRepository $sporPaketRepository): Response
    {
        return $this->render('spor_paket/index.html.twig', [
            'spor_pakets' => $sporPaketRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_spor_paket_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sporPaket = new SporPaket();
        $form = $this->createForm(SporPaket1Type::class, $sporPaket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sporPaket);
            $entityManager->flush();

            return $this->redirectToRoute('user_spor_paket_index');
        }

        return $this->render('spor_paket/new.html.twig', [
            'spor_paket' => $sporPaket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_spor_paket_show", methods={"GET"})
     */
    public function show(SporPaket $sporPaket): Response
    {
        return $this->render('spor_paket/show.html.twig', [
            'spor_paket' => $sporPaket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_spor_paket_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SporPaket $sporPaket): Response
    {
        $form = $this->createForm(SporPaket1Type::class, $sporPaket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_spor_paket_index');
        }

        return $this->render('spor_paket/edit.html.twig', [
            'spor_paket' => $sporPaket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_spor_paket_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SporPaket $sporPaket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sporPaket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sporPaket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_spor_paket_index');
    }
}
