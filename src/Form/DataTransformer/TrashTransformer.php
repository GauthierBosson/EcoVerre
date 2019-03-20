<?php


namespace App\Form\DataTransformer;


use App\Entity\Trashs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TrashTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function transform($trash)
    {
        if (null === $trash) {
            return '';
        }

        return $trash;
    }

    public function reverseTransform($trashNumber)
    {

        if (!$trashNumber) {
            return;
        }

        $trash= $this->entityManager
            ->getRepository(Trashs::class)

            ->find($trashNumber)
        ;

        if (null === $trash) {

            throw new TransformationFailedException(sprintf(
                'An trash with number "%s" does not exist!',
                $trashNumber
            ));
        }

        return $trash;
    }
}