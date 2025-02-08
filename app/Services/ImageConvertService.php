<?php

namespace App\Services;

use App\Settings\ImageSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;

class ImageConvertService
{
    private UploadedFile $file;
    private ImageInterface $image;
    private ImageManager $imageManager;
    public function __construct(Driver $driver, private readonly ImageSetting $imageSetting)
    {
        $this->imageManager = new ImageManager($driver);
    }

    public function fromFile(UploadedFile $file): static
    {
        $this->file = $file;
        return $this;
    }

    public function fromPath(string $path): static
    {
        $this->image = @$this->imageManager->read($path);
        return $this;
    }

    private function _getFilename(): string
    {
        return Str::of($this->file->getClientOriginalName())
            ->basename(".{$this->file->getClientOriginalExtension()}")
            ->slug();
    }

    private function _setFilename(int $with = 0, int $height = 0): string
    {
        if($with || $height){
            return "{$this->_getFilename()}-{$with}x{$height}.{$this->imageSetting->extension}";
        }else{
            return "{$this->_getFilename()}.{$this->imageSetting->extension}";
        }
    }
    public function convertFeaturedSize(string $savePath, bool $delete = false): string
    {
        if(isset($this->file)){
            $destinationPath = "{$savePath}/{$this->_setFilename($this->imageSetting->width_featured, $this->imageSetting->height_featured)}";
        }else {
            $file = pathinfo($this->image->origin()->filePath(), PATHINFO_FILENAME);
            $file = Str::of($file)->slug();
            $destinationPath = "{$savePath}/$file-{$this->imageSetting->width_featured}x{$this->imageSetting->height_featured}.{$this->imageSetting->extension}";
        }
        $this->image->cover(
            $this->imageSetting->width_featured,
            $this->imageSetting->height_featured,
        )
            ->toWebp(100)
            ->save($destinationPath);
        if($delete){
            File::delete($this->image->origin()->filePath());
        }
        return $destinationPath;
    }

    public function convertThumbnailSize(string $savePath, bool $delete = false): string
    {
        if(isset($this->file)){
            $destinationPath = "{$savePath}/{$this->_setFilename($this->imageSetting->width_thumbnail, $this->imageSetting->height_thumbnail)}";
        }else {
            $file = pathinfo($this->image->origin()->filePath(), PATHINFO_FILENAME);
            $file = Str::of($file)->slug();
            $destinationPath = "{$savePath}/$file-{$this->imageSetting->width_thumbnail}x{$this->imageSetting->height_thumbnail}.{$this->imageSetting->extension}";
        }
        $this->image->cover(
            $this->imageSetting->width_thumbnail,
            $this->imageSetting->height_thumbnail,
        )
            ->toWebp(100)
            ->save($destinationPath);
        if($delete){
            File::delete($this->image->origin()->filePath());
        }
        return $destinationPath;
    }

    public function convertSmallSize(string $savePath, bool $delete = false): string
    {
        if(isset($this->file)){
            $destinationPath = "{$savePath}/{$this->_setFilename($this->imageSetting->width_small, $this->imageSetting->height_small)}";
        }else {
            $file = pathinfo($this->image->origin()->filePath(), PATHINFO_FILENAME);
            $file = Str::of($file)->slug();
            $destinationPath = "{$savePath}/$file-{$this->imageSetting->width_small}x{$this->imageSetting->height_small}.{$this->imageSetting->extension}";
        }
        $this->image->cover(
            $this->imageSetting->width_small,
            $this->imageSetting->height_small,
        )
            ->toWebp(100)
            ->save($destinationPath);
        if($delete){
            File::delete($this->image->origin()->filePath());
        }
        return $destinationPath;
    }

    public function convertAllSize(string $savePath): string
    {
        $origin = $this->convertFitSize($savePath, false);
        $this->convertFeaturedSize($savePath);
        $this->convertThumbnailSize($savePath);
        $this->convertSmallSize($savePath);
        return $origin;
    }

    public function convertFitSize(string $savePath, bool $delete = true): string
    {
        if(isset($this->file)){
            $destinationPath = "{$savePath}/{$this->_setFilename()}";
        }else {
            $file = pathinfo($this->image->origin()->filePath(), PATHINFO_FILENAME);
            $file = Str::of($file)->slug();
            $destinationPath = "{$savePath}/$file.{$this->imageSetting->extension}";
        }
        //$size = $this->image->size();
        //$ratio = $size->aspectRatio();
        //$this->image->resize(611, (611/$ratio))
        $this->image->toWebp(100)
            ->save($destinationPath);
        if($delete){
            File::delete($this->image->origin()->filePath());
        }
        return $destinationPath;
    }

