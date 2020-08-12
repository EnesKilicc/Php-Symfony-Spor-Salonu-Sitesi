<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Purchase;
use App\Form\Admin\PurchaseType;
use App\Repository\Admin\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/purchase")
 */
class PurchaseController extends AbstractController
{
    /**
     * @Route("/{slug}", name="admin_purchase_index", methods={"GET"})
     */
    public function index(PurchaseRepository $purchaseRepository,$slug): Response
    {
        $purchases = $purchaseRepository->getuserPurchases($slug);
        return $this->render('admin/purchase/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }

    /**
     * @Route("/new", name="admin_purchase_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($purchase);
            $entityManager->flush();

            return $this->redirectToRoute('admin_purchase_index');
        }

        return $this->render('admin/purchase/new.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="admin_purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase): Response
    {
        return $this->render('admin/purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_purchase_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Purchase $purchase): Response
    {
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $status = $form['status']->getData();

            return $this->redirectToRoute('admin_purchase_index',['slug'=>$status]);
        }

        return $this->render('admin/purchase/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_purchase_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Purchase $purchase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_purchase_index');
    }
}
