<?php

namespace Auth\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{

    public function findCredential(string $email, string $senha)
    {

        $usuario = $this->findOneByEmail($email);

        if ($usuario) {
            if (password_verify($senha, $usuario->getSenha())) {
                return [
                    'id' => $usuario->getId(),
                    'email' => $usuario->getEmail(),
                    'nome' => $usuario->getNome()
                ];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}