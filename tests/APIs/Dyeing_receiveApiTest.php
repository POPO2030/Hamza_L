<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CRM\Dyeing_receive;

class Dyeing_receiveApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/dyeing_receives', $dyeingReceive
        );

        $this->assertApiResponse($dyeingReceive);
    }

    /**
     * @test
     */
    public function test_read_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/dyeing_receives/'.$dyeingReceive->id
        );

        $this->assertApiResponse($dyeingReceive->toArray());
    }

    /**
     * @test
     */
    public function test_update_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();
        $editedDyeing_receive = Dyeing_receive::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/dyeing_receives/'.$dyeingReceive->id,
            $editedDyeing_receive
        );

        $this->assertApiResponse($editedDyeing_receive);
    }

    /**
     * @test
     */
    public function test_delete_dyeing_receive()
    {
        $dyeingReceive = Dyeing_receive::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/dyeing_receives/'.$dyeingReceive->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/dyeing_receives/'.$dyeingReceive->id
        );

        $this->response->assertStatus(404);
    }
}
