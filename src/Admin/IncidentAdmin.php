<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 04/03/2019
 * Time: 11:40
 */

namespace App\Admin;


use App\Entity\Incidents;
use App\Entity\Trashs;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IncidentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        dump($user->getEmail());
        $formMapper->add('date', DateType::class, [
            'label' => 'Date'
        ]);
        $formMapper->add('trash', EntityType::class, [
            'class' => Trashs::class,
            'choice_label' => 'reference'
        ]);
        $formMapper->add('address', TextType::class, [
            'label' => 'Adresse'
        ]);
        $formMapper->add('email', HiddenType::class, [
            'label' => 'Email',
            'data' => $user->getEmail()
        ]);
        $formMapper->add('reference', HiddenType::class, [
            'data' => 'bidon'
        ]);
        $formMapper->add('city', HiddenType::class, [
            'label' => 'Ville',
            'data' => 'Toulouse'
        ]);
        $formMapper->add('latitude', HiddenType::class, [
            'label' => 'Latitude',
            'data' => 6789.6789
        ]);
        $formMapper->add('longitude', HiddenType::class, [
            'label' => 'Longitude',
            'data' => 67867.7897
        ]);
        $formMapper->add('altitude', HiddenType::class, [
            'label' => 'Altidue',
            'data' => 789.5678
        ]);
        $formMapper->add('description', TextareaType::class, [
            'label' => 'Description'
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('date');
        $datagridMapper->add('address');
        $datagridMapper->add('email');
        $datagridMapper->add('reference');
        $datagridMapper->add('city');
        $datagridMapper->add('latitude');
        $datagridMapper->add('longitude');
        $datagridMapper->add('altitude');
        $datagridMapper->add('description');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('reference', TextType::class, [
            'label' => 'Référence'
        ]);
        $listMapper->add('address', TextType::class, [
            'label' => 'Adresse'
        ]);
        $listMapper->add('actualCapacity', TextType::class, [
            'label' => 'Capacité actuelle'
        ]);
    }

    public function toString($object)
    {
        return $object instanceof Incidents
            ? $object->getReference()
            : 'Incidents';
    }
}