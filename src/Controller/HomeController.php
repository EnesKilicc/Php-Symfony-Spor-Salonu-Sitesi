<?php

namespace App\Controller;

use App\Entity\Admin\Messages;
use App\Form\Admin\MessagesType;
use App\Repository\SettingRepository;
use App\Repository\SporPaketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository,SporPaketRepository $paketRepository)
    {
        $setting = $settingRepository->findAll();
        $slider = $paketRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'setting' => $setting,
            'slider' => $slider,
        ]);
    }

    /**
     * @Route("/about",name="home_about")
     */
    public function about(SettingRepository $settingRepository): Response
    {
        $setting = $settingRepository->findAll();
        return $this->render('home/aboutus.html.twig', [
            'setting' =>$setting
        ]);
    }
    /**
     * @Route("/contact",name="home_contact",  methods={"GET","POST"})
     */
    public function contact(SettingRepository $settingRepository, Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');


        if ($form->isSubmitted()) {
            if($this->isCsrfTokenValid('form-message',$submittedToken)){
            $entityManager = $this->getDoctrine()->getManager();
            $message->setStatus('New');
            $message->setIp($_SERVER['REMOTE_ADDR']);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success','Mesajınız başarıyla gonderildi');

            return $this->redirectToRoute('home_contact');
            }

        }
        $setting = $settingRepository->findAll();
        return $this->render('home/contact.html.twig', [
            'setting' =>$setting,
            'form' => $form->createView(),
        ]);
    }


}
