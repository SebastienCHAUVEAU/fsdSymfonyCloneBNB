<?php

namespace App\Controller;

use App\Repository\AccomodationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $test = [];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'listSearch' => $test
        ]);
    }

    #[Route('/home/search', name: 'home_search')]
    public function homeSearch(Request $request, AccomodationRepository $accomodationRepo): Response
    {
        $selectedCity =$request->get('city');
        $selectedPeople =$request->get('people');
        $dateA = $request->get('dateA');
        $dateB = $request->get('dateB');
        

       
        if($selectedCity == "" && $selectedPeople == ""){
            $foundAccomodations = [];
        }else{
           // $foundAccomodations = $accomodationRepo -> findBy(array("city" => $selectedCity));
           $foundAccomodations = $accomodationRepo -> search($selectedCity,$selectedPeople,$dateA,$dateB);
           
        };
        

        return $this->render('home/index.html.twig', [
            'listSearch' => $foundAccomodations,
        ]);
    }

    #[Route('/home/showAll', name: 'showAll')]
    public function show(AccomodationRepository $accomodationRepo)
    {
        $accomodation = $accomodationRepo -> findAll();
       
        return $this->render('home/homeShowall.html.twig', [
            'accomodation' => $accomodation,
        ]);
    }
}
