<?php

namespace App\Controller;

use App\Entity\Admin\Messages;
use App\Form\Admin\MessagesType;
use App\Repository\SettingRepository;
use App\Repository\SporPaketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository,SporPaketRepository $paketRepository)
    {
        $setting = $settingRepository->findAll();
        $slider = $paketRepository->findBy([],['title'=>'ASC'],4);
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
        $setting = $settingRepository->findAll();

        if ($form->isSubmitted()) {
            if($this->isCsrfTokenValid('form-message',$submittedToken)){
            $entityManager = $this->getDoctrine()->getManager();
            $message->setStatus('New');
            $message->setIp($_SERVER['REMOTE_ADDR']);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success','Mesajınız başarıyla gonderildi');
                $email = (new Email())
                    ->from($setting[0]->getSmtpEmail())
                    ->to($form['email']->getData())
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Time for Symfony Mailer!')
                    //->text('Sending emails is fun again!')
                    ->html("Dear ".$form['name']->getData()."<br>
                        <p> bu mesaj spor salonumuzdan gonderildi</p>"
                    );
                $transport = new GmailSmtpTransport($setting[0]->getSmtpemail(),$setting[0]->getSmtppassword());
                $mailer = new Mailer($transport);
                $mailer->send($email);

            return $this->redirectToRoute('home_contact');
            }

        }

        return $this->render('home/contact.html.twig', [
            'setting' =>$setting,
            'form' => $form->createView(),
        ]);
    }


}
