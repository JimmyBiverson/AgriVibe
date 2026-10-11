<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'country_code' => env('AGRIVIBE_DEFAULT_COUNTRY', 'UG'),
        'currency' => env('AGRIVIBE_DEFAULT_CURRENCY', 'UGX'),
        'locale' => env('AGRIVIBE_DEFAULT_LOCALE', 'en'),
        'timezone' => env('APP_TIMEZONE', 'Africa/Kampala'),
        'currency_symbol' => 'USh',
    ],

    /*
    |--------------------------------------------------------------------------
    | Account types (self-registration personas)
    |--------------------------------------------------------------------------
    | Keyed by slug. Each type declares its onboarding fields and the default
    | role(s) granted on verification.
    */
    'account_types' => [
        'farmer' => [
            'label' => 'Individual Farmer',
            'description' => 'Manage your own farm, animals, crops and finances.',
            'roles' => ['farmer'],
        ],
        'commercial_farm' => [
            'label' => 'Commercial Farm',
            'description' => 'Run a large or multiple-enterprise farm business.',
            'roles' => ['farmer', 'farm_owner'],
        ],
        'farm_manager' => [
            'label' => 'Farm Manager',
            'description' => 'Oversee a farm on behalf of an owner.',
            'roles' => ['farm_manager'],
        ],
        'farm_worker' => [
            'label' => 'Farm Worker',
            'description' => 'Record daily farm activities.',
            'roles' => ['field_worker'],
        ],
        'buyer' => [
            'label' => 'Buyer',
            'description' => 'Source produce, livestock and farm products.',
            'roles' => ['buyer'],
        ],
        'supplier' => [
            'label' => 'Supplier',
            'description' => 'Sell farm inputs, feed, equipment and supplies.',
            'roles' => ['supplier'],
        ],
        'veterinarian' => [
            'label' => 'Veterinary Professional',
            'description' => 'Offer animal health services and consultations.',
            'roles' => ['veterinarian'],
            'requires_verification' => true,
        ],
        'trainer' => [
            'label' => 'Agricultural Trainer',
            'description' => 'Create and deliver training courses.',
            'roles' => ['trainer'],
            'requires_verification' => true,
        ],
        'extension_officer' => [
            'label' => 'Extension Officer',
            'description' => 'Support farmers with expert guidance.',
            'roles' => ['extension_officer'],
            'requires_verification' => true,
        ],
        'transporter' => [
            'label' => 'Transporter',
            'description' => 'Provide transport and logistics services.',
            'roles' => ['transporter'],
        ],
        'financial_institution' => [
            'label' => 'Financial Institution',
            'description' => 'Offer finance and credit products.',
            'roles' => ['financial_institution'],
            'requires_verification' => true,
        ],
        'insurer' => [
            'label' => 'Insurance Provider',
            'description' => 'Offer agricultural insurance products.',
            'roles' => ['insurer'],
            'requires_verification' => true,
        ],
        'cooperative' => [
            'label' => 'Cooperative / Farmer Group',
            'description' => 'Manage a collective of farmers.',
            'roles' => ['cooperative'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'platform' => [
            'super_admin' => 'Super Administrator',
            'admin' => 'Platform Administrator',
        ],
        'farm' => [
            'farm_owner' => 'Farm Owner',
            'farm_manager' => 'Farm Manager',
            'accountant' => 'Accountant',
            'veterinarian' => 'Veterinary Professional',
            'storekeeper' => 'Storekeeper',
            'field_worker' => 'Field Worker',
            'sales_officer' => 'Sales Officer',
            'viewer' => 'Viewer',
        ],
        'community' => [
            'farmer' => 'Farmer',
            'buyer' => 'Buyer',
            'supplier' => 'Supplier',
            'trainer' => 'Trainer',
            'extension_officer' => 'Extension Officer',
            'transporter' => 'Transporter',
            'financial_institution' => 'Financial Institution',
            'insurer' => 'Insurance Provider',
            'cooperative' => 'Cooperative / Group',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    | resource => [actions]
    */
    'permissions' => [
        // Platform administration
        'platform' => ['manage_platform', 'manage_users', 'manage_roles', 'manage_settings', 'view_audit'],
        'content' => ['manage_content', 'manage_media', 'publish_content'],
        'marketplace_admin' => ['manage_marketplace', 'moderate_listings', 'manage_orders', 'manage_payments'],
        'verification' => ['manage_verifications'],
        'community_admin' => ['moderate_community', 'manage_reports'],
        'communications' => ['manage_sms', 'manage_notifications', 'manage_subscriptions'],
        'analytics' => ['view_platform_reports', 'export_platform_reports'],

        // Farm-scoped
        'farm' => ['farm.view', 'farm.manage', 'farm.delete', 'member.manage'],
        'animal' => ['animal.view', 'animal.create', 'animal.update', 'animal.delete'],
        'batch' => ['batch.view', 'batch.create', 'batch.update', 'batch.delete'],
        'health' => ['health.view', 'health.create', 'health.update', 'health.delete'],
        'vaccination' => ['vaccination.view', 'vaccination.create', 'vaccination.update', 'vaccination.delete'],
        'breeding' => ['breeding.view', 'breeding.create', 'breeding.update'],
        'production' => ['production.view', 'production.create', 'production.update', 'production.delete'],
        'feed' => ['feed.view', 'feed.create', 'feed.update', 'feed.delete'],
        'inventory' => ['inventory.view', 'inventory.create', 'inventory.update', 'inventory.delete'],
        'finance' => ['finance.view', 'finance.create', 'finance.update', 'finance.delete'],
        'sales' => ['sales.view', 'sales.create', 'sales.update', 'sales.delete'],
        'purchase' => ['purchase.view', 'purchase.create', 'purchase.update'],
        'task' => ['task.view', 'task.create', 'task.update', 'task.delete'],
        'report' => ['report.view', 'report.export'],

        // User-facing services
        'marketplace' => ['listing.view', 'listing.create', 'listing.update', 'listing.delete', 'order.view', 'order.create'],
        'vetservice' => ['vet.search', 'vet.book'],
        'training' => ['course.view', 'course.enroll', 'course.manage'],
        'community' => ['forum.view', 'forum.post', 'forum.comment'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role → permission map
    |--------------------------------------------------------------------------
    */
    'role_permissions' => [
        'super_admin' => ['*'],

        'admin' => [
            'platform.manage_users', 'platform.manage_roles', 'platform.manage_settings', 'platform.view_audit',
            'content.manage_content', 'content.manage_media', 'content.publish_content',
            'marketplace_admin.manage_marketplace', 'marketplace_admin.moderate_listings', 'marketplace_admin.manage_orders', 'marketplace_admin.manage_payments',
            'verification.manage_verifications', 'community_admin.moderate_community', 'community_admin.manage_reports',
            'communications.manage_sms', 'communications.manage_notifications', 'communications.manage_subscriptions',
            'analytics.view_platform_reports', 'analytics.export_platform_reports',
        ],

        // Farm roles (authorization further scoped by farm membership)
        'farm_owner' => ['farm.view', 'farm.manage', 'farm.delete', 'member.manage', 'animal.*', 'batch.*', 'health.*', 'vaccination.*', 'breeding.*', 'production.*', 'feed.*', 'inventory.*', 'finance.*', 'sales.*', 'purchase.*', 'task.*', 'report.view', 'report.export', 'marketplace.listing.view', 'marketplace.listing.create', 'marketplace.listing.update', 'marketplace.listing.delete', 'marketplace.order.view', 'marketplace.order.create', 'vetservice.vet.search', 'vetservice.vet.book', 'training.course.view', 'training.course.enroll', 'community.forum.view', 'community.forum.post', 'community.forum.comment'],
        'farm_manager' => ['farm.view', 'farm.manage', 'member.manage', 'animal.*', 'batch.*', 'health.*', 'vaccination.*', 'breeding.*', 'production.*', 'feed.*', 'inventory.*', 'finance.view', 'finance.create', 'finance.update', 'sales.*', 'purchase.*', 'task.*', 'report.view', 'report.export', 'marketplace.listing.view', 'marketplace.listing.create', 'marketplace.listing.update', 'marketplace.order.view', 'vetservice.vet.search', 'vetservice.vet.book', 'training.course.view', 'training.course.enroll', 'community.forum.view', 'community.forum.post', 'community.forum.comment'],
        'accountant' => ['farm.view', 'finance.*', 'sales.view', 'sales.update', 'purchase.view', 'production.view', 'report.view', 'report.export'],
        'veterinarian' => ['farm.view', 'animal.view', 'batch.view', 'health.*', 'vaccination.*', 'breeding.view', 'production.view', 'report.view'],
        'storekeeper' => ['farm.view', 'inventory.*', 'feed.view', 'feed.create', 'feed.update', 'purchase.view', 'production.view', 'report.view'],
        'field_worker' => ['farm.view', 'animal.view', 'animal.create', 'animal.update', 'batch.view', 'batch.update', 'health.view', 'health.create', 'vaccination.view', 'vaccination.create', 'production.view', 'production.create', 'feed.view', 'feed.create', 'task.view', 'task.update'],
        'sales_officer' => ['farm.view', 'sales.*', 'production.view', 'report.view', 'marketplace.listing.view', 'marketplace.listing.create', 'marketplace.listing.update', 'marketplace.order.view'],
        'viewer' => ['farm.view', 'animal.view', 'batch.view', 'health.view', 'vaccination.view', 'breeding.view', 'production.view', 'feed.view', 'inventory.view', 'finance.view', 'sales.view', 'purchase.view', 'task.view', 'report.view'],

        // Community / service roles
        'farmer' => ['marketplace.listing.view', 'marketplace.listing.create', 'marketplace.order.view', 'marketplace.order.create', 'vetservice.vet.search', 'vetservice.vet.book', 'training.course.view', 'training.course.enroll', 'community.forum.view', 'community.forum.post', 'community.forum.comment'],
        'buyer' => ['marketplace.listing.view', 'marketplace.order.view', 'marketplace.order.create', 'community.forum.view', 'community.forum.post'],
        'supplier' => ['marketplace.listing.view', 'marketplace.listing.create', 'marketplace.listing.update', 'marketplace.order.view', 'community.forum.view'],
        'trainer' => ['training.course.view', 'training.course.manage', 'community.forum.view'],
        'extension_officer' => ['training.course.view', 'community.forum.view', 'community.forum.post', 'community.forum.comment'],
        'transporter' => ['marketplace.listing.view', 'marketplace.listing.create', 'community.forum.view'],
        'financial_institution' => ['community.forum.view'],
        'insurer' => ['community.forum.view'],
        'cooperative' => ['marketplace.listing.view', 'marketplace.listing.create', 'community.forum.view', 'community.forum.post'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Farm member permission presets (farm_members.permissions)
    |--------------------------------------------------------------------------
    */
    'farm_member_presets' => [
        'manage' => ['view', 'add', 'edit', 'approve', 'delete', 'export', 'sell', 'purchase'],
        'record' => ['view', 'add'],
        'view' => ['view'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currencies
    |--------------------------------------------------------------------------
    */
    'currencies' => [
        'UGX' => ['label' => 'Uganda Shilling', 'symbol' => 'USh', 'code' => 'UGX', 'locale' => 'en-UG'],
        'KES' => ['label' => 'Kenyan Shilling', 'symbol' => 'KSh', 'code' => 'KES', 'locale' => 'en-KE'],
        'TZS' => ['label' => 'Tanzanian Shilling', 'symbol' => 'TSh', 'code' => 'TZS', 'locale' => 'en-TZ'],
        'RWF' => ['label' => 'Rwandan Franc', 'symbol' => 'FRw', 'code' => 'RWF', 'locale' => 'en-RW'],
        'USD' => ['label' => 'US Dollar', 'symbol' => '$', 'code' => 'USD', 'locale' => 'en-US'],
        'EUR' => ['label' => 'Euro', 'symbol' => '€', 'code' => 'EUR', 'locale' => 'en-GB'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public site navigation
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        ['label' => 'Knowledge Centre', 'route' => 'knowledge.index', 'icon' => 'book'],
        ['label' => 'Marketplace', 'route' => 'marketplace', 'icon' => 'bag'],
        ['label' => 'Find a Vet', 'route' => 'find-vet', 'icon' => 'heart-pulse'],
        ['label' => 'Training', 'route' => 'training', 'icon' => 'academy'],
        ['label' => 'Community', 'route' => 'community', 'icon' => 'community'],
        ['label' => 'Market Prices', 'route' => 'market-prices', 'icon' => 'cash'],
        ['label' => 'About', 'route' => 'about', 'icon' => 'sparkles'],
    ],

    'knowledge_categories' => [
        ['key' => 'livestock', 'label' => 'Livestock', 'icon' => 'cow', 'description' => 'Cattle, goats, sheep and more', 'url' => '/knowledge/livestock'],
        ['key' => 'poultry', 'label' => 'Poultry', 'icon' => 'chicken', 'description' => 'Layers, broilers, turkeys and ducks', 'url' => '/knowledge/poultry'],
        ['key' => 'fish-farming', 'label' => 'Fish Farming', 'icon' => 'fish', 'description' => 'Ponds, cages and water quality', 'url' => '/knowledge/fish-farming'],
        ['key' => 'crop-farming', 'label' => 'Crop Farming', 'icon' => 'grain', 'description' => 'Cereals, vegetables, fruits and agronomy', 'url' => '/knowledge/crop-farming'],
        ['key' => 'animal-health', 'label' => 'Animal Health', 'icon' => 'heart-pulse', 'description' => 'Diseases, vaccination and treatment', 'url' => '/knowledge/animal-health'],
        ['key' => 'farm-management', 'label' => 'Farm Management', 'icon' => 'tools', 'description' => 'Records, budgeting and daily ops', 'url' => '/knowledge/farm-management'],
    ],

];
