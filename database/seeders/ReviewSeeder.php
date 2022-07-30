<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::admin()->first();
        $employees = User::employee()->get();



        foreach ($employees as $employee)
        {
            $review = $user->reviews()->create([
                'employee_id' => $employee->id,
                'review' => 'this review performance for: ' . $employee->name,
            ]);

            $assigns = User::employee()->whereNot('id',$employee->id)->take(2)->get();
            foreach ($assigns as $assign)
            {
                $review->assignments()->attach([
                    'user_id' => $assign->id
                ]);
                $review->feedback()->create([
                    'user_id' => $assign->id,
                    'feedback' => 'this is my feedback for employee: ' .$employee->name
            ]);
            }

        }
    }
}
