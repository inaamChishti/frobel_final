<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class promoteStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promoteStudents:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command runing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // DB::table('users')
        // ->where('id', '=', 1)
        // ->update(['name' =>'ab']);

        DB::table('students')
        ->where('years_in_school', '<', 13)
        ->update(['years_in_school' => DB::raw('years_in_school + 1')]);
        $this->info('success');
    }
}
