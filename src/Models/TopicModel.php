<?php

namespace SuperView\Models;

class TopicModel extends BaseModel
{
    /**
     * 专题推荐
     *
     * @param int $showzt
     * @param int $classid
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function good($showzt = 0, $classid = 0 , $limit = 0, $order = 'addtime')
    {
        $page = $this->getCurrentPage();
        return $this->dal['zt']->getGood($showzt, $classid, $page, $limit, $order);
    }

    /**
     * 专题列表
     */
    public function index($zcid = 0, $classid = 0, $limit = 0, $order = 'addtime')
    {
        $page = $this->getCurrentPage();
        return $this->dal['zt']->getList($zcid, $classid, $page, $limit, $order);
    }

    /**
     * index查询结果的总个数
     */
    public function indexCount($zcid = 0, $classid = 0, $limit = 0, $order = 'addtime')
    {
        $page = $this->getCurrentPage();
        $data = $this->dal['zt']->getList($zcid, $classid, $page, $limit, $order);
        if(empty($data['count'])){
            return -1;
        }
        return $data['count'];
    }

    /**
     * 专题详情
     */
    public function info($id, $path = '')
    {
        if (empty($id) && empty($path)) {
            return false;
        }
        $data = $this->dal['zt']->getInfo($id, $path);
        return $data;
    }

    /**
     * 专题分类列表
     */
    public function categories()
    {
        $categories = $this->dal['zt']->getCategories();
        return $categories;
    }

    public function taginfo($ztid,$classid,$limit)
    {
        $page = $this->getCurrentPage();
        return $this->dal['zt']->taginfo($ztid, $classid, $page, $limit);
    }
    /**
     * 详情页定制接口 todo 测试方法待删除
     *
     * @param $id
     * @param string $model
     * @param int $baikelimit
     * @param int $softlimit
     * @return mixed
     */
    public function specials($id, $model = 'soft',$baikelimit = 5, $softlimit = 8)
    {
        $data = $this->dal['zt']->getSpecials($id, $model, $baikelimit, $softlimit);
        foreach ($data AS $key => $datum){
            $data[$key] = $this->addListInfo($datum);
        }
        return $data;

    }


    /**
     * 专题信息列表, 无法指定频道, 使用该方法获取该专题下的所有频道的内容.
     */
    public function superTopic($ztid = 0, $limit = 0)
    {
        if (empty($ztid)) {
            return false;
        }
        $page = $this->getCurrentPage();
        return $this->dal['zt']->getContentByTopicId($ztid, $page, $limit);
    }

    /**
     *
     * ios/安卓 列表页专题定制方法
     *
     * @param int $classid
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function recentInClass($classid = 0 , $limit = 0, $order = 'addtime')
    {
        return $this->dal['zt']->recentInClass($classid, $limit, $order);
    }

    /**
     * DNB 详情页专题定制方法 （通过软件id和classid获取列表）
     *
     * @param $id
     * @param $classid
     * @param $limit
     * @return mixed
     */
    public function listInIdClassId($id = 0, $classid = 0, $limit = 0)
    {
        return $this->dal['zt']->getListInIdClassId($id, $classid, $limit);
    }
}
