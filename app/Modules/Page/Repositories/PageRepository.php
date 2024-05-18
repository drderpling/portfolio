<?php

declare(strict_types=1);

namespace App\Modules\Page\Repositories;

use App\Modules\CMSIntegration\Repositories\ContentRepository;
use App\Modules\Page\Models\Page;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class PageRepository extends ContentRepository
{
    /**
     * @var class-string<Page>
     */
    protected string $modelClass = Page::class;

    /**
     * @param array $data
     * @return Page
     */
    public function updateOrCreate(array $data): Page
    {
        $hydratedData = $this->prepareData($data, ['name', 'type', 'slug', 'content', 'status', 'cms_id']);
        $cmsId = Arr::get($data, 'cms_id');

        if (!$cmsId) {
            throw new InvalidArgumentException('cms_id is required');
        }

        return $this->modelClass::updateOrCreate(['cms_id' => $cmsId], $hydratedData);
    }
}
