<?php

namespace Maxcelos\Financial\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Maxcelos\Financial\Entities\Account;
use Maxcelos\People\Entities\Tenancy;
use Maxcelos\People\Entities\User;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    public function testListAccounts()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $this->actingAs($user, 'api')->json('get', 'v1/accounts')
            ->assertStatus(200);
    }


    public function testCreateAccount()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $data = factory(Account::class)->make()->toArray();

        $response = $this->actingAs($user, 'api')->json('post', 'v1/accounts', $data);

        $response->assertStatus(201);
    }
    public function testCreateAccountRequest()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $response = $this->actingAs($user, 'api')->json('post', 'v1/accounts', ['name' => 'Teste']);

        $response->assertStatus(422)->assertJsonFragment([
                "message" => "The given data was invalid.",
                "errors" => [
                    "amount" => [
                        0 => "The amount field is required."
                    ]
                ]
            ]
        );
    }

    public function testCreateAccountUuid()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $data = factory(Account::class)->make(['accountable_id' => $user->uuid])->toArray();

        $response = $this->actingAs($user, 'api')->json('post', 'v1/accounts', $data);

        $response->assertStatus(201);
    }

    public function testShowAccount()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $accountResponse = $this->actingAs($user, 'api')->json('post', 'v1/accounts', factory(Account::class)->make()->toArray());

        $account = json_decode($accountResponse->getContent());

        $this->actingAs($user, 'api')->json('get', 'v1/accounts/' . $account->uuid)
            ->assertStatus(200);
    }

    public function testUpdateAccount()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $accountResponse = $this->actingAs($user, 'api')->json('post', 'v1/accounts', factory(Account::class)->make()->toArray());
        $account = json_decode($accountResponse->getContent());

        $newData = factory(Account::class)->make()->toArray();

        $this->actingAs($user, 'api')->json('put', 'v1/accounts/' . $account->uuid, $newData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $newData['name'],
                'amount' => $newData['amount'],
            ]);
    }

    public function testUpdateAccountRequest()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $accountResponse = $this->actingAs($user, 'api')->json('post', 'v1/accounts', factory(Account::class)->make()->toArray());
        $account = json_decode($accountResponse->getContent());

        $response = $this->actingAs($user, 'api')->json('put', 'v1/accounts/' . $account->uuid, ['accountable_id' => 'Teste']);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "accountable_id" => [
                            0 => "Uuid does not exists."
                        ]
                    ]
                ]
            );
    }

    public function testUpdateAccountNotFount()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $accountResponse = $this->actingAs($user, 'api')->json('post', 'v1/accounts', factory(Account::class)->make()->toArray());
        $account = json_decode($accountResponse->getContent());

        $newData = factory(Account::class)->make()->toArray();

        $tenancy = Tenancy::create(['name' => 'Other Tenancy']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        $this->actingAs($user, 'api')->json('put', 'v1/accounts/' . $account->uuid, $newData)
            ->assertStatus(404);
    }

    public function testDeleteAccount()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);
        Auth::loginUsingId($user->id);

        $accountResponse = $this->actingAs($user, 'api')->json('post', 'v1/accounts', factory(Account::class)->make()->toArray());

        $account = json_decode($accountResponse->getContent());

        $this->actingAs($user, 'api')->json('delete', 'v1/accounts/' . $account->uuid)->assertStatus(204);
    }
}
