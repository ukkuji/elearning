<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (! Schema::hasColumn('courses', 'description')) {
                    $table->text('description')->nullable()->after('title');
                }

                if (! Schema::hasColumn('courses', 'level')) {
                    $table->string('level')->default('Beginner')->after('description');
                }

                if (! Schema::hasColumn('courses', 'duration')) {
                    $table->string('duration')->default('4 Weeks')->after('level');
                }

                if (! Schema::hasColumn('courses', 'price')) {
                    $table->decimal('price', 10, 2)->default(0)->after('duration');
                }

                if (! Schema::hasColumn('courses', 'image_style')) {
                    $table->string('image_style')->default('img-1')->after('price');
                }

                if (! Schema::hasColumn('courses', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable()->after('created_at');
                }
            });

            return;
        }

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('level');
            $table->string('duration');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('image_style')->default('img-1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
