<?php
// src/Model/Entity/Certificado.php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Certificado extends Entity
{
    protected $_accessible = [
        'aluno_id' => true,
        'atividade_id' => true,
        'codigo_autenticacao' => true,
        'carga_horaria_total' => true,
        'data_emissao' => true,
        'aluno' => true,
        'atividade' => true,
    ];
}