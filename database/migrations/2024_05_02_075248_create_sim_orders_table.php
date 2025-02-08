<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderType;
use App\Enums\PaymentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sim_orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Mã đơn hàng');
            // thong tin sim
            $table->string('sim', 10)->comment('Số sim đặt mua');
            $table->unsignedBigInteger('amount')->comment('Giá bán');
            $table->unsignedTinyInteger('telco_id')->comment('Nhà mạng');
            // thong tin khach hang
            $table->string('phone', 15)->comment('Số điện thoại KH');
            $table->string('name')->comment('Tên KH');
            $table->string('address')->comment('Địa chỉ KH');
            $table->string('other_option')->nullable()->comment('Ghi chú đơn hàng KH');
            $table->enum('payment_method', PaymentType::values())->default(PaymentType::COD)->comment('Hình thức thanh toán');
            $table->string('mst', 20)->nullable()->comment('Mã số thuế');
            // thong tin khac
            $table->string('source_text', 20)->default('simthanglong.vn')->comment('Nguồn đơn');
            $table->enum('order_type', OrderType::values())->default(OrderType::COMMON)->comment('Loại đơn');
            $table->json('attributes')->nullable()->comment('Thông tin trả góp');
            $table->boolean('pushed')->default(false)->comment('Push đơn');
            $table->ipAddress('ip')->comment('IP');
            $table->text('browse_history')->nullable()->comment('Lịch sử truy cập mua hàng');
            $table->timestamps();

            $table->index(['sim','phone','telco_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_orders');
    }
};
