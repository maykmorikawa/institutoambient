<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aula Entity
 *
 * @property int $id
 * @property int $atividade_id
 * @property \Cake\I18n\DateTime $data
 * @property string|null $conteudo
 * @property string|null $observacoes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Atividade $atividade
 * @property \App\Model\Entity\Presenca[] $presencas
 */
class Aula extends Entity
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
        'atividade_id' => true,
        'data' => true,
        'conteudo' => true,
        'observacoes' => true,
        'created' => true,
        'modified' => true,
        'atividade' => true,
        'presencas' => true,
    ];
}
