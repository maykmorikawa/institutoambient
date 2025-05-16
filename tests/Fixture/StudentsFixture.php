<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudentsFixture
 */
class StudentsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'data_nascimento' => '2025-05-16',
                'genero' => 'Lorem ipsum dolor sit amet',
                'estado_civil' => 'Lorem ipsum dolor sit amet',
                'religiao' => 'Lorem ipsum dolor sit amet',
                'naturalidade' => 'Lorem ipsum dolor sit amet',
                'cor_etnia' => 'Lorem ipsum dolor sit amet',
                'rg' => 'Lorem ipsum dolor ',
                'nis' => 'Lorem ipsum dolor sit amet',
                'documentos_civis' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'programas_sociais' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'valor_beneficio' => 'Lorem ipsum dolor ',
                'cadunico_codigo' => 'Lorem ipsum dolor sit amet',
                'cep' => 'Lorem i',
                'endereco' => 'Lorem ipsum dolor sit amet',
                'municipio' => 'Lorem ipsum dolor sit amet',
                'pessoa_com_deficiencia' => 1,
                'tipo_deficiencia' => 'Lorem ipsum dolor sit amet',
                'serie_estudada' => 'Lorem ipsum dolor sit amet',
                'situacao_escolar' => 'Lorem ipsum dolor sit amet',
                'instituicao_ensino' => 'Lorem ipsum dolor sit amet',
                'encaminhado_por' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'turma' => 'Lorem ipsum dolor sit amet',
                'autorizo_imagem' => 1,
                'compromisso_social' => 1,
                'created' => 1747360710,
                'modified' => 1747360710,
            ],
        ];
        parent::init();
    }
}
