<?php
// src/Model/Entity/Certificado.php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Certificado extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [ // CORREÇÃO: Adicionado 'array' aqui
        'aluno_id' => true,
        'atividade_id' => true,
        'codigo_autenticacao' => true,
        'carga_horaria_total' => true,
        'data_emissao' => true,
        'aluno' => true,
        'atividade' => true,
        // 'created' e 'modified' são gerenciados pelo TimestampBehavior,
        // então geralmente não precisam ser explicitamente acessíveis aqui.
    ];
}