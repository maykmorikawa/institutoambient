<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscricoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscricoesTable Test Case
 */
class InscricoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InscricoesTable
     */
    protected $Inscricoes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Inscricoes',
        'app.Alunos',
        'app.Atividades',
        'app.Users',
        'app.Responsavels',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inscricoes') ? [] : ['className' => InscricoesTable::class];
        $this->Inscricoes = $this->getTableLocator()->get('Inscricoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Inscricoes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InscricoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InscricoesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
