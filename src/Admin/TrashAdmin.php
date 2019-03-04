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
        $formMapper->add('city', TextType::class);
        $formMapper->add('address', TextType::class);
        $formMapper->add('inseeCode', TextType::class);
        $formMapper->add('latitude', TextType::class);
        $formMapper->add('longitude', TextType::class);
        $formMapper->add('altitude', TextType::class);
        $formMapper->add('reference', TextType::class);
        $formMapper->add('capacityMax', TextType::class);
        $formMapper->add('actualCapacity', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('city');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('city');
    }
}