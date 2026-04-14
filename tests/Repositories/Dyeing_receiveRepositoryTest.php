<?php namespace Tests\Repositories;

use App\Models\CRM\Dyeing_receive;
use App\Repositories\CRM\Dyeing_receiveRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Dyeing_receiveRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Dyeing_receiveRepository
     */
    protected $dyeingReceiveRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->dyeingReceiveRepo = \App::make(Dyeing_receiveRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->make()->toArray();

        $createdDyeing_receive = $this->dyeingReceiveRepo->create($dyeingReceive);

        $createdDyeing_receive = $createdDyeing_receive->toArray();
        $this->assertArrayHasKey('id', $createdDyeing_receive);
        $this->assertNotNull($createdDyeing_receive['id'], 'Created Dyeing_receive must have id specified');
        $this->assertNotNull(Dyeing_receive::find($createdDyeing_receive['id']), 'Dyeing_receive with given id must be in DB');
        $this->assertModelData($dyeingReceive, $createdDyeing_receive);
    }

    /**
     * @test read
     */
    public function test_read_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();

        $dbDyeing_receive = $this->dyeingReceiveRepo->find($dyeingReceive->id);

        $dbDyeing_receive = $dbDyeing_receive->toArray();
        $this->assertModelData($dyeingReceive->toArray(), $dbDyeing_receive);
    }

    /**
     * @test update
     */
    public function test_update_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();
        $fakeDyeing_receive = Dyeing_receive::factory()->make()->toArray();

        $updatedDyeing_receive = $this->dyeingReceiveRepo->update($fakeDyeing_receive, $dyeingReceive->id);

        $this->assertModelData($fakeDyeing_receive, $updatedDyeing_receive->toArray());
        $dbDyeing_receive = $this->dyeingReceiveRepo->find($dyeingReceive->id);
        $this->assertModelData($fakeDyeing_receive, $dbDyeing_receive->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();

        $resp = $this->dyeingReceiveRepo->delete($dyeingReceive->id);

        $this->assertTrue($resp);
        $this->assertNull(Dyeing_receive::find($dyeingReceive->id), 'Dyeing_receive should not exist in DB');
    }
}
