<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;  // لو عاوز تضيف الـ user_id
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,               // عنوان الـ Task
            'description' => $this->faker->paragraph,        // وصف الـ Task
            'due_date' => $this->faker->date(),              // تاريخ الاستحقاق (ممكن تضيف قيود أكتر زي "after:tomorrow")
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']), // الأولوية (ممكن تبقى ثابتة لو عاوز)
            'status' => 'Pending',                            // الحالة الابتدائية
            'user_id' => User::factory(),                     // لو فيه علاقة مع الـ User، هنستخدم Factory للـ User
        ];
    }
}
