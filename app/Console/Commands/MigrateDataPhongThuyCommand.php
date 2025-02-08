<?php

namespace App\Console\Commands;

use App\Enums\PageStatus;
use App\Models\Seo\PageSeo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrateDataPhongThuyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:data-phongthuy {--canchi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command migrate data Phong Thuy from SimThangLong.vn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path('phongthuy');
        if($this->option('canchi')) {
            $arrMapping = [
                'ty'=>'Tý',
                'suu'=>'Sửu',
                'dan'=>'Dần',
                'mao'=>'Mão',
                'thin'=>'Thìn',
                'ti'=>'Tị',
                'ngo'=>'Ngọ',
                'mui'=>'Mùi',
                'than'=>'Thân',
                'dau'=>'Dậu',
                'tuat'=>'Tuất',
                'hoi'=>'Hợi'
            ];
            foreach ($arrMapping as $key => $value) {
                $file = "$path/$key.htm";
                if(file_exists($file))
                {
                    $contents = file_get_contents($file);
                    if(!empty($contents))
                    {
                        try {
                            $seoPage = new PageSeo();
                            $seoPage->title = "Tìm sim phong thủy hợp tuổi $value";
                            $seoPage->h2 = "Sim phong thủy hợp tuổi $value";
                            $seoPage->slug = Str::of("Sim hợp tuổi $value")->slug()->prepend('/');
                            $seoPage->content = $contents;
                            $seoPage->status = PageStatus::Published;
                            $seoPage->published_at = now();
                            $seoPage->meta_data = [
                                'title'=>"Tìm sim phong thủy hợp tuổi $value",
                                'meta'=>[
                                    'description'=>"Tìm sim phong thủy hợp tuổi $value",
                                ]
                            ];
                            $seoPage->save();
                            $this->line("Insert seo page #{$seoPage->id} to database");
                        }catch (\Exception $e){
                            continue;
                        }
                    }
                }
            }
        }else{
            for ($i=2000; $i>=1960; $i--)
            {
                $file = "$path/$i.htm";
                if(file_exists($file))
                {
                    $contents = file_get_contents($file);
                    if(!empty($contents))
                    {
                        try {
                            $seoPage = new PageSeo();
                            $seoPage->title = "Tìm sim phong thủy hợp tuổi $i";
                            $seoPage->h2 = "Sim phong thủy hợp tuổi $i";
                            $seoPage->slug = Str::of("Sim hợp tuổi $i")->slug()->prepend('/');
                            $seoPage->content = $contents;
                            $seoPage->status = PageStatus::Published;
                            $seoPage->published_at = now();
                            $seoPage->meta_data = [
                                'title'=>"Tìm sim phong thủy hợp tuổi $i",
                                'meta'=>[
                                    'description'=>"Tìm sim phong thủy hợp tuổi $i",
                                ]
                            ];
                            $seoPage->save();
                            $this->line("Insert seo page #{$seoPage->id} to database");
                        }catch (\Exception $e){
                            continue;
                        }
                    }
                }
            }
        }
        $this->info('Migrated data Phong Thuy from SimThangLong.vn');
    }
}
