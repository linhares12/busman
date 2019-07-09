<?php

namespace Maxcelos\Financial\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Maxcelos\Financial\Entities\Category;
use Maxcelos\People\Entities\Tenancy;
use Maxcelos\People\Entities\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testListCategories()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        factory(Category::class, 100)->create(['tenancy_id' => $tenancy->id]);

        $this->actingAs($user, 'api')->json('get', 'v1/categories')
            ->assertStatus(200);
    }


    public function testCreateCategory()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $data = factory(Category::class)->make()->toArray();

        $response = $this->actingAs($user, 'api')->json('post', 'v1/categories', $data);

        $response->assertStatus(201);
    }

    public function testShowCategory()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);

        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $categoryResponse = $this->actingAs($user, 'api')->json('post', 'v1/categories', factory(Category::class)->make()->toArray());

        $category = json_decode($categoryResponse->getContent());

        $this->actingAs($user, 'api')->json('get', 'v1/categories/' . $category->id)
            ->assertStatus(200);
    }

    public function testUpdateCategory()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $categoryResponse = $this->actingAs($user, 'api')->json('post', 'v1/categories', factory(Category::class)->make()->toArray());
        $category = json_decode($categoryResponse->getContent());

        $newData = factory(Category::class)->make()->toArray();

        $this->actingAs($user, 'api')->json('put', 'v1/categories/' . $category->id, $newData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $newData['name'],
                'color' => $newData['color'],
                'type' => $newData['type'],
            ]);
    }

    public function testUpdateOthersCategory()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        Auth::loginUsingId($user->id);

        $categoryResponse = $this->actingAs($user, 'api')->json('post', 'v1/categories', factory(Category::class)->make()->toArray());
        $category = json_decode($categoryResponse->getContent());

        $newData = factory(Category::class)->make()->toArray();

        $tenancy = Tenancy::create(['name' => 'Other Tenancy']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);

        $this->actingAs($user, 'api')->json('put', 'v1/categories/' . $category->id, $newData)
            ->assertStatus(404);
    }

    public function testDeleteCategory()
    {
        $tenancy = Tenancy::create(['name' => 'Teste']);

        $user = factory(User::class)->create(['current_tenancy_id' => $tenancy->id]);
        $user->tenancies()->sync($tenancy->id);
        Auth::loginUsingId($user->id);

        $categoryResponse = $this->actingAs($user, 'api')->json('post', 'v1/categories', factory(Category::class)->make()->toArray());

        $category = json_decode($categoryResponse->getContent());

        $this->actingAs($user, 'api')->json('delete', 'v1/categories/' . $category->id)->assertStatus(204);
    }
}
