<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 04/03/2019
 * Time: 11:40
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TrashAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('city', TextType::class, [
            'label' => 'Ville'
        ]);
        $formMapper->add('address', TextType::class, [
            'label' => 'Adresse'
        ]);
        $formMapper->add('inseeCode', TextType::class, [
            'label' => 'Code Insee'
        ]);
        $formMapper->add('latitude', TextType::class, [
            'label' => 'Latitude'
        ]);
        $formMapper->add('longitude', TextType::class, [
            'label' => 'Longitude'
        ]);
        $formMapper->add('altitude', TextType::class, [
            'label' => 'Altitude'
        ]);
        $formMapper->add('reference', TextType::class, [
            'label' => 'Référence'
        ]);
        $formMapper->add('capacityMax', TextType::class, [
            'label' => 'Capacité maximum'
        ]);
        $formMapper->add('actualCapacity', TextType::class, [
            'label' => 'Capacité actuelle'
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('city');
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
}