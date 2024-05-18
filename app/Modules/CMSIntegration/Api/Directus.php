<?php

declare(strict_types=1);

namespace App\Modules\CMSIntegration\Api;

use App\Modules\CMSIntegration\Services\DirectusApi;

class Directus
{
    final public function __construct(protected string $collectionName, protected DirectusApi $httpClient)
    {
    }

    /**
     * Returns an instance of Assets or Items based on the collection name.
     *
     * @param string $collectionName The name of the collection.
     * @return Assets|Items Returns Assets if the collection name is 'assets',
     *                      otherwise returns Items.
     */
    public static function collection(string $collectionName): Assets|Items
    {
        $directusApi = resolve(DirectusApi::class);

        return match ($collectionName) {
            'assets' => new Assets($directusApi),
            default => new Items($directusApi, $collectionName),
        };
    }
}
