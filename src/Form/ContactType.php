<?php


namespace App\Form;


use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('admin',CheckboxType::class,[
                'required'=>false
            ])
            ->add('referent',CheckboxType::class,[
                'required'=>false
            ])
            ->add('email',EmailType::class)
            ->add('objet', TextType::class)
            ->add('message',TextareaType::class)
            ->add('ville',EntityType::class,[
                'class'=>Users::class,
                'choice_label'=>'city',
                'required'=>false,
                'query_builder' => function(EntityRepository $er) {

                    return $er->createQueryBuilder('user')
                        ->where('user.email != :email')
                        ->setParameter('email', 'admin@greenworld.com');
                },
            ])




        ;
    }
}