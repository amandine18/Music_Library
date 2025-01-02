<?php

namespace App\Security\Voter;

use App\Entity\Release;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ReleaseVoter extends Voter
{
    public const EDIT = 'RELEASE_EDIT';
    public const VIEW = 'RELEASE_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Release;
    }

    /** 
     * @param Release $subject 
    */

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User */
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $subject->getArtist()->getOwner() === $user;
                //Récupère l'artiste puis l'owner
                break;

            case self::VIEW:
                return $subject->getArtist()->getOwner() === $user;
                //Récupère l'artiste puis l'owner
                break;
        }

        return false;
    }
}
