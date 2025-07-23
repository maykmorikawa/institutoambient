<?php
// src/Model/Entity/Setting.php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Setting extends Entity
{
    protected array $_accessible = [
        'key_name' => true,
        'value' => true,
        'type' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
    ];
}