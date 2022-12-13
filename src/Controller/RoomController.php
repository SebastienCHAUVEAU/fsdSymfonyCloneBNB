<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'room_create')]
    public function create(Request $request, EntityManagerInterface $em){
        
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach ($room->getRoombeds() as $roomdetail) {
                $roomdetail->setRoom($room);
                $em->persist($roomdetail);
            }
           
            $em->persist($room);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm("room/index.html.twig", [
            "form" => $form
        ]);
    }

    #[Route('/room/edit/{id}', name: 'room_edit')]
    public function edit(Room $room, Request $request, EntityManagerInterface $em){
      
        $form = $this -> createForm(RoomType::class, $room);
        $form->handleRequest($request);
        
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($room);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm("room/index.html.twig", [
            "form" => $form,
            "room" => $room
        ]);
    }
    

    // #[Route('/room', name: 'app_room')]
    // public function index(): Response
    // {
    //     return $this->render('room/index.html.twig', [
    //         'controller_name' => 'RoomController',
    //     ]);
    // }
}
