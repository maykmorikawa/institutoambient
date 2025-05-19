<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AtividadesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AtividadesTable Test Case
 */
class AtividadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AtividadesTable
     */
    protected $Atividades;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Atividades',
        'app.Projetos',
        'app.Users',
        'app.Aulas',
        'app.Inscricoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Atividades') ? [] : ['className' => AtividadesTable::class];
        $this->Atividades = $this->getTableLocator()->get('Atividades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Atividades);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AtividadesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AtividadesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
