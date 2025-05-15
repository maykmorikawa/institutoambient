<?php
declare(strict_types=1);


use Phinx\Migration\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('role', 'enum', ['values' => ['admin', 'editor', 'author'], 'default' => 'author'])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();
    }
}
# criação de tabelas no banco

#  CREATE TABLE projetos (
#      id INT AUTO_INCREMENT PRIMARY KEY,
#      titulo VARCHAR(255) NOT NULL,
#    		ublicado BOOLEAN DEFAULT FALSE,
#      created DATETIME DEFAULT CURRENT_TIMESTAMP,
#      modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
#  );

#  CREATE TABLE atividades (
#      id INT AUTO_INCREMENT PRIMARY KEY,
#      projeto_id INT NOT NULL,
#      titulo VARCHAR(255) NOT NULL,
#      descricao TEXT,
#      slug VARCHAR(255) UNIQUE,
#      link_inscricao VARCHAR(255) UNIQUE,
#      publicado BOOLEAN DEFAULT FALSE,
#      created DATETIME DEFAULT CURRENT_TIMESTAMP,
#      modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
#      FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE
#  );

#  CREATE TABLE alunos (
#      id INT AUTO_INCREMENT PRIMARY KEY,
#      nome VARCHAR(255) NOT NULL,
#      email VARCHAR(255) NOT NULL,
#      cpf VARCHAR(14) NOT NULL UNIQUE,
#      rg VARCHAR(20),
#      nis VARCHAR(20),
#      data_nascimento DATE,
#      telefone VARCHAR(20),
#      created DATETIME DEFAULT CURRENT_TIMESTAMP,
#      modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
#  );

CREATE TABLE inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    atividade_id INT NOT NULL,
    user_id INT NULL, -- Agora permite NULL pois usamos ON DELETE SET NULL
    data_inscricao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pendente',
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (atividade_id) REFERENCES atividades(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);


CREATE TABLE enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    cep VARCHAR(10),
    logradouro VARCHAR(255),
    numero VARCHAR(20),
    complemento VARCHAR(100),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
);

CREATE TABLE escolaridades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    nivel ENUM('Fundamental', 'Médio', 'Técnico', 'Superior', 'Pós-graduação', 'Mestrado', 'Doutorado') NOT NULL,
    serie VARCHAR(100) NOT NULL, -- Série em que estuda ou parou
    situacao ENUM('Cursando', 'Interrompido', 'Concluído') NOT NULL, -- Situação escolar
    curso VARCHAR(255), -- Ex: Pedagogia, Administração...
    instituicao VARCHAR(255) NOT NULL, -- Nome da escola/faculdade
    ano_conclusao YEAR,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
);

ALTER TABLE alunos ADD atividade_id INT;
ALTER TABLE alunos ADD FOREIGN KEY (atividade_id) REFERENCES atividades(id);


-- Adiciona o campo responsavel_id
ALTER TABLE inscricoes
ADD COLUMN responsavel_id INT AFTER user_id,
ADD CONSTRAINT fk_inscricoes_responsavel
    FOREIGN KEY (responsavel_id) REFERENCES users(id)
    ON DELETE SET NULL;

-- Altera status para ENUM (ou mantenha como VARCHAR e valide no código)
ALTER TABLE inscricoes
MODIFY COLUMN status ENUM('pendente', 'confirmada', 'cancelada') DEFAULT 'pendente';
