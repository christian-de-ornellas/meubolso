<?php

namespace Tests\Unit\Traits;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BelongsToAuthUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_global_scope_filters_by_authenticated_user(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create categories for user1
        Auth::login($user1);
        Category::create(['user_id' => $user1->id, 'name' => 'User1 Category']);

        // Create categories for user2
        Auth::login($user2);
        Category::create(['user_id' => $user2->id, 'name' => 'User2 Category']);

        // user2 should only see their own
        $this->assertCount(1, Category::all());
        $this->assertEquals('User2 Category', Category::first()->name);

        // Switch to user1
        Auth::login($user1);
        $this->assertCount(1, Category::all());
        $this->assertEquals('User1 Category', Category::first()->name);
    }

    public function test_auto_fills_user_id_on_creating(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $category = Category::create(['name' => 'Test Category']);

        $this->assertEquals($user->id, $category->user_id);
    }

    public function test_does_not_override_explicit_user_id(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Auth::login($user1);

        $category = Category::create(['user_id' => $user2->id, 'name' => 'Test']);

        $this->assertEquals($user2->id, $category->user_id);
    }

    public function test_no_scope_when_not_authenticated(): void
    {
        $user = User::factory()->create();

        // Create data as user
        Auth::login($user);
        Category::create(['user_id' => $user->id, 'name' => 'Test']);

        // Logout
        Auth::logout();

        // Without auth, scope should not filter (returns all)
        $this->assertCount(1, Category::all());
    }
}
