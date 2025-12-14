<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('work_orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Creator

        // ✅ ADD THIS: The person assigned to fix it (Nullable because it starts unassigned)
        $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

        $table->string('title');
        $table->text('description');
        $table->string('category');
        $table->string('priority')->default('Medium');
        $table->string('status')->default('Pending');

        // ✅ ADD THIS: Referenced in your Controller
        $table->date('due_date')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('work_orders', 'due_date')) {
                $table->dropColumn('due_date');
            }
            if (Schema::hasColumn('work_orders', 'overdue_notified')) {
                $table->dropColumn('overdue_notified');
            }
        });

        Schema::dropIfExists('work_orders');
    }
};
