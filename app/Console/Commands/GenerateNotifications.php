<?php

namespace App\Console\Commands;

use App\Models\Budget;
use App\Models\ExpensePayment;
use App\Models\FinancialGoal;
use App\Models\FixedExpense;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\BudgetExceededNotification;
use App\Notifications\ExpiringFixedExpenseNotification;
use App\Notifications\GoalMilestoneNotification;
use App\Notifications\UpcomingPaymentNotification;
use App\Notifications\UpcomingSubscriptionNotification;
use Illuminate\Console\Command;

class GenerateNotifications extends Command
{
    protected $signature = 'app:generate-notifications';

    protected $description = 'Gera notificações para eventos financeiros';

    public function handle(): int
    {
        $users = User::all();

        foreach ($users as $user) {
            $this->checkUpcomingPayments($user);
            $this->checkBudgetExceeded($user);
            $this->checkGoalMilestones($user);
            $this->checkExpiringFixedExpenses($user);
            $this->checkUpcomingSubscriptions($user);
        }

        $this->info('Notificações geradas com sucesso.');

        return self::SUCCESS;
    }

    protected function checkUpcomingPayments(User $user): void
    {
        $payments = ExpensePayment::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->unpaid()
            ->currentMonth()
            ->get();

        foreach ($payments as $payment) {
            $notificationId = 'upcoming_payment_' . $payment->id . '_' . now()->format('Y-m');
            if (!$user->notifications()->where('id', $notificationId)->exists()) {
                $user->notify(
                    (new UpcomingPaymentNotification($payment))->setId($notificationId)
                );
            }
        }
    }

    protected function checkBudgetExceeded(User $user): void
    {
        $budgets = Budget::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->currentMonth()
            ->get();

        foreach ($budgets as $budget) {
            if ($budget->percentage_used > 100) {
                $notificationId = 'budget_exceeded_' . $budget->id . '_' . now()->format('Y-m');
                if (!$user->notifications()->where('id', $notificationId)->exists()) {
                    $user->notify(
                        (new BudgetExceededNotification($budget))->setId($notificationId)
                    );
                }
            }
        }
    }

    protected function checkGoalMilestones(User $user): void
    {
        $goals = FinancialGoal::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->active()
            ->get();

        foreach ($goals as $goal) {
            $percentage = $goal->progress_percentage;
            $milestones = [25, 50, 75, 100];

            foreach ($milestones as $milestone) {
                if ($percentage >= $milestone) {
                    $notificationId = 'goal_milestone_' . $goal->id . '_' . $milestone;
                    if (!$user->notifications()->where('id', $notificationId)->exists()) {
                        $user->notify(
                            (new GoalMilestoneNotification($goal, $milestone))->setId($notificationId)
                        );
                    }
                }
            }
        }
    }

    protected function checkExpiringFixedExpenses(User $user): void
    {
        $expenses = FixedExpense::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->expiringSoon(30)
            ->get();

        foreach ($expenses as $expense) {
            $notificationId = 'expiring_expense_' . $expense->id . '_' . now()->format('Y-m');
            if (!$user->notifications()->where('id', $notificationId)->exists()) {
                $user->notify(
                    (new ExpiringFixedExpenseNotification($expense))->setId($notificationId)
                );
            }
        }
    }

    protected function checkUpcomingSubscriptions(User $user): void
    {
        $subscriptions = Subscription::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->upcomingBilling(3)
            ->get();

        foreach ($subscriptions as $subscription) {
            $notificationId = 'upcoming_sub_' . $subscription->id . '_' . $subscription->next_billing_date->format('Y-m-d');
            if (!$user->notifications()->where('id', $notificationId)->exists()) {
                $user->notify(
                    (new UpcomingSubscriptionNotification($subscription))->setId($notificationId)
                );
            }
        }
    }
}
