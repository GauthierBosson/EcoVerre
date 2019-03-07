<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 04/03/2019
 * Time: 11:40
 */

namespace App\Admin;


use App\Entity\Trashs;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TrashAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();

        $formMapper->add('city', HiddenType::class, [
            'label' => 'Ville',
            'data' => $user->getCity()
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
        $datagridMapper->add('address');
        $datagridMapper->add('inseeCode');
        $datagridMapper->add('latitude');
        $datagridMapper->add('longitude');
        $datagridMapper->add('altitude');
        $datagridMapper->add('reference');
        $datagridMapper->add('capacityMax');
        $datagridMapper->add('actualCapacity');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('reference');
        $listMapper->add('address');
        $listMapper->add('actualCapacity');
    }

    public function toString($object)
    {
        return $object instanceof Trashs
            ? $object->getReference()
            : 'Trash';
    }

    public function createQuery($context = 'list')
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.city', ':my_param')
        );
        $query->setParameter('my_param', $user->getCity());
        return $query;
    }
}