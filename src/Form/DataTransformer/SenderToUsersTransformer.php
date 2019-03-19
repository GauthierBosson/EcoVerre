<?php


namespace App\Form\DataTransformer;


use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SenderToUsersTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function transform($sender)
    {
        if (null === $sender) {
            return '';
        }

        return $sender;
    }

    public function reverseTransform($senderNumber)
    {

        if (!$senderNumber) {
            return;
        }

        $sender= $this->entityManager
            ->getRepository(Users::class)

            ->find($senderNumber)
        ;

        if (null === $sender) {

            throw new TransformationFailedException(sprintf(
                'An user with number "%s" does not exist!',
                $senderNumber
            ));
        }

        return $sender;
    }
}