<?php

namespace App\Console\Commands;

use App\Models\Seo\PageSeo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class MakeCachePageSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo-page:make-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command make page seo cache for user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $baseUrl = URL::to('/'); // Get the base URL of the site
        $pageSeos = PageSeo::published()->get(['slug']);
        foreach ($pageSeos as $page) {
            $slug = Str::ltrim($page->slug, '/');
            Http::get("https://simthanglong.vn/".$slug);
            usleep(10000); // Delay for 5 milliseconds
        }
        $date = date('m/d/Y h:i:s a', time());
        $this->info("MakeCachePageSeoCommand >> Done make cache for page seo at: {$date}");
    }
    public function handle1()
    {
        $startTime = time(); // Get the current timestamp
        $endTime = $startTime + (3 * 60 * 60); // Add 3 hours to the start time
        while (time() < $endTime) {
            // $baseUrl = URL::to('/'); // Get the base URL of the site
            $number = 0;
            // $pageSeos = PageSeo::published()->select('slug')->get();
            for ($number =0;$number<60000; $number++) {
                $formattedNumber = str_pad($number++, 5, '0', STR_PAD_LEFT);
                Http::get("https://prod.simthanglong.vn/tim-sim/".$number.".html");
                $this->info("MakeCachePageSeoCommand1 >>https://prod.simthanglong.vn/tim-sim/{$formattedNumber}.html");
                usleep(20000); // Delay for 40 milliseconds
            }
            sleep(5); // Delay for 1 minute before starting the next round
        }
        $this->info("MakeCachePageSeoCommand >> Done make cache for page seo");
    }
}
