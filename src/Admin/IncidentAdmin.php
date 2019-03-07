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
        $ref = random_bytes(8);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();

        $formMapper->add('date', DateType::class, [
            'label' => 'Date'
        ]);
        $formMapper->add('trash', EntityType::class, [
            'class' => Trashs::class,
            'choice_label' => 'reference'
        ]);
        $formMapper->add('email', HiddenType::class, [
            'label' => 'Email',
            'data' => $user->getEmail()
        ]);
        $formMapper->add('city', HiddenType::class, [
            'label' => 'Ville',
            'data' => $user->getCity()
        ]);
        $formMapper->add('reference', HiddenType::class, [
            'label' => 'Référence',
            'data' => substr($user->getCity(), 0, 3 ) . 'ver' . bin2hex($ref)
        ]);
        $formMapper->add('description', TextareaType::class, [
            'label' => 'Description'
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('date');
        $datagridMapper->add('email');
        $datagridMapper->add('reference');
        $datagridMapper->add('description');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('reference');
        $listMapper->add('date');
    }

    public function toString($object)
    {
        return $object instanceof Incidents
            ? $object->getReference()
            : 'Incidents';
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