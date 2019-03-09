<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 08/03/2019
 * Time: 10:00
 */

namespace App\Admin;


use App\Entity\Message;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\DataTransformer\ModelToIdTransformer;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\SenderToUsersTransformer;

class MessageReferentAdmin extends AbstractAdmin
{
    private $transformer;

    public function __construct(string $code, string $class, string $baseControllerName, SenderToUsersTransformer $transformer)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->transformer = $transformer;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $today = new \DateTime();
        $today->setTimezone(new \DateTimeZone('Europe/Paris'));
        $today->format('Y-m-d H:i:s (e)');

        $formMapper->add('receiver', EntityType::class, [
            'label' => 'À',
            'class' => Users::class,
            'query_builder' => function(EntityRepository $er) {
                $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
                return $er->createQueryBuilder('user')
                    ->where('user.city = :city')
                    ->andWhere('user.email != :email')
                    ->setParameter('city', $user->getCity())
                    ->setParameter('email', $user->getEmail());
            },
            'choice_label' => 'email'
        ]);
        $formMapper->add('object', TextType::class, [
            'label' => 'Sujet'
        ]);
        $formMapper->add('content', TextareaType::class, [
            'label' => 'Message',
            'attr' => ['rows' => 20]
        ]);
        $formMapper->add('sender', HiddenType::class,[
            'data' => $user->getId()
        ])
        ->get('sender')
        ->addModelTransformer($this->transformer);
        $formMapper->add('status', HiddenType::class, [
            'data' => 0
        ]);
        $formMapper->add('date', DateTimeType::class, [
            'label' => 'Date',
            'data' => $today
        ]);

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('object');
        $datagridMapper->add('date');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('object');
        $listMapper->add('date');
    }

    public function toString($object)
    {
        return $object instanceof Message
            ? $object->getObject()
            : 'Message';
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'data_class'=>Users::class
        ]);
    }
}