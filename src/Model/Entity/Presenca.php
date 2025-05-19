<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Presenca Entity
 *
 * @property int $id
 * @property int $aula_id
 * @property int $aluno_id
 * @property bool $presente
 * @property string|null $observacoes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Aula $aula
 * @property \App\Model\Entity\Aluno $aluno
 */
class Presenca extends Entity
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
        'aula_id' => true,
        'aluno_id' => true,
        'presente' => true,
        'observacoes' => true,
        'created' => true,
        'modified' => true,
        'aula' => true,
        'aluno' => true,
    ];
}
