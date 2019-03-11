<?php
/**
 * Created by PhpStorm.
 * User: joffrey
 * Date: 2019-03-04
 * Time: 14:59
 */

namespace App\Security;


use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($email): Users
    {
        $user = $this->findOneUserBy(['email' => $email]);

        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf(
                    'User with "%s" email does not exist.',
                    $email
                )
            );
        }

        return $user;
    }

    private function findOneUserBy(array $options): ?Users
    {
        return $this->entityManager
            ->getRepository(Users::class)
            ->findOneBy($options);
    }

    public function refreshUser(UserInterface $user): Users
    {
        assert($user instanceof Users);

        if (null === $reloadedUser = $this->findOneUserBy(['id' => $user->getId()])) {
            throw new UsernameNotFoundException(sprintf(
                'User with ID "%s" could not be reloaded.',
                $user->getId()
            ));
        }

        return $reloadedUser;
    }

    public function supportsClass($class): bool
    {
        return $class === Users::class;
    }
}