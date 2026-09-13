<?php

namespace Tests\Unit\Models;

use App\Models\FixedIncome;
use App\Models\IncomeCategory;
use App\Models\IncomePayment;
use App\Models\User;
use App\Models\VariableIncome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IncomePaymentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private IncomeCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
        $this->category = IncomeCategory::create(['user_id' => $this->user->id, 'name' => 'Geral']);
    }

    private function createFixedIncome(array $overrides = []): FixedIncome
    {
        return FixedIncome::create(array_merge([
            'user_id' => $this->user->id,
            'income_category_id' => $this->category->id,
            'description' => 'Salário',
            'amount' => 5000.00,
            'start_date' => now()->startOfMonth(),
            'months_valid' => 12,
            'status' => true,
        ], $overrides));
    }

    private function createVariableIncome(array $overrides = []): VariableIncome
    {
        return VariableIncome::create(array_merge([
            'user_id' => $this->user->id,
            'income_category_id' => $this->category->id,
            'description' => 'Freelance',
            'amount' => 2000.00,
            'income_date' => now(),
        ], $overrides));
    }

    public function test_create_for_fixed_income(): void
    {
        $income = $this->createFixedIncome();

        $payment = IncomePayment::createForFixedIncome($income, 9, 2026);

        $this->assertDatabaseHas('income_payments', [
            'user_id' => $this->user->id,
            'fixed_income_id' => $income->id,
            'month' => 9,
            'year' => 2026,
            'received' => false,
        ]);
    }

    public function test_create_for_fixed_income_does_not_duplicate(): void
    {
        $income = $this->createFixedIncome();

        $payment1 = IncomePayment::createForFixedIncome($income, 9, 2026);
        $payment2 = IncomePayment::createForFixedIncome($income, 9, 2026);

        $this->assertEquals($payment1->id, $payment2->id);
        $this->assertCount(1, IncomePayment::where('fixed_income_id', $income->id)->get());
    }

    public function test_create_for_variable_income(): void
    {
        $income = $this->createVariableIncome();

        $payment = IncomePayment::createForVariableIncome($income, 9, 2026);

        $this->assertDatabaseHas('income_payments', [
            'user_id' => $this->user->id,
            'variable_income_id' => $income->id,
            'month' => 9,
            'year' => 2026,
            'received' => false,
        ]);
    }

    public function test_scope_by_month(): void
    {
        $income = $this->createFixedIncome();

        IncomePayment::createForFixedIncome($income, 9, 2026);
        IncomePayment::createForFixedIncome($income, 10, 2026);

        $this->assertCount(1, IncomePayment::byMonth(9, 2026)->get());
        $this->assertCount(1, IncomePayment::byMonth(10, 2026)->get());
        $this->assertCount(0, IncomePayment::byMonth(11, 2026)->get());
    }

    public function test_scope_received_and_unreceived(): void
    {
        $income = $this->createFixedIncome();

        $payment = IncomePayment::createForFixedIncome($income, 9, 2026);

        $this->assertCount(1, IncomePayment::unreceived()->get());
        $this->assertCount(0, IncomePayment::received()->get());

        $payment->update(['received' => true]);

        $this->assertCount(0, IncomePayment::unreceived()->get());
        $this->assertCount(1, IncomePayment::received()->get());
    }

    public function test_income_type_attribute(): void
    {
        $fixedIncome = $this->createFixedIncome();
        $payment = IncomePayment::createForFixedIncome($fixedIncome, 9, 2026);
        $this->assertEquals('Fixa', $payment->income_type);

        $variableIncome = $this->createVariableIncome();
        $payment2 = IncomePayment::createForVariableIncome($variableIncome, 9, 2026);
        $this->assertEquals('Variável', $payment2->income_type);
    }

    public function test_income_attribute_returns_related_income(): void
    {
        $fixedIncome = $this->createFixedIncome();

        $payment = IncomePayment::createForFixedIncome($fixedIncome, 9, 2026);
        $payment->load('fixedIncome');

        $this->assertEquals('Salário', $payment->income->description);
    }

    public function test_month_name_attribute(): void
    {
        $income = $this->createFixedIncome();

        $payment = IncomePayment::createForFixedIncome($income, 1, 2026);
        $this->assertEquals('Janeiro', $payment->month_name);

        $payment2 = IncomePayment::createForFixedIncome($income, 12, 2026);
        $this->assertEquals('Dezembro', $payment2->month_name);
    }
}
