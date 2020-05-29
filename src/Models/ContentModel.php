<?php

namespace SuperView\Models;

class ContentModel extends BaseModel
{

    /**
     * 获取信息详情.
     */
    public function info($id = 0)
    {
        $data = $this->dal()->getInfo($id);
        return $data;
    }

    /**
     * 最新信息列表.
     */
    public function recent($classid = 0, $limit = 0, $isPic = 0)
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getRecentList($classid, $page, $limit, $isPic);
    }

    /**
     * 推荐信息列表.
     */
    public function good($level = 0, $classid = 0, $limit = 0, $isPic = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getLevelList('isgood', $classid, $page, $limit, $isPic, $level, $order);
    }

    /**
     *  排序信息列表
     */
    public function order($classid = 0, $limit = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getOrderList($classid, $page, $limit, $order);
    }

    /**
     * 置顶信息列表.
     */
    public function top($level = 0, $classid = 0, $limit = 0, $isPic = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getLevelList('top', $classid, $page, $limit, $isPic, $level, $order);
    }

    /**
     * 头条信息列表.
     */
    public function firsttitle($level = 0, $classid = 0, $limit = 0, $isPic = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getLevelList('firsttitle', $classid, $page, $limit, $isPic, $level, $order);
    }

    /**
     * 信息搜索列表：根据指定字段指定值
     */
    public function match($field, $value, $classid = 0, $limit = 0, $isPic = 0, $order = 'newstime')
    {
        $field = trim($field);
        $value = trim($value);

        if (empty($field) || empty($value)) {
            return [];
        }
        $page = $this->getCurrentPage();
        return $this->dal()->getListByFieldValue($field, $value, $classid, $page, $limit, $isPic, $order);
    }

    /**
     * 数量统计.
     */
    public function count($period = 'all', $classid = 0)
    {
        $data = $this->dal()->getCount($period, $classid);
        return intval($data);
    }

    /**
     * 相同标题信息列表.
     */
    public function title($title = '', $classid = 0, $limit = 0, $isPic = 0, $order = 'newstime')
    {
        if (empty($title)) {
            return false;
        }
        $page = $this->getCurrentPage();
        return $this->dal()->getListByTitle($title, $classid, $page, $limit, $isPic, $order);
    }

    /**
     * 获取dal模型.
     *
     * @return object
     */
    private function dal()
    {
        return $this->dal['content:' . $this->virtualModel];
    }

    /**
     * 今日更新列表.
     */
    public function today($classid = 0, $limit = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getTodayList($classid, $page, $limit, $order);
    }


    /**
     * 查询classid不等于某个值
     *
     * @param int $classid
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function neq($classid = 0, $limit = 0, $order = 'newstime')
    {
        return $this->dal()->getNeq($classid, $limit, $order);
    }

    /**
     * 获取信息所属专题列表.
     */
    public function infoTopics($id = 0, $limit = 0)
    {
        if (empty($id)) {
            return false;
        }
        return $this->dal()->getInfoTopics($id, $limit);
    }

    /**
     * 攻略列表
     *
     * @param int $game_id
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function strategy($game_id = 0, $limit = 0, $order = 'lastdotime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getStrategy($game_id, $page, $limit, $order);
    }

    /**
     * 自定义参数请求（参数和值数量必须对应）
     *
     * @param $fileds
     * @param $values
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function customList($fields, $limit = 0, $order = 'lastdotime', $operator = 'and')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getCustomList($fields, $limit, $order, $page, $operator);
    }

    /**
     * 获取评论
     *
     * @param int $softid
     * @param int $checked
     * @param int $limit
     * @return mixed
     */
    public function getPl($softid = 0, $checked = 0, $limit = 0)
    {
        return $this->dal()->getPl($softid, $checked, $limit);
    }

    /**
     * 获取所有评论
     *
     * @param $id
     * @param string $order
     * @return mixed
     */
    public function getAllPl($id, $order = 'saytime')
    {
        return $this->dal()->getAllPl($id, $order);
    }

    /**
     * 内联词数据获取（4个关键词）
     *
     * @param string $classid
     * @param int $limit
     * @return mixed
     */
    public function getHotSearchForClass(string $classid = '', int $limit = 0)
    {
        return $this->dal()->getHotSearchForClass($classid, $limit);
    }

    /**
     * 特殊条件查询（and | or 同时存在）
     *
     * @param string $where
     * @param string $order
     * @param int|int $limit
     * @return mixed
     *
     */
    public function matchQuery($type = 0, int $limit = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getMatchQuery($type, $limit, $order, $page);
    }

    /**
     * 关联查询的order方法
     *
     * @param string $table
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function allOrder(string $table = '', int $limit = 0, $order = 'newstime')
    {
        $page = $this->getCurrentPage();
        return $this->dal()->getAllOrder($table, $limit, $order, $page);
    }

    /**
     * 预定义数据查询关联表 用于特殊数据获取
     *
     * @param int $type
     * @return mixed
     */
    public function matchJoinQuery($type = 1)
    {
        return $this->dal()->matchJoinQuery($type);
    }
}
