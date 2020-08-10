<?php

namespace App\Controller;

use App\Repository\SettingRepository;
use App\Repository\SporPaketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
