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
                'required'=>false,
                'label'=>'Référent'
            ])
            ->add('email',EmailType::class,[
                'attr'=>['class'=>'form-control','placeholder'=>'Votre email'],

            ])
            ->add('objet', TextType::class,[
                'attr'=>['class'=>'form-control','placeholder'=>'Objet du message']
                ]
                )
            ->add('message',TextareaType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('ville',EntityType::class,[
                'class'=>Users::class,
                'choice_label'=>'city',
                'required'=>false,
                'attr'=>['class'=>'form-control'],
                'query_builder' => function(EntityRepository $er) {

                    return $er->createQueryBuilder('user')
                        ->where('user.email != :email')
                        ->setParameter('email', 'admin@greenworld.com');
                },
            ])




        ;
    }
}