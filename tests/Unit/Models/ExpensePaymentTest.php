<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\User;
use App\Models\VariableExpense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ExpensePaymentTest extends TestCase
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

    private function createFixedExpense(array $overrides = []): FixedExpense
    {
        return FixedExpense::create(array_merge([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Aluguel',
            'amount' => 1500.00,
            'start_date' => now()->startOfMonth(),
            'months_valid' => 12,
            'status' => true,
        ], $overrides));
    }

    private function createVariableExpense(array $overrides = []): VariableExpense
    {
        return VariableExpense::create(array_merge([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Jantar',
            'amount' => 150.00,
            'expense_date' => now(),
        ], $overrides));
    }

    public function test_create_for_fixed_expense(): void
    {
        $expense = $this->createFixedExpense();

        $payment = ExpensePayment::createForFixedExpense($expense, 9, 2026);

        $this->assertDatabaseHas('expense_payments', [
            'user_id' => $this->user->id,
            'fixed_expense_id' => $expense->id,
            'month' => 9,
            'year' => 2026,
            'paid' => false,
        ]);
    }

    public function test_create_for_fixed_expense_does_not_duplicate(): void
    {
        $expense = $this->createFixedExpense();

        $payment1 = ExpensePayment::createForFixedExpense($expense, 9, 2026);
        $payment2 = ExpensePayment::createForFixedExpense($expense, 9, 2026);

        $this->assertEquals($payment1->id, $payment2->id);
        $this->assertCount(1, ExpensePayment::where('fixed_expense_id', $expense->id)->get());
    }

    public function test_create_for_variable_expense(): void
    {
        $expense = $this->createVariableExpense();

        $payment = ExpensePayment::createForVariableExpense($expense, 9, 2026);

        $this->assertDatabaseHas('expense_payments', [
            'user_id' => $this->user->id,
            'variable_expense_id' => $expense->id,
            'month' => 9,
            'year' => 2026,
            'paid' => false,
        ]);
    }

    public function test_scope_by_month(): void
    {
        $expense = $this->createFixedExpense(['description' => 'Internet', 'amount' => 100.00]);

        ExpensePayment::createForFixedExpense($expense, 9, 2026);
        ExpensePayment::createForFixedExpense($expense, 10, 2026);

        $this->assertCount(1, ExpensePayment::byMonth(9, 2026)->get());
        $this->assertCount(1, ExpensePayment::byMonth(10, 2026)->get());
        $this->assertCount(0, ExpensePayment::byMonth(11, 2026)->get());
    }

    public function test_scope_paid_and_unpaid(): void
    {
        $expense = $this->createFixedExpense(['description' => 'Internet', 'amount' => 100.00]);

        $payment = ExpensePayment::createForFixedExpense($expense, 9, 2026);

        $this->assertCount(1, ExpensePayment::unpaid()->get());
        $this->assertCount(0, ExpensePayment::paid()->get());

        $payment->update(['paid' => true]);

        $this->assertCount(0, ExpensePayment::unpaid()->get());
        $this->assertCount(1, ExpensePayment::paid()->get());
    }

    public function test_expense_type_attribute(): void
    {
        $fixedExpense = $this->createFixedExpense();
        $payment = ExpensePayment::createForFixedExpense($fixedExpense, 9, 2026);
        $this->assertEquals('Fixa', $payment->expense_type);

        $variableExpense = $this->createVariableExpense();
        $payment2 = ExpensePayment::createForVariableExpense($variableExpense, 9, 2026);
        $this->assertEquals('Variável', $payment2->expense_type);
    }

    public function test_expense_attribute_returns_related_expense(): void
    {
        $fixedExpense = $this->createFixedExpense();

        $payment = ExpensePayment::createForFixedExpense($fixedExpense, 9, 2026);
        $payment->load('fixedExpense');

        $this->assertEquals('Aluguel', $payment->expense->description);
    }
}
