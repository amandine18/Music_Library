<?php

namespace App\Security\Voter;

use App\Entity\Artist;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ArtistVoter extends Voter
{
    public const EDIT = 'ARTIST_EDIT';
    public const VIEW = 'ARTIST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Artist;
    }

    /** 
     * @param Artist $subject 
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
                return $subject->getOwner() === $user;
                // logic to determine if the user can EDIT
                // return true or false
                break;

            case self::VIEW:
                return $subject->getOwner() === $user;
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
