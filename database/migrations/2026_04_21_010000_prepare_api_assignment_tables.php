<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable()->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student')->after('password');
            }

            if (! Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->after('role');
            }

            if (! Schema::hasColumn('users', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });

        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('image_style');
            }

            if (! Schema::hasColumn('courses', 'instructor_id')) {
                $table->foreignId('instructor_id')->nullable()->after('category_id');
            }
        });

        if (! Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_number')->unique();
                $table->foreignId('user_id');
                $table->foreignId('course_id');
                $table->unsignedInteger('quantity')->default(1);
                $table->decimal('total_price', 10, 2);
                $table->string('status')->default('paid');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');

        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'category_id')) {
                $table->dropColumn('category_id');
            }
        });

        Schema::dropIfExists('categories');
    }
};
