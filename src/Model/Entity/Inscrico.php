<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inscrico Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int $atividade_id
 * @property int|null $user_id
 * @property int|null $responsavel_id
 * @property \Cake\I18n\DateTime|null $data_inscricao
 * @property string $status
 *
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Atividade $atividade
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\User $responsavel
 */
class Inscrico extends Entity
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
        'atividade_id' => true,
        'user_id' => true,
        'responsavel_id' => true,
        'data_inscricao' => true,
        'status' => true,
        'aluno' => true,
        'atividade' => true,
        'user' => true,
        'responsavel' => true,
    ];
}
