<?php

namespace Tests\Unit\Observers;

use App\Models\Category;
use App\Models\FixedExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FixedExpenseObserverTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
        $this->category = Category::create(['user_id' => $this->user->id, 'name' => 'Geral']);
    }

    public function test_calculates_end_date_from_start_date_and_months_valid(): void
    {
        $expense = FixedExpense::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Plano de Saúde',
            'amount' => 500.00,
            'start_date' => '2026-01-01',
            'months_valid' => 12,
            'status' => true,
        ]);

        $this->assertEquals(
            Carbon::parse('2027-01-01')->toDateString(),
            $expense->fresh()->end_date->toDateString()
        );
    }

    public function test_does_not_set_end_date_when_months_valid_is_zero(): void
    {
        $expense = FixedExpense::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Aluguel',
            'amount' => 1500.00,
            'start_date' => '2026-01-01',
            'months_valid' => 0,
            'status' => true,
        ]);

        $this->assertNull($expense->fresh()->end_date);
    }

    public function test_recalculates_end_date_on_update(): void
    {
        $expense = FixedExpense::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Plano',
            'amount' => 500.00,
            'start_date' => '2026-01-01',
            'months_valid' => 6,
            'status' => true,
        ]);

        $this->assertEquals(
            Carbon::parse('2026-07-01')->toDateString(),
            $expense->fresh()->end_date->toDateString()
        );

        $expense->update(['months_valid' => 12]);

        $this->assertEquals(
            Carbon::parse('2027-01-01')->toDateString(),
            $expense->fresh()->end_date->toDateString()
        );
    }
}
