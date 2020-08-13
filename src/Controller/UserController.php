<?php

namespace App\Controller;

use App\Entity\Admin\Purchase;
use App\Entity\User;
use App\Form\Admin\PurchaseType;
use App\Form\UserType;
use App\Repository\Admin\PurchaseRepository;
use App\Repository\CategoryRepository;
use App\Repository\SporPaketRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('user/show.html.twig',['category' => $category,]);
    }
    /**
     * @Route("/purchase", name="user_purchase", methods={"GET"})
     */
    public function purchase(CategoryRepository $categoryRepository,PurchaseRepository $purchaseRepository): Response
    {
        $user = $this->getUser();
        //$purchases = $purchaseRepository->findBy(['userid'=>$user->getId()]);
        $purchases=$purchaseRepository->getuserPurchase($user->getId());
        $category = $categoryRepository->findAll();
        return $this->render('user/purchases.html.twig',[
            'category' => $category,
            'purchases'=>$purchases,
        ]);
    }
   /**
     * @Route("/packets", name="user_packets", methods={"GET"})
     */

    public function packets(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('user/packets.html.twig',['category' => $category]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder,CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
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
                $user->setImage($fileName);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'category'=>$category
        ]);
    }
    /**
     * @return string
     */
    private function generateUniqueFileName(){
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user,CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'category'=>$category
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$id, User $user,UserPasswordEncoderInterface $passwordEncoder,CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        $user = $this->getUser();
        if ($user->getId() != $id)
        {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(UserType::class, $user);
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
                }
                $user->setImage($fileName);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'category'=>$category
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user,CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    /**
     * @Route("/purchase/{pid}", name="user_purchase_new", methods={"GET","POST"})
     */
    public function newpurchase(Request $request,$pid,CategoryRepository $categoryRepository,SporPaketRepository $paketRepository): Response
    {
        $duration = $_REQUEST['duration'];

        $paket = $paketRepository->findOneBy(['id'=>$pid]);
        $category = $categoryRepository->findAll();
        $total = $duration * $paket->getFiyat();
        $submittedToken = $request->request->get('token');

        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($this->isCsrfTokenValid('form-purchase',$submittedToken)) {
                $purchase->setStatus('New');
                $purchase->setIp($_SERVER['REMOTE_ADDR']);
                $purchase->setPaketid($pid);
                $user = $this->getUser();
                $purchase->setUserid($user->getId());
                $purchase->setTotal($total);
                $purchase->setDuration($duration);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($purchase);
                $entityManager->flush();

                return $this->redirectToRoute('user_purchase');
            }
        }

        return $this->render('user/newpurchase.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
            'category'=>$category,
            'paket'=>$paket,
            'total'=>$total,
            'duration'=>$duration,
        ]);
    }
    /**
     * @Route("/show/{id}", name="user_purchase_show", methods={"GET"})
     */
    public function showpurchase(Purchase $purchase): Response
    {
        return $this->render('admin/purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }
}
