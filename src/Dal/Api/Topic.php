<?php

namespace SuperView\Dal\Api;

/**
* Topic Dal.
*/
class Topic extends Base
{

    // 覆盖virtualDal.
    public function __construct($virtualDal)
    {
        parent::__construct($virtualDal);
        //$this->virtualDal = 'zt';
    }

    /**
     *专题推荐
     *
     * @param $showzt
     * @param $classid
     * @param $page
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getGood($showzt, $classid, $page, $limit, $order)
    {
        $params = [
            'showzt'  => ($showzt),
            'classid'   => ($classid),
            'page'  => intval($page),
            'limit' => intval($limit),
            'order' => $order,
        ];
        return $this->getData('good', $params);
    }

    /**
     * 专题列表
     * @return boolean | array
     */
    public function getList($zcid, $classid, $page, $limit, $order)
    {
        $params = [
            'zcid'  => ($zcid),
            'cid'   => ($classid),
            'page'  => intval($page),
            'limit' => intval($limit),
            'order' => $order,
        ];
        return $this->getData('index', $params);
    }

    /**
     * 专题详情
     * @return boolean | array
     */
    public function getInfo($id, $path)
    {
        $params = [
            'id'   => intval($id),
            'path' => $path,
        ];
        return $this->getData('info', $params);
    }

    /**
     * 专题分类列表
     * @return boolean | array
     */
    public function getCategories()
    {
        $categories = $this->getData('categories')['list'];
        foreach ($categories as $category) {
            $categoryIndex[$category['classid']] = $category;
        }
        return $categoryIndex;
    }


    /**
     * 专题信息列表
     * @return boolean | array
     */
    public function getContentByTopicId($ztid, $page, $limit)
    {
        $params = [
            'ztid'  => intval($ztid),
            'page'  => intval($page),
            'limit' => intval($limit),
        ];
        return $this->getData('superTopic', $params);
    }

    /**
     * 与专题相同tag的信息列表
     *
     */
    public function taginfo($ztid, $classid, $page, $limit)
    {
        $params = [
            'ztid'  => intval($ztid),
            'classid'  => intval($classid),
            'page'  => intval($page),
            'limit' => intval($limit),
        ];
        return $this->getData('taginfo', $params);
    }
    /**
     * 详情页定制接口
     *
     * @param $id
     * @param $baikelimit
     * @param $softlimit
     * @return array|bool
     */
    public function getSpecials($id, $model, $baikelimit, $softlimit)
    {
        $params = [
            'id'    => $id,
            'model' => $model,
            'baikelimit' => $baikelimit,
            'softlimit' => $softlimit,
        ];
        return $this->getData('specials', $params);
    }

    /**
     * ios/安卓 列表页专题定制方法
     *
     * @param $classid
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function recentInClass($classid, $limit, $order)
    {
        $params = [
            'classid'  => $classid,
            'limit' => $limit,
            'order' => $order,
        ];
        return $this->getData('recentInClass', $params);
    }

    /**
     * DNB 详情页专题定制方法 （通过软件id和classid获取列表）
     *
     * @param $id
     * @param $classid
     * @param $limit
     * @return array|bool
     */
    public function getListInIdClassId($id, $classid, $limit)
    {
        $params = [
            'classid'  => $classid,
            'limit' => $limit,
            'id' => $id,
        ];
        return $this->getData('listInIdClassId', $params);
    }

    /**
     *自定义参数请求（参数和值数量必须对应，仅专题可用）
     *
     * @param $fileds
     * @param $limit
     * @param $order
     * @param $database
     * @return array|bool
     */
    public function getMathZt($fileds, $limit, $order, $database)
    {
        $params = [
            'fileds'  => $fileds,
            'limit' => $limit,
            'order' => $order,
            'database' => $database,
        ];
        return $this->getData('mathZt', $params);
    }

    /**
     * 自定参数请求（针对单个参数）
     *
     * @param $fileds
     * @param $value
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getMatch($filed, $value, $limit, $order)
    {
        $params = [
            'filed'  => $filed,
            'value'  => $value,
            'limit' => $limit,
            'order' => $order,
        ];
        return $this->getData('match', $params);
    }
}
