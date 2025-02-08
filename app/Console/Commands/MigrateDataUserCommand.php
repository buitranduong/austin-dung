<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MigrateDataUserCommand extends Command
{
    private static array $mapFields = [
        'ID'=>'id',
        'user_nicename'=>'slug',
        'user_email'=>'email',
        'display_name'=>'name'
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:data-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command migrate data user from SimThangLong.vn';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $db = DB::connection('simthaglog_news');
        //dd($db->select('SHOW TABLES'));
        $wp_users = $db->table('wp_users')->get(array_keys(self::$mapFields));
        if($wp_users->count() > 0){
            foreach($wp_users as $wp_user){
                $data = [];
                foreach(self::$mapFields as $key => $value){
                    if(isset($wp_user->$key)){
                        $data[$value] = $wp_user->$key;
                    }
                }
                try {
                    $user = new User();
                    $user->fill($data);
                    $user->password = Hash::make('123456');
                    $user->is_active = 1;
                    $user->saveQuietly();
                    $this->line("User #$user->id add to database");
                }catch (\Exception $exception){
                    continue;
                }
            }
        }
        $this->info("Migrate #{$wp_users->count()} data user from SimThangLong.vn");
    }
}