    public function genSimCard(array $sim): string
    {
        // path df sim card
        $path = public_path('static/images/sim-card');
        $telcoText = Str::of($sim['telcoText'])->trim()->ucfirst();
        // get telco card if exist
        $dfCard = "$path/df-$telcoText.jpeg";
        if(file_exists($dfCard))
        {
            // read card image
            $this->fromPath($dfCard);
            // draw background
            $this->image->drawPolygon(function (PolygonFactory $polygon) {
                $polygon->point(420, 200);
                $polygon->point(900, 280);
                $polygon->point(860, 500);
                $polygon->point(380, 420);
                $polygon->background('#fff');
                $polygon->border('#000', 1);
            });
            // write text sim number
            $number = Str::of($sim['highlight'])->stripTags();
            $this->image->text($number, 650, 280, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(70);
                $font->color('000');
                $font->align('center');
                $font->valign('middle');
                $font->lineHeight(1.6);
                $font->angle(10);
            });
            // write price
            $price = format_money($sim['sell_price'] ?? $sim['pn']);
            $this->image->text(($sim['pn'] > 0 ? "Giá: $price" : 'Đã bán'), 430, 300, function (FontFactory $font) use ($path, $sim) {
                $font->filename("$path/Arial.ttf");
                $font->size(30);
                $font->color('red');
                $font->align('left');
                $font->valign('middle');
                $font->lineHeight(1.6);
                $font->angle(10);
            });
            // write fix text source
            $this->image->text('Kho: SIMTHANGLONG.VN', 423, 340, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(30);
                $font->color('000');
                $font->align('left');
                $font->valign('middle');
                $font->lineHeight(1.6);
                $font->angle(10);
            });
            // write sim type
            $this->image->text("Loại sim: {$sim['categoryText']}", 416, 380, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(30);
                $font->color('000');
                $font->align('left');
                $font->valign('middle');
                $font->lineHeight(1.6);
                $font->angle(10);
            });
            $this->image->place(
                "$path/simthanglong2.png",
                'bottom-right',
                120,
                180,
            );
            $size = $this->image->size();
            $ratio = $size->aspectRatio();
            return $this->image->resize(500, (500/$ratio))->toWebp();
        }
        return '';
    }

    public function genSimCardNew(array $sim): string
    {
        // path df sim card
        $path = public_path('static/images/sim-card');
        $telcoText = Str::of($sim['telcoText'])->trim()->ucfirst();
        // get telco card if exist
        $dfCard = "$path/df-$telcoText.png";
        if(file_exists($dfCard))
        {
            $decan = $this->imageManager->create(724, 514);
            // draw background
            $decan->drawPolygon(function (PolygonFactory $polygon) {
                $polygon->point(0, 0);
                $polygon->point(723, 0);
                $polygon->point(723, 513);
                $polygon->point(0, 513);
                $polygon->background('#f1f1f1');
            });
            $decan->drawPolygon(function (PolygonFactory $polygon){
                $polygon->point(10, 10);
                $polygon->point(714, 10);
                $polygon->point(714, 504);
                $polygon->point(10, 504);
                $polygon->background('#f1f1f1');
                $polygon->border('#000', 3);
            });
            // write text sim number
            $number = Str::of($sim['highlight'])->stripTags();
            $decan->text($number, 28, 70, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(100);
                $font->color('000');
                $font->align('left');
                $font->valign('middle');
                $font->stroke('000');
                $font->lineHeight(1.6);
                $font->angle(0);
            });
            // write price
            $price = format_money($sim['sell_price'] ?? $sim['pn']);
            $decan->text(($sim['pn'] > 0 ? "Giá: $price" : 'Đã bán'), 28, 160, function (FontFactory $font) use ($path, $sim) {
                $font->filename("$path/Arial.ttf");
                $font->size(70);
                $font->color('red');
                $font->align('left');
                $font->valign('middle');
                $font->stroke('red');
                $font->lineHeight(1.6);
                $font->angle(0);
            });
            // write fix text source
            $decan->text('Kho: SIMTHANGLONG.VN', 30, 235, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(50);
                $font->color('000');
                $font->align('left');
                $font->valign('middle');
                $font->stroke('000');
                $font->lineHeight(1.6);
                $font->angle(0);
            });
            // write sim type
            $decan->text("Kiểu số đẹp: {$sim['categoryText']}", 30, 300, function (FontFactory $font) use ($path) {
                $font->filename("$path/Arial.ttf");
                $font->size(45);
                $font->color('000');
                $font->align('left');
                $font->valign('middle');
                $font->stroke('000');
                $font->lineHeight(1.6);
                $font->angle(0);
            });
            $decan->place(
                "$path/con-dau-stl.png",
                'bottom-right',
                150,
                20
            );
            $decan->rotate(rand(-2, 2), 'transparent');
            // read card image
            $this->fromPath($dfCard);
            $posDecan = [
                'Mobifone'=>200,
                'Vinaphone'=>280,
                'Viettel'=>100,
                'Gmobile'=>400
            ];
            $offsetY = $posDecan[$telcoText->toString()] ?? $posDecan['Vinaphone'];
            $this->image->place(
                $decan,
                'top-right',
                $telcoText->toString() == 'Gmobile' ? 70 : 140,
                $offsetY,
            );
            $size = $this->image->size();
            $ratio = $size->aspectRatio();
            return $this->image->resize(700, (700/$ratio))->toWebp();
        }
        return '';
    }
}
