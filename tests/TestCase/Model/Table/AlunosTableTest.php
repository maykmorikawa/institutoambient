<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlunosTable Test Case
 */
class AlunosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AlunosTable
     */
    protected $Alunos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Alunos',
        'app.Users',
        'app.Enderecos',
        'app.Escolaridades',
        'app.Inscricoes',
        'app.Presencas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Alunos') ? [] : ['className' => AlunosTable::class];
        $this->Alunos = $this->getTableLocator()->get('Alunos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Alunos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AlunosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AlunosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
