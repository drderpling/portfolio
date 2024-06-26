<?php

declare(strict_types=1);

namespace App\Modules\Package\Repositories;

use App\Modules\Package\Models\Package;
use App\Modules\Package\Services\RepoDataEnrichService;
use DrDerpling\DirectusRepository\Api\Directus;
use DrDerpling\DirectusRepository\Factories\ContextFactory;
use DrDerpling\DirectusRepository\Repositories\Context;
use DrDerpling\DirectusRepository\Repositories\DirectusRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageRepository extends DirectusRepository
{
    public function __construct(private RepoDataEnrichService $repoDataEnrichService)
    {
    }

    public function getContext(): Context
    {
        return ContextFactory::create(Package::class);
    }


    protected function prepareData(array $data): Collection
    {
        $collection = parent::prepareData($data);

        $disk = Storage::disk('public');
        $fileName = 'skills/' . Str::slug($collection->get('name')) . '.webp'; // Don't really care if this overwrites

        Directus::assets()
            ->addQueryParameter('fit', 'cover')
            ->addQueryParameter('width', '1400')
            ->addQueryParameter('height', '600')
            ->addQueryParameter('quality', ' 100')
            ->addQueryParameter('format', 'webp')
            ->addQueryParameter('download', '1')
            ->download($collection->get('image', ''), $disk, $fileName);

        $this->repoDataEnrichService->enrich($collection);

        $collection->put('image', $fileName);

        return $collection;
    }
}
