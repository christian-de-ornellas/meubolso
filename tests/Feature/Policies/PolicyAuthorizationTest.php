<?php

namespace Tests\Feature\Policies;

use App\Models\Category;
use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\IncomeCategory;
use App\Models\IncomePayment;
use App\Models\User;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PolicyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $userA;
    private User $userB;
    private Category $categoryA;
    private IncomeCategory $incomeCategoryA;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userA = User::factory()->create();
        $this->userB = User::factory()->create();

        Auth::login($this->userA);
        $this->categoryA = Category::create(['user_id' => $this->userA->id, 'name' => 'Cat A']);
        $this->incomeCategoryA = IncomeCategory::create(['user_id' => $this->userA->id, 'name' => 'Inc Cat A']);
        Auth::logout();
    }

    public function test_user_cannot_view_other_users_category(): void
    {
        $category = Category::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'name' => 'User A Category',
        ]);

        $this->assertFalse($this->userB->can('view', $category));
        $this->assertTrue($this->userA->can('view', $category));
    }

    public function test_user_cannot_update_other_users_category(): void
    {
        $category = Category::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'name' => 'User A Category',
        ]);

        $this->assertFalse($this->userB->can('update', $category));
        $this->assertTrue($this->userA->can('update', $category));
    }

    public function test_user_cannot_delete_other_users_category(): void
    {
        $category = Category::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'name' => 'User A Category',
        ]);

        $this->assertFalse($this->userB->can('delete', $category));
        $this->assertTrue($this->userA->can('delete', $category));
    }

    public function test_user_cannot_access_other_users_income_category(): void
    {
        $category = IncomeCategory::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'name' => 'User A Income Category',
        ]);

        $this->assertFalse($this->userB->can('view', $category));
        $this->assertFalse($this->userB->can('update', $category));
        $this->assertFalse($this->userB->can('delete', $category));
        $this->assertTrue($this->userA->can('view', $category));
    }

    public function test_user_cannot_access_other_users_fixed_expense(): void
    {
        $expense = FixedExpense::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'category_id' => $this->categoryA->id,
            'description' => 'Aluguel',
            'amount' => 1500.00,
            'start_date' => now(),
            'months_valid' => 12,
            'status' => true,
        ]);

        $this->assertFalse($this->userB->can('view', $expense));
        $this->assertFalse($this->userB->can('update', $expense));
        $this->assertFalse($this->userB->can('delete', $expense));
        $this->assertTrue($this->userA->can('view', $expense));
    }

    public function test_user_cannot_access_other_users_variable_expense(): void
    {
        $expense = VariableExpense::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'category_id' => $this->categoryA->id,
            'description' => 'Jantar',
            'amount' => 150.00,
            'expense_date' => now(),
        ]);

        $this->assertFalse($this->userB->can('view', $expense));
        $this->assertFalse($this->userB->can('update', $expense));
        $this->assertFalse($this->userB->can('delete', $expense));
        $this->assertTrue($this->userA->can('view', $expense));
    }

    public function test_user_cannot_access_other_users_fixed_income(): void
    {
        $income = FixedIncome::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'income_category_id' => $this->incomeCategoryA->id,
            'description' => 'Salário',
            'amount' => 5000.00,
            'start_date' => now(),
            'months_valid' => 12,
            'status' => true,
        ]);

        $this->assertFalse($this->userB->can('view', $income));
        $this->assertFalse($this->userB->can('update', $income));
        $this->assertFalse($this->userB->can('delete', $income));
        $this->assertTrue($this->userA->can('view', $income));
    }

    public function test_user_cannot_access_other_users_variable_income(): void
    {
        $income = VariableIncome::withoutGlobalScopes()->create([
            'user_id' => $this->userA->id,
            'income_category_id' => $this->incomeCategoryA->id,
            'description' => 'Freelance',
            'amount' => 2000.00,
            'income_date' => now(),
        ]);

        $this->assertFalse($this->userB->can('view', $income));
        $this->assertFalse($this->userB->can('update', $income));
        $this->assertFalse($this->userB->can('delete', $income));
        $this->assertTrue($this->userA->can('view', $income));
    }

    public function test_user_cannot_access_other_users_expense_payment(): void
    {
        Auth::login($this->userA);

        $expense = FixedExpense::create([
            'user_id' => $this->userA->id,
            'category_id' => $this->categoryA->id,
            'description' => 'Aluguel',
            'amount' => 1500.00,
            'start_date' => now(),
            'months_valid' => 12,
            'status' => true,
        ]);

        $payment = ExpensePayment::createForFixedExpense($expense, 9, 2026);

        $this->assertFalse($this->userB->can('view', $payment));
        $this->assertFalse($this->userB->can('update', $payment));
        $this->assertFalse($this->userB->can('delete', $payment));
        $this->assertTrue($this->userA->can('view', $payment));
    }

    public function test_user_cannot_access_other_users_income_payment(): void
    {
        Auth::login($this->userA);

        $income = FixedIncome::create([
            'user_id' => $this->userA->id,
            'income_category_id' => $this->incomeCategoryA->id,
            'description' => 'Salário',
            'amount' => 5000.00,
            'start_date' => now(),
            'months_valid' => 12,
            'status' => true,
        ]);

        $payment = IncomePayment::createForFixedIncome($income, 9, 2026);

        $this->assertFalse($this->userB->can('view', $payment));
        $this->assertFalse($this->userB->can('update', $payment));
        $this->assertFalse($this->userB->can('delete', $payment));
        $this->assertTrue($this->userA->can('view', $payment));
    }

    public function test_any_user_can_view_any_and_create(): void
    {
        $this->assertTrue($this->userA->can('viewAny', Category::class));
        $this->assertTrue($this->userA->can('create', Category::class));
        $this->assertTrue($this->userA->can('viewAny', IncomeCategory::class));
        $this->assertTrue($this->userA->can('create', IncomeCategory::class));
        $this->assertTrue($this->userA->can('viewAny', ExpensePayment::class));
        $this->assertTrue($this->userA->can('create', ExpensePayment::class));
        $this->assertTrue($this->userA->can('viewAny', IncomePayment::class));
        $this->assertTrue($this->userA->can('create', IncomePayment::class));
    }
}
