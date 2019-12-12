<?php

namespace App\Security\Voter;

use App\Entity\Note;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class DeleteNoteVoter extends Voter
{
    /** @var Security */
    private $security;

    /**
     * Le constructeur peut récupérer des services par autowiring
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Savoir si le "voter" doit intervenir
     * @param string $attribute         L'attribut correspond au nom du droit (comme un role)
     * @param mixed $subject            Sur quoi cherche t-on à vérifier les droits
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        // Faire intervenir le Voter seulement quand on vérifie le droit NOTE_DELETE sur une Note
        // Exemple : IsGranted("NOTE_DELETE", $note)
        return $attribute === 'NOTE_DELETE'
            && $subject instanceof Note;

        /**
         * Opérateur instanceof : Vérifie qu'un objet appartient à une classe
         * $objet instanceof Classe
         */
    }

    /**
     * Procéder à la vérification de l'accès
     * @param string $attribute             L'attribut (ici "POST_DELETE")
     * @param mixed $subject                Le sujet du droit d'accès (ici l'instance de Note)
     * @param TokenInterface $token         Un jeton pour récupérer l'utilisateur actuel
     *
     * @return bool                         Est-ce que l'utilisateur obtient le droit ?
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var Note $subject */

        // Récupération de l'utilisateur grâce à un jeton
        /** @var UserInterface $user */
        $user = $token->getUser();

        // Si l'utilisateur actuel n'est pas connecté : il n'a pas le droit d'accès
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Si l'utilisateur est administrateur : accès accordé
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // Si l'utilisateur est l'auteur de la note : accès accordé
        if ($subject->getUser() === $user) {
            return true;
        }

        return false;
    }
}
