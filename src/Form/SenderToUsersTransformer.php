<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 09/03/2019
 * Time: 03:07
 */

namespace App\Form;


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
        // no issue number? It's optional, so that's ok
        if (!$senderNumber) {
            return;
        }

        $sender= $this->entityManager
            ->getRepository(Users::class)
            // query for the issue with this id
            ->find($senderNumber)
        ;

        if (null === $sender) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An user with number "%s" does not exist!',
                $senderNumber
            ));
        }

        return $sender;
    }
}