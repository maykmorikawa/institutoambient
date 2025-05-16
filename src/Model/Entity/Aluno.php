<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aluno Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $cpf
 * @property string|null $rg
 * @property string|null $nis
 * @property \Cake\I18n\Date|null $data_nascimento
 * @property string|null $telefone
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $atividade_id
 *
 * @property \App\Model\Entity\Atividade $atividade
 * @property \App\Model\Entity\Endereco[] $enderecos
 * @property \App\Model\Entity\Escolaridade[] $escolaridades
 * @property \App\Model\Entity\Inscrico[] $inscricoes
 */
class Aluno extends Entity
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
        'nome' => true,
        'email' => true,
        'cpf' => true,
        'rg' => true,
        'nis' => true,
        'data_nascimento' => true,
        'telefone' => true,
        'created' => true,
        'modified' => true,
        'atividade_id' => true,
        'atividade' => true,
        'enderecos' => true,
        'escolaridades' => true,
        'inscricoes' => true,
    ];
}
