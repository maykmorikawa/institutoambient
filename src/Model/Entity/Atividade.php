<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Atividade Entity
 *
 * @property int $id
 * @property int $projeto_id
 * @property string $titulo
 * @property string|null $descricao
 * @property string|null $slug
 * @property string|null $link_inscricao
 * @property bool|null $publicado
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Projeto $projeto
 * @property \App\Model\Entity\Aluno[] $alunos
 * @property \App\Model\Entity\Inscrico[] $inscricoes
 */
class Atividade extends Entity
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
        'projeto_id' => true,
        'titulo' => true,
        'descricao' => true,
        'slug' => true,
        'link_inscricao' => true,
        'publicado' => true,
        'created' => true,
        'modified' => true,
        'projeto' => true,
        'alunos' => true,
        'inscricoes' => true,
    ];
}
