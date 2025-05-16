<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Escolaridade Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property string $nivel
 * @property string $serie
 * @property string $situacao
 * @property string|null $curso
 * @property string $instituicao
 * @property string|null $ano_conclusao
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Aluno $aluno
 */
class Escolaridade extends Entity
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
        'aluno_id' => true,
        'nivel' => true,
        'serie' => true,
        'situacao' => true,
        'curso' => true,
        'instituicao' => true,
        'ano_conclusao' => true,
        'created' => true,
        'modified' => true,
        'aluno' => true,
    ];
}
