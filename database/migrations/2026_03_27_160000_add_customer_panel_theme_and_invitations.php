<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'panel_bg_color')) {
                $table->string('panel_bg_color', 7)->nullable()->after('pincode');
            }
            if (!Schema::hasColumn('users', 'panel_accent_color')) {
                $table->string('panel_accent_color', 7)->nullable()->after('panel_bg_color');
            }
        });

        if (!Schema::hasTable('user_invitations')) {
            Schema::create('user_invitations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('guest_name');
                $table->string('guest_email')->nullable();
                $table->string('guest_phone')->nullable();
                $table->string('event_title');
                $table->dateTime('event_date')->nullable();
                $table->string('event_location')->nullable();
                $table->text('message');
                $table->string('status', 20)->default('saved');
                $table->dateTime('sent_at')->nullable();
                $table->timestamps();

                $table->index('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('user_invitations')) {
            Schema::dropIfExists('user_invitations');
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'panel_bg_color')) {
                $table->dropColumn('panel_bg_color');
            }
            if (Schema::hasColumn('users', 'panel_accent_color')) {
                $table->dropColumn('panel_accent_color');
            }
        });
    }
};
