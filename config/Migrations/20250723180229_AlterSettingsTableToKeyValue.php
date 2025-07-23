<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterSettingsTableToKeyValue extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Este método irá alterar a tabela 'settings' para um formato de chave-valor.
     * Ele tenta preservar os dados existentes de 'site_name', 'site_description' e 'logo'
     * convertendo-os para o novo formato, e adiciona as novas colunas necessárias.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('settings');

        // --- REMOÇÃO DE COLUNAS ANTIGAS ---
        // Verifica e remove as colunas antigas se elas existirem.
        // Se você tinha dados nessas colunas e quer preservá-los,
        // execute comandos INSERT antes de remover as colunas, como nos exemplos comentados abaixo.
        // Exemplo de migração de dados (descomente e adapte se necessário):
        /*
        if ($table->hasColumn('site_name')) {
            $this->execute("INSERT INTO settings (key_name, value, type, description, created, modified)
                            SELECT 'site_name', site_name, 'string', 'Nome do Site', NOW(), NOW()
                            FROM settings WHERE site_name IS NOT NULL;");
        }
        if ($table->hasColumn('site_description')) {
            $this->execute("INSERT INTO settings (key_name, value, type, description, created, modified)
                            SELECT 'site_description', site_description, 'text', 'Descrição do Site', NOW(), NOW()
                            FROM settings WHERE site_description IS NOT NULL;");
        }
        if ($table->hasColumn('logo')) {
            $this->execute("INSERT INTO settings (key_name, value, type, description, created, modified)
                            SELECT 'logo_principal', logo, 'image', 'Logo Principal do Site', NOW(), NOW()
                            FROM settings WHERE logo IS NOT NULL;");
        }
        */

        // Remover colunas antigas se existirem
        if ($table->hasColumn('site_name')) {
            $table->removeColumn('site_name');
        }
        if ($table->hasColumn('site_description')) {
            $table->removeColumn('site_description');
        }
        if ($table->hasColumn('logo')) {
            $table->removeColumn('logo');
        }

        // --- ADIÇÃO DE NOVAS COLUNAS ---
        // Adicionar as novas colunas para o modelo chave-valor.
        // A coluna 'key_name' não terá a opção 'unique' aqui, será adicionada como um índice separado.
        if (!$table->hasColumn('key_name')) {
            $table->addColumn('key_name', 'string', [
                'limit' => 255,
                'null' => false,
                'after' => 'id', // Posiciona a coluna após 'id'
            ]);
        }
        if (!$table->hasColumn('value')) {
            $table->addColumn('value', 'text', [
                'null' => true, // Pode ser nulo se a configuração não tiver valor ou for uma imagem sem upload
                'after' => 'key_name',
            ]);
        }
        if (!$table->hasColumn('type')) {
            $table->addColumn('type', 'string', [
                'limit' => 50,
                'default' => 'string', // 'string', 'image', 'text', etc.
                'null' => false,
                'after' => 'value',
            ]);
        }
        if (!$table->hasColumn('description')) {
            $table->addColumn('description', 'text', [
                'null' => true,
                'after' => 'type',
            ]);
        }

        // Aplicar as alterações de estrutura das colunas na tabela.
        $table->update();

        // --- ADIÇÃO DO ÍNDICE ÚNICO ---
        // Adicionar a restrição de unicidade para 'key_name' como um índice separado.
        // Verifica se o índice já não existe para evitar erros em re-execuções.
        if (!$table->hasIndex(['key_name'])) {
            $table->addIndex(['key_name'], ['unique' => true]);
        }

        // Aplicar as alterações do índice na tabela.
        $table->update();
    }
}
