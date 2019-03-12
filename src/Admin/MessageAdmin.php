<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 08/03/2019
 * Time: 10:00
 */

namespace App\Admin;


use App\Entity\Message;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;



class MessageAdmin extends AbstractAdmin
{


    public function createQuery($context = 'list')
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.receiver', ':my_param')
        );
        $query->setParameter('my_param', $user->getId());
        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('object');
        $datagridMapper->add('date');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('object',null,['label'=>'Objet']);
        $listMapper->add('sender.email',null,['label'=>'Expéditeur']);
        $listMapper->add('date');
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Message', [
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-primary',
                'description' => 'Votre message',
            ])
            ->add('object')
            ->add('content')
            ->end()
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        $collection->remove('edit');
        $collection->remove('create');
    }

    public function toString($object)
    {
        return $object instanceof Message
            ? $object->getObject()
            : 'Message';
    }

}