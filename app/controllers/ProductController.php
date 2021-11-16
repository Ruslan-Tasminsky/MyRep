<?php

namespace app\controllers;

use app\models\BreadcrumbsModel;
use app\models\ProductModel;

class ProductController extends AppController
{
    public function viewAction()
    {
        //Стиль карточки продуктов
        $alias = $this->route["alias"];
        $product = \R::findOne("product", "alias = ? AND status = '1'", [$alias]);
        if (!$product) {
            throw new \Exception('Страница не найдена', 404);
        }
        //Хлебные крошки
        $breadcrumbs = BreadcrumbsModel::getBreadcrumbs($product->category_id, $product->title);
        //Связаные товары
        $related = \R::getAll("SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);
        $p_model = new ProductModel();
        $p_model->setRecentlyViewed($product->id);
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($r_viewed) {
            $recentlyViewed = \R::find("product", "id IN (" . \R::genSlots($r_viewed) . ") LIMIT 3", $r_viewed);
        }
        //галерея
        $gallery = \R::findAll("gallery", "product_id = ?", [$product->id]);
        //Модификации
        $mods = \R::findAll("modification", "product_id = ?", [$product->id]);
        $this->setMeta($product->title, $product->descripton, $product->keywords);
        $this->set(compact("product", "related", "gallery", "recentlyViewed", "breadcrumbs", "mods"));
    }
}
