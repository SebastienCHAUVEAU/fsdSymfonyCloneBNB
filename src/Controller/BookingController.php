<?php

namespace App\Controller;

use App\Form\BedType;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Entity\Accomodation;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    
    #[Route('/booking/add', name: 'booking_add')]
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $booking->setUser($this->getUser());
          
          // $booking->setAccomodation($accomodationId);
           $calculatePrice = 1000;
           $booking->setPrice($calculatePrice);
           $bookingRepository->save($booking, true);

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('booking/index.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('api/calendar/{id}', name: 'api_calendar')]
    public function giveCalendar(Accomodation $accomo, BookingRepository $bookingRepo): Response
    {
        $bookings = $accomo->getBookingAcc();
        $tab = [];
        foreach($bookings as $booking){
            $tab[] = [
                "title" => "Réservé",
                "start" => $booking->getStartDateAt()->format("Y-m-d"),
                "end" => $booking->getEndDateAt()->format("Y-m-d")
            ];
        }
       
        return $this->json($tab);
      
    }
}
