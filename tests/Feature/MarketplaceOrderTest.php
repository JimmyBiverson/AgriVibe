<?php

namespace Tests\Feature;

use App\Livewire\Marketplace\ListingBrowser;
use App\Livewire\Marketplace\MyOrders;
use App\Livewire\Marketplace\SellerOrders;
use App\Models\MarketplaceItem;
use App\Models\MarketplaceOrder;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class MarketplaceOrderTest extends TestCase
{
    protected function buyer(): User
    {
        return User::where('email', 'buyer@agrivibe.test')->firstOrFail();
    }

    protected function listing(): MarketplaceItem
    {
        return MarketplaceItem::where('status', 'active')->firstOrFail();
    }

    public function test_buyer_can_place_an_order(): void
    {
        $buyer = $this->buyer();
        $item = MarketplaceItem::where('status', 'active')
            ->where('seller_id', '!=', $buyer->id)
            ->firstOrFail();

        $this->actingAs($buyer);

        Livewire::test(ListingBrowser::class)
            ->call('startOrder', $item->id)
            ->set('data.quantity', 2)
            ->set('data.delivery_method', 'pickup')
            ->set('data.delivery_address', '')
            ->set('data.notes', 'Test order')
            ->call('placeOrder')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('marketplace_orders', [
            'buyer_id' => $buyer->id,
            'seller_id' => $item->seller_id,
            'marketplace_item_id' => $item->id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        MarketplaceOrder::where('buyer_id', $buyer->id)->where('notes', 'Test order')->delete();
    }

    public function test_buyer_cannot_order_their_own_listing(): void
    {
        $item = $this->listing();
        $seller = User::findOrFail($item->seller_id);

        $this->actingAs($seller);

        Livewire::test(ListingBrowser::class)
            ->call('startOrder', $item->id)
            ->assertStatus(403);
    }

    public function test_buyer_can_cancel_a_pending_order(): void
    {
        $buyer = $this->buyer();
        $item = $this->listing();

        $order = MarketplaceOrder::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $item->seller_id,
            'marketplace_item_id' => $item->id,
            'item_title' => $item->title,
            'quantity' => 1,
            'unit' => $item->unit,
            'unit_price' => $item->price,
            'total_amount' => $item->price,
            'status' => 'pending',
        ]);

        $this->actingAs($buyer);

        Livewire::test(MyOrders::class)
            ->call('cancel', $order->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('marketplace_orders', [
            'id' => $order->id,
            'status' => 'cancelled',
        ]);

        $order->delete();
    }

    public function test_seller_can_confirm_and_record_payment(): void
    {
        $item = $this->listing();
        $seller = User::findOrFail($item->seller_id);
        $buyer = $this->buyer();

        $order = MarketplaceOrder::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'marketplace_item_id' => $item->id,
            'item_title' => $item->title,
            'quantity' => 2,
            'unit' => $item->unit,
            'unit_price' => $item->price,
            'total_amount' => (float) $item->price * 2,
            'status' => 'pending',
        ]);

        $this->actingAs($seller);

        Livewire::test(SellerOrders::class)
            ->call('confirm', $order->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('marketplace_orders', ['id' => $order->id, 'status' => 'confirmed']);

        Livewire::test(SellerOrders::class)
            ->call('recordPayment', $order->id)
            ->set('data.amount', (float) $item->price * 2)
            ->set('data.payment_method', 'mobile_money')
            ->set('data.payment_reference', 'TESTMOMO')
            ->call('savePayment')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('marketplace_orders', [
            'id' => $order->id,
            'payment_status' => 'paid',
            'payment_method' => 'mobile_money',
        ]);

        $order->delete();
    }

    public function test_seller_cannot_act_on_another_sellers_order(): void
    {
        $item = $this->listing();
        $seller = User::findOrFail($item->seller_id);
        $buyer = $this->buyer();

        $foreign = MarketplaceOrder::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $buyer->id,
            'marketplace_item_id' => $item->id,
            'item_title' => $item->title,
            'quantity' => 1,
            'unit' => $item->unit,
            'unit_price' => $item->price,
            'total_amount' => $item->price,
            'status' => 'pending',
        ]);

        $this->actingAs($seller);

        Livewire::test(SellerOrders::class)
            ->call('confirm', $foreign->id)
            ->assertStatus(404);

        $this->assertDatabaseHas('marketplace_orders', ['id' => $foreign->id, 'status' => 'pending']);

        $foreign->delete();
    }
}
