<?php


namespace Hanson\LaravelAdminWechat\Models;


use Hanson\LaravelAdminWechat\Facades\ConfigService;
use Illuminate\Database\Eloquent\Model;

class WechatCoupon extends Model
{
    public function paginate()
    {
        $perPage = request('per_page', 20);

        $page = request('page', 1);

        $start = ($page-1) * $perPage;

        $app = ConfigService::getAdminCurrentApp();

        $result = $app->card->list($start, $perPage, request('status'));

        if ($result['errcode'] != 0) {
            throw new \Exception($result['errmsg']);
        }

        $data = file_get_contents("https://api.douban.com/v2/movie/in_theaters?city=上海&start=$start&count=$perPage");

        $data = json_decode($data, true);

        extract($data);

        $movies = static::hydrate($subjects);

        $paginator = new LengthAwarePaginator($movies, $total, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }

    // 覆盖`orderBy`来收集排序的字段和方向
    public function orderBy($column, $direction = 'asc')
    {

    }

    // 覆盖`where`来收集筛选的字段和条件
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {

    }
}
