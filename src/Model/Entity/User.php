<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property int|null $profile_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Profile $profile
 * @property \App\Model\Entity\Post[] $posts
 */
class User extends Entity
{
    //  Campos que podem ser preenchidos com newEntity() ou patchEntity()
    protected array $_accessible = [
        'profile_id' => true,
        'name' => true,
        'email' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
        'profile' => true,
        'posts' => true,
    ];

    // ✅ Ocultar o campo 'password' ao serializar para JSON
    protected array $_hidden = [
        'password',
    ];

    // ✅ Hashear a senha automaticamente ao salvar
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
