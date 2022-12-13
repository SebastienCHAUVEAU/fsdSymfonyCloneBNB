<?php

namespace App\Form;

use App\Entity\Accomodation;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccomodationType extends AbstractType
{
    public $em;

    public function __contruct (EntityManagerInterface $em){
        $this->em = $em;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address')
            ->add('city')
            ->add('price')
            ->add('area')
            ->add('email')
            ->add('user')
            ->addEventListener(FormEvents::PRE_SET_DATA,[$this,'onPreSetData'])
        ;
    }

    public function onPreSetData(FormEvent $event){
        $form = $event->getForm();
        $object = $event ->getData();
        
        if($object->getId() !== null){
            $form->remove('address');
            $form->remove('city');
        };
        
       
    }

    public function onPreSubmit(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();

        $city = $object['city'];
        $conn = $this->em->getConnection();
        $sql = 'SELECT ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
        FROM spec_villes_france_free
        WHERE ville_nom_simple = :city';
        $request = $conn->prepare($sql);
        $resultSet  = $request->executeQuery(['city' => $city]);
        $result = $resultSet->fetchAssociative();

        if(empty($result)){
            $form->addError(new FormError("La ville n'existe pas"));
            return;
        }

        $form->getNormData()->setLatitude($result["ville_latitude_deg"]);
        $form->getNormData()->setLongitude($result["ville_longitude_deg"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accomodation::class,
        ]);
    }
}
