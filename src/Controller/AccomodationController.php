<?php

namespace App\Controller;

use App\Entity\House;
use App\Form\HouseType;
use App\Entity\Accomodation;
use App\Form\AccomodationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccomodationController extends AbstractController
{
    #[Route('/accomodation', name: 'accomodation_create')]
    public function create(Request $request, EntityManagerInterface $em){
        $type=$request->get('type');
       
        if (class_exists('App\\Entity\\' . $type) && get_parent_class('App\\Entity\\' . $type) == "App\\Entity\\Place") {
            $place= new ('App\\Entity\\'.$type)();
            $form = $this->createForm('App\\Form\\'.$type.'Type',$place);
        }else{
        $place = new House();
        $form = $this->createForm(HouseType::class, $place);
    }

        $parent=get_parent_class($place);

        
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($place);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm("accomodation/index.html.twig", [
            "form" => $form
        ]);
    }


    #[Route('/accomodation/edit/{id}', name: 'accomodation_edit')]
    public function edit(Accomodation $accomodations, Request $request, EntityManagerInterface $em){
      
        $typeForm = str_replace("Entity","Form",get_class($accomodations))."Type";
        $form = $this -> createForm($typeForm, $accomodations);
        
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($accomodations);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm("accomodation/index.html.twig", [
            "form" => $form,
            "accomodations" => $accomodations
        ]);
    }

    #[Route('/accomodation/remove/{id}', name:"accomodation_remove", methods:['GET'])]
    public function deleteAccomodation(Accomodation $accomodations, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($accomodations);
        $entityManager->flush();
        
        return $this->redirectToRoute('home');
    }


}
