<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStudents extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('students');
        $table
            ->addColumn('user_id', 'integer')
            ->addColumn('data_nascimento', 'date')
            ->addColumn('genero', 'string', ['limit' => 50])
            ->addColumn('estado_civil', 'string', ['limit' => 50])
            ->addColumn('religiao', 'string', ['limit' => 100])
            ->addColumn('naturalidade', 'string', ['limit' => 100])
            ->addColumn('cor_etnia', 'string', ['limit' => 50])
            ->addColumn('rg', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('nis', 'string', ['limit' => 50])
            ->addColumn('documentos_civis', 'text', ['null' => true])
            ->addColumn('programas_sociais', 'text', ['null' => true])
            ->addColumn('valor_beneficio', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('cadunico_codigo', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('cep', 'string', ['limit' => 9])
            ->addColumn('endereco', 'string', ['limit' => 255])
            ->addColumn('municipio', 'string', ['limit' => 100])
            ->addColumn('pessoa_com_deficiencia', 'boolean')
            ->addColumn('tipo_deficiencia', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('serie_estudada', 'string', ['limit' => 100])
            ->addColumn('situacao_escolar', 'string', ['limit' => 50])
            ->addColumn('instituicao_ensino', 'string', ['limit' => 255])
            ->addColumn('encaminhado_por', 'text', ['null' => true])
            ->addColumn('turma', 'string', ['limit' => 255])
            ->addColumn('autorizo_imagem', 'boolean')
            ->addColumn('compromisso_social', 'boolean')
            ->addTimestamps()
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION',
            ])
            ->create();
    }
}
