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
use Doctrine\ORM\EntityRepository;
use function Sodium\add;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
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
            'query_builder' => function(EntityRepository $er) {
                $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
                return $er->createQueryBuilder('trash')
                    ->where('trash.city = :city')
                    ->setParameter('city', $user->getCity());
            },
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
        $listMapper->addIdentifier('reference', null, [
            'route' => [
                'name' => 'show'
            ]
        ]);
        $listMapper->add('date');
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Incident : ' . $showMapper->getAdmin()->getSubject()->getReference(), [
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-danger',
                'description' => 'Votre benne',
            ])
            ->add('email', null, ['label' => 'Email'])
            ->add('description', null, ['label' => 'Description'])
            ->add('date', null, ['label' => 'Date'])
            ->end()
            ->end()
        ;
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