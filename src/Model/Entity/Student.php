<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Student Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\Date $data_nascimento
 * @property string $genero
 * @property string $estado_civil
 * @property string $religiao
 * @property string $naturalidade
 * @property string $cor_etnia
 * @property string|null $rg
 * @property string $nis
 * @property string|null $documentos_civis
 * @property string|null $programas_sociais
 * @property string|null $valor_beneficio
 * @property string|null $cadunico_codigo
 * @property string $cep
 * @property string $endereco
 * @property string $municipio
 * @property bool $pessoa_com_deficiencia
 * @property string|null $tipo_deficiencia
 * @property string $serie_estudada
 * @property string $situacao_escolar
 * @property string $instituicao_ensino
 * @property string|null $encaminhado_por
 * @property string $turma
 * @property bool $autorizo_imagem
 * @property bool $compromisso_social
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Student extends Entity
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
        'user_id' => true,
        'data_nascimento' => true,
        'genero' => true,
        'estado_civil' => true,
        'religiao' => true,
        'naturalidade' => true,
        'cor_etnia' => true,
        'rg' => true,
        'nis' => true,
        'documentos_civis' => true,
        'programas_sociais' => true,
        'valor_beneficio' => true,
        'cadunico_codigo' => true,
        'cep' => true,
        'endereco' => true,
        'municipio' => true,
        'pessoa_com_deficiencia' => true,
        'tipo_deficiencia' => true,
        'serie_estudada' => true,
        'situacao_escolar' => true,
        'instituicao_ensino' => true,
        'encaminhado_por' => true,
        'turma' => true,
        'autorizo_imagem' => true,
        'compromisso_social' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
