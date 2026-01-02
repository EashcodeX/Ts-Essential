<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPackingDispatchedEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $templates = [
            [
                'identifier' => 'order_packing_email_to_customer',
                'subject' => 'Your Order [[order_code]] is Packing',
                'default_text' => '<p>Hello [[customer_name]],</p><p>Your order with code <b>[[order_code]]</b> is now being packed and prepared for shipment.</p><p>You can track your order status <a href="' . url('/track-your-order') . '">here</a>.</p><p>Thanks for shopping with [[store_name]]!</p>',
                'status' => 1,
                'group' => 'order'
            ],
            [
                'identifier' => 'order_packing_email_to_admin',
                'subject' => 'Order [[order_code]] is Packing',
                'default_text' => '<p>Hello [[admin_name]],</p><p>The order <b>[[order_code]]</b> is now marked as Packing.</p>',
                'status' => 1,
                'group' => 'order'
            ],
            [
                'identifier' => 'order_packing_email_to_seller',
                'subject' => 'Order [[order_code]] is Packing',
                'default_text' => '<p>Hello [[shop_name]],</p><p>The order <b>[[order_code]]</b> is now marked as Packing.</p>',
                'status' => 1,
                'group' => 'order'
            ],
            [
                'identifier' => 'order_dispatched_email_to_customer',
                'subject' => 'Your Order [[order_code]] has been Dispatched',
                'default_text' => '<p>Hello [[customer_name]],</p><p>Good news! Your order <b>[[order_code]]</b> has been dispatched and is making its way to you.</p><p>You can track your order status <a href="' . url('/track-your-order') . '">here</a>.</p><p>Thanks for shopping with [[store_name]]!</p>',
                'status' => 1,
                'group' => 'order'
            ],
            [
                'identifier' => 'order_dispatched_email_to_admin',
                'subject' => 'Order [[order_code]] has been Dispatched',
                'default_text' => '<p>Hello [[admin_name]],</p><p>The order <b>[[order_code]]</b> has been successfully dispatched.</p>',
                'status' => 1,
                'group' => 'order'
            ],
            [
                'identifier' => 'order_dispatched_email_to_seller',
                'subject' => 'Order [[order_code]] has been Dispatched',
                'default_text' => '<p>Hello [[shop_name]],</p><p>The order <b>[[order_code]]</b> has been successfully dispatched.</p>',
                'status' => 1,
                'group' => 'order'
            ],
        ];

        foreach ($templates as $template) {
            // Check if exists to avoid duplicates
            if (!DB::table('email_templates')->where('identifier', $template['identifier'])->exists()) {
                DB::table('email_templates')->insert([
                    'identifier' => $template['identifier'],
                    'subject' => $template['subject'],
                    'default_text' => $template['default_text'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $identifiers = [
            'order_packing_email_to_customer',
            'order_packing_email_to_admin',
            'order_packing_email_to_seller',
            'order_dispatched_email_to_customer',
            'order_dispatched_email_to_admin',
            'order_dispatched_email_to_seller',
        ];

        DB::table('email_templates')->whereIn('identifier', $identifiers)->delete();
    }
}
