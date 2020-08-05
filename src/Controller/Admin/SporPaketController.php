<?php

namespace App\Controller\Admin;

use App\Entity\SporPaket;
use App\Form\SporPaketType;
use App\Repository\SporPaketRepository;
use phpDocumentor\Reflection\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/spor_paket")
 */
class SporPaketController extends AbstractController
{
    /**
     * @Route("/", name="spor_paket_index", methods={"GET"})
     */
    public function index(SporPaketRepository $sporPaketRepository): Response
    {
        return $this->render('admin/spor_paket/index.html.twig', [
            'spor_pakets' => $sporPaketRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="spor_paket_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sporPaket = new SporPaket();
        $form = $this->createForm(SporPaketType::class, $sporPaket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var file $file */
            $file = $form['image']->getData();
            if($file){
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                }
                $sporPaket->setImage($fileName);
            }
            $entityManager->persist($sporPaket);
            $entityManager->flush();

            return $this->redirectToRoute('spor_paket_index');
        }

        return $this->render('admin/spor_paket/new.html.twig', [
            'spor_paket' => $sporPaket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spor_paket_show", methods={"GET"})
     */
    public function show(SporPaket $sporPaket): Response
    {
        return $this->render('admin/spor_paket/show.html.twig', [
            'spor_paket' => $sporPaket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spor_paket_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SporPaket $sporPaket): Response
    {

        $form = $this->createForm(SporPaketType::class, $sporPaket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var file $file */
            $file = $form['image']->getData();
            if($file){
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                    echo $e . "hata";
                }
                $sporPaket->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spor_paket_index');
        }

        return $this->render('admin/spor_paket/edit.html.twig', [
            'spor_paket' => $sporPaket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(){
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="spor_paket_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SporPaket $sporPaket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sporPaket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sporPaket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spor_paket_index');
    }
}
