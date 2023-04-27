<?php

namespace App\User\DTO;

use App\Shared\Transformer\AbstractDTOTransformer;
use Symfony\Component\HttpFoundation\Request;

class UserSearchDTO extends AbstractDTOTransformer
{
    public int $id;
    public string $token;
    public string $clientId;

    /**
     * @param Request $object
     * @return self
     */
    public static function transformFromObject(object $object): self
    {
        $dto = new UserSearchDTO();
//        $dto->
        return $dto;
    }
}
