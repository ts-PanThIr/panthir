<?php

namespace App\User;

class UserRoles
{
    /**
     * - Clientes/accounts
     *      - projetos
     *          -documentos
     */
    const ROLE_DOCUMENTS_VIEW = 'ROLE_DOCUMENTS_VIEW';
    const ROLE_DOCUMENTS_CREATE = 'ROLE_DOCUMENTS_CREATE';
    const ROLE_DOCUMENTS_DELETE = 'ROLE_DOCUMENTS_DELETE';
    const ROLE_DOCUMENTS_EDIT = 'ROLE_DOCUMENTS_EDIT';

    const ROLE_PROJECT_VIEW = 'ROLE_PROJECT_VIEW';
    const ROLE_PROJECT_CREATE = 'ROLE_PROJECT_CREATE';
    const ROLE_PROJECT_DELETE = 'ROLE_PROJECT_DELETE';
    const ROLE_PROJECT_EDIT = 'ROLE_PROJECT_EDIT';

    const ROLE_ACCOUNT_VIEW = 'ROLE_ACCOUNT_VIEW';
    const ROLE_ACCOUNT_CREATE = 'ROLE_ACCOUNT_CREATE';
    const ROLE_ACCOUNT_DELETE = 'ROLE_ACCOUNT_DELETE';
    const ROLE_ACCOUNT_EDIT = 'ROLE_ACCOUNT_EDIT';

    public const PROFILE_VIEWER = [
        self::ROLE_DOCUMENTS_VIEW
    ];

    public const PROFILE_WRITER = [
        self::ROLE_DOCUMENTS_CREATE,
        self::ROLE_DOCUMENTS_DELETE,
        self::ROLE_DOCUMENTS_EDIT,
        self::ROLE_DOCUMENTS_VIEW
    ];

    public const PROFILE_ACCOUNT_MANAGER = [
        self::ROLE_DOCUMENTS_CREATE,
        self::ROLE_DOCUMENTS_DELETE,
        self::ROLE_DOCUMENTS_EDIT,
        self::ROLE_DOCUMENTS_VIEW,

        self::ROLE_PROJECT_CREATE,
        self::ROLE_PROJECT_DELETE,
        self::ROLE_PROJECT_EDIT,
        self::ROLE_PROJECT_VIEW
    ];

    public const PROFILE_ADMIN = [
        self::ROLE_DOCUMENTS_CREATE,
        self::ROLE_DOCUMENTS_DELETE,
        self::ROLE_DOCUMENTS_EDIT,
        self::ROLE_DOCUMENTS_VIEW,

        self::ROLE_PROJECT_CREATE,
        self::ROLE_PROJECT_DELETE,
        self::ROLE_PROJECT_EDIT,
        self::ROLE_PROJECT_VIEW,

        self::ROLE_ACCOUNT_CREATE,
        self::ROLE_ACCOUNT_DELETE,
        self::ROLE_ACCOUNT_EDIT,
        self::ROLE_ACCOUNT_VIEW
    ];

    public const LIST_PROFILES = [
        "PROFILE_VIEWER",
        "PROFILE_WRITER",
        "PROFILE_ACCOUNT_MANAGER",
        "PROFILE_ADMIN"
    ];

    public static function canSetProfile(array $currentRoles, array $concededRoles): bool
    {
        $currentProfile = self::getProfileByRoles($currentRoles);
        $targetProfile = self::getProfileByRoles($concededRoles);
        if(array_search($currentProfile, self::LIST_PROFILES) > array_search($targetProfile, self::LIST_PROFILES)){
            return true;
        }
        return false;
    }

    public static function getProfileByRoles(array $roles): string
    {
        if($roles == self::PROFILE_VIEWER) {
            return "PROFILE_VIEWER";
        }
        if($roles == self::PROFILE_WRITER) {
            return "PROFILE_WRITER";
        }
        if($roles == self::PROFILE_ACCOUNT_MANAGER) {
            return "PROFILE_ACCOUNT_MANAGER";
        }
        if($roles == self::PROFILE_ADMIN) {
            return "PROFILE_ADMIN";
        }

        return "PROFILE_VIEWER";
    }
}
