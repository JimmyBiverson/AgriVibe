<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['general', 'site_name', 'Agrivibe', 'string', 'Site Name', 'The public name of the platform.', true],
            ['general', 'site_tagline', 'Your trusted digital farming companion', 'string', 'Tagline', null, true],
            ['general', 'support_email', 'support@agrivibe.test', 'string', 'Support Email', null, true],
            ['general', 'support_phone', '+256 700 000 000', 'string', 'Support Phone', null, true],
            ['general', 'default_country', 'UG', 'string', 'Default Country', null, false],
            ['general', 'default_currency', 'UGX', 'string', 'Default Currency', null, true],
            ['general', 'currency_symbol', 'USh', 'string', 'Currency Symbol', null, true],
            ['general', 'default_locale', 'en', 'string', 'Default Language', null, false],
            ['general', 'timezone', 'Africa/Kampala', 'string', 'Timezone', null, false],

            // Registration
            ['registration', 'enabled', '1', 'boolean', 'Registration Enabled', null, false],
            ['registration', 'require_email_verification', '1', 'boolean', 'Require Email Verification', null, false],
            ['registration', 'require_phone_verification', '0', 'boolean', 'Require SMS Verification', null, false],
            ['registration', 'default_account_type', 'farmer', 'string', 'Default Account Type', null, false],

            // Features
            ['features', 'marketplace', '1', 'boolean', 'Marketplace', null, false],
            ['features', 'veterinary_services', '1', 'boolean', 'Veterinary Services', null, false],
            ['features', 'academy', '1', 'boolean', 'Agrivibe Academy', null, false],
            ['features', 'community', '1', 'boolean', 'Community', null, false],
            ['features', 'market_prices', '1', 'boolean', 'Market Prices', null, false],
            ['features', 'sms', '1', 'boolean', 'SMS Services', null, false],
            ['features', 'weather', '1', 'boolean', 'Weather', null, false],

            // SMS
            ['sms', 'gateway', 'log', 'string', 'SMS Gateway', 'Provider key (log, africastalking, twilio...).', false],
            ['sms', 'sender_id', 'AGRIVIBE', 'string', 'Sender ID', null, false],
            ['sms', 'sms_enabled', '0', 'boolean', 'SMS Enabled', null, false],
            ['sms', 'default_cost', '30', 'string', 'Default SMS Cost (UGX)', null, false],

            // Payments
            ['payments', 'enabled', '0', 'boolean', 'Payments Enabled', null, false],
            ['payments', 'gateway', 'manual', 'string', 'Payment Gateway', null, false],
            ['payments', 'commission_rate', '5', 'string', 'Default Commission (%)', null, false],

            // Medical disclaimer
            ['medical', 'disclaimer', 'The health and veterinary information on Agrivibe is for general guidance only and must not replace professional veterinary advice. Always consult a qualified veterinary professional for diagnosis and treatment.', 'text', 'Medical Disclaimer', null, true],
        ];

        foreach ($settings as [$group, $key, $value, $type, $label, $description, $isPublic]) {
            Setting::updateOrCreate(
                ['key' => $key],
                compact('group', 'value', 'type', 'label', 'description') + ['is_public' => $isPublic],
            );
        }
    }
}
