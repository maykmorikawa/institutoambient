<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Projeto Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $descricao
 * @property \Cake\I18n\Date $data_inicio
 * @property \Cake\I18n\Date $data_fim
 * @property string $status
 * @property int $user_id
 * @property bool|null $publicado
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Atividade[] $atividades
 */
class Projeto extends Entity
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
    protected array $_accessible = [
        'name' => true,
        'descricao' => true,
        'data_inicio' => true,
        'data_fim' => true,
        'status' => true,
        'user_id' => true,
        'publicado' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'atividades' => true,
    ];
}
