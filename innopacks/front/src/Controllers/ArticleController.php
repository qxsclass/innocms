<?php
/**
 * Copyright (c) Since 2024 InnoCMS - All Rights Reserved
 *
 * @link       https://www.innocms.com
 * @author     InnoCMS <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoCMS\Front\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InnoCMS\Common\Repositories\ArticleRepo;
use InnoCMS\Common\Repositories\CatalogRepo;
use InnoCMS\Common\Repositories\TagRepo;

class ArticleController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function index(): mixed
    {
        $data = [
            'articles' => ArticleRepo::getInstance()->list(['active' => true]),
            'catalogs' => CatalogRepo::getInstance()->list(['active' => true]),
            'tags'     => TagRepo::getInstance()->list(['active' => true]),
        ];

        return view('front::articles.index', $data);
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws \Exception
     */
    public function show(Request $request): mixed
    {
        $slug    = $request->slug;
        $article = ArticleRepo::getInstance()->builder(['active' => true])->where('slug', $slug)->firstOrFail();
        $article->increment('viewed');
        $data = [
            'slug'     => $slug,
            'article'  => $article,
            'catalogs' => CatalogRepo::getInstance()->list(['active' => true]),
        ];

        return view('front::articles.show', $data);
    }
}
